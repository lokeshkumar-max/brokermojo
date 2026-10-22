<?php
/**
 * First-run import: creates the Home page, sets it as the front page and
 * fills every field with the original content (images go into the Media
 * Library), so the editor opens on a page that already matches the design.
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

/**
 * On activation: make sure a static Home page exists and is the front page.
 */
add_action( 'after_switch_theme', 'bm_setup_front_page' );

function bm_setup_front_page() {
	$front = (int) get_option( 'page_on_front' );
	if ( 'page' === get_option( 'show_on_front' ) && $front && 'trash' !== get_post_status( $front ) && get_post( $front ) ) {
		return;
	}
	$page_id = wp_insert_post(
		array(
			'post_title'   => 'Home',
			'post_name'    => 'home',
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_content' => '',
		)
	);
	if ( $page_id && ! is_wp_error( $page_id ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $page_id );
	}
}

/**
 * Lazy import — runs in the admin as soon as ACF is active and the front
 * page has no BrokerMojo content yet (covers "ACF installed after the theme").
 */
add_action( 'admin_init', 'bm_maybe_seed', 20 );

function bm_maybe_seed() {
	if ( wp_doing_ajax() || ! bm_acf_ready() || ! current_user_can( 'edit_pages' ) ) {
		return;
	}
	$pid = (int) get_option( 'page_on_front' );
	if ( ! $pid || 'page' !== get_option( 'show_on_front' ) || ! get_post( $pid ) ) {
		return;
	}
	if ( get_post_meta( $pid, '_bm_seeded', true ) ) {
		return;
	}
	foreach ( array_keys( bm_schema() ) as $key ) {
		if ( bm_section_saved( $key, $pid ) ) {
			// Someone already saved content here — never overwrite it.
			update_post_meta( $pid, '_bm_seeded', 'existing' );
			if ( ! get_post_meta( $pid, '_bm_list_mode', true ) ) {
				update_post_meta( $pid, '_bm_list_mode', bm_list_mode() );
			}
			return;
		}
	}
	bm_seed( $pid );
}

/**
 * Writes content into every section of a page.
 *
 * @param int        $pid  Page ID.
 * @param array|null $data Normalised content per section; null = the original content.
 */
function bm_seed( $pid, $data = null ) {
	if ( ! bm_acf_ready() || ! $pid ) {
		return false;
	}
	if ( function_exists( 'set_time_limit' ) ) {
		@set_time_limit( 180 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors -- image import can take a moment.
	}
	$mode = bm_list_mode();

	foreach ( bm_schema() as $key => $section ) {
		if ( null === $data ) {
			$defaults = isset( bm_defaults()[ $key ] ) ? bm_defaults()[ $key ] : array();
			$norm     = bm_norm_fields( $section['fields'], $defaults, $defaults, null );
		} else {
			$norm = isset( $data[ $key ] ) ? $data[ $key ] : array();
		}
		$value = bm_seed_fields( $section['fields'], $norm, $mode );
		update_field( 'field_bm_' . $key, $value, $pid );
	}

	update_post_meta( $pid, '_bm_seeded', gmdate( 'c' ) );
	update_post_meta( $pid, '_bm_list_mode', $mode );
	return true;
}

/** Normalised content → the value array ACF's update_field() expects. */
function bm_seed_fields( $defs, $norm, $mode ) {
	$out = array();
	foreach ( $defs as $d ) {
		$v                 = ( is_array( $norm ) && array_key_exists( $d['name'], $norm ) ) ? $norm[ $d['name'] ] : null;
		$out[ $d['name'] ] = bm_seed_value( $d, $v, $mode );
	}
	return $out;
}

function bm_seed_value( $d, $v, $mode ) {
	switch ( $d['type'] ) {
		case 'bool':
			return $v ? 1 : 0;

		case 'lines':
			return is_array( $v ) ? implode( "\n", $v ) : (string) $v;

		case 'paras':
			return is_array( $v ) ? implode( "\n\n", $v ) : (string) $v;

		case 'image':
			if ( empty( $v ) ) {
				return '';
			}
			if ( ! empty( $v['id'] ) ) {
				return (int) $v['id'];
			}
			return ! empty( $v['file'] ) ? bm_import_asset( $v['file'], isset( $v['alt'] ) ? $v['alt'] : '' ) : '';

		case 'file':
			if ( ! $v ) {
				return '';
			}
			$id = attachment_url_to_postid( $v );
			return $id ? $id : '';

		case 'group':
			return bm_seed_fields( $d['sub'], is_array( $v ) ? $v : array(), $mode );

		case 'fixed':
			$out = array();
			for ( $i = 1; $i <= $d['count']; $i++ ) {
				$row                 = ( is_array( $v ) && isset( $v[ $i - 1 ] ) ) ? $v[ $i - 1 ] : array();
				$out[ 'item_' . $i ] = bm_seed_fields( $d['sub'], $row, $mode );
			}
			return $out;

		case 'repeater':
			$rows = is_array( $v ) ? array_values( $v ) : array();
			if ( 'repeater' === $mode ) {
				$out = array();
				foreach ( array_slice( $rows, 0, $d['max'] ) as $row ) {
					$out[] = bm_seed_fields( $d['sub'], $row, $mode );
				}
				return $out;
			}
			$out = array();
			for ( $i = 1; $i <= $d['max']; $i++ ) {
				if ( isset( $rows[ $i - 1 ] ) ) {
					$out[ 'item_' . $i ] = array_merge( array( '_show' => 1 ), bm_seed_fields( $d['sub'], $rows[ $i - 1 ], $mode ) );
				} else {
					$out[ 'item_' . $i ] = array( '_show' => 0 );
				}
			}
			return $out;

		case 'number':
			return '' === $v || null === $v ? '' : (int) $v;

		default:
			return null === $v ? '' : (string) $v;
	}
}

/**
 * Copies one of the theme's images into the Media Library (once) and
 * returns its attachment ID.
 */
function bm_import_asset( $file, $alt = '' ) {
	$file = basename( $file );
	$map  = get_option( 'bm_asset_map', array() );
	if ( ! empty( $map[ $file ] ) && 'attachment' === get_post_type( $map[ $file ] ) ) {
		return (int) $map[ $file ];
	}

	$src = BM_DIR . '/assets/images/' . $file;
	if ( ! file_exists( $src ) ) {
		return '';
	}

	$upload = wp_upload_bits( $file, null, file_get_contents( $src ) ); // phpcs:ignore WordPress.WP.AlternativeFunctions -- local theme file.
	if ( ! empty( $upload['error'] ) ) {
		return '';
	}

	$type = wp_check_filetype( $upload['file'] );
	$id   = wp_insert_attachment(
		array(
			'post_mime_type' => $type['type'],
			'post_title'     => sanitize_text_field( pathinfo( $file, PATHINFO_FILENAME ) ),
			'post_content'   => '',
			'post_status'    => 'inherit',
			'guid'           => $upload['url'],
		),
		$upload['file']
	);
	if ( ! $id || is_wp_error( $id ) ) {
		return '';
	}

	require_once ABSPATH . 'wp-admin/includes/image.php';
	wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );
	if ( '' !== $alt ) {
		update_post_meta( $id, '_wp_attachment_image_alt', sanitize_text_field( $alt ) );
	}

	$map[ $file ] = $id;
	update_option( 'bm_asset_map', $map, false );
	return (int) $id;
}

/**
 * Re-reads the page in whichever layout it was stored and writes it back in
 * the layout of the active plugin (e.g. after switching free ACF → ACF PRO).
 */
function bm_convert_lists( $pid ) {
	$stored = get_post_meta( $pid, '_bm_list_mode', true );
	if ( ! $stored || bm_list_mode() === $stored ) {
		return false;
	}
	$data = array();
	foreach ( bm_schema() as $key => $section ) {
		$defaults     = isset( bm_defaults()[ $key ] ) ? bm_defaults()[ $key ] : array();
		$raw          = bm_raw_fields( $section['fields'], $key . '_', $pid, $stored );
		$data[ $key ] = bm_norm_fields( $section['fields'], $raw, $defaults, $stored );
	}
	return bm_seed( $pid, $data );
}
