<?php
/**
 * Data layer — reads a section's content from the Home page's ACF fields
 * and hands the templates one predictable array shape, whatever plugin
 * (ACF PRO, SCF, free ACF, or none) is active.
 *
 * Normalised shapes:
 *   text / textarea / svg / select / number  → string
 *   bool                                     → bool
 *   lines / paras                            → list of strings
 *   image  → array( id, file, url, alt ) or null
 *   file   → URL string
 *   group  → assoc array
 *   fixed / repeater                         → list of assoc arrays
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

/** The original content (inc/defaults.php). */
function bm_defaults() {
	static $d = null;
	if ( null === $d ) {
		$d = require BM_DIR . '/inc/defaults.php';
	}
	return $d;
}

/** ID of the page whose fields drive the site (the static front page). */
function bm_home_id() {
	if ( is_front_page() && is_page() ) {
		return (int) get_queried_object_id();
	}
	return (int) get_option( 'page_on_front' );
}

/** Has this page ever stored the section? */
function bm_section_saved( $key, $pid ) {
	return $pid && metadata_exists( 'post', $pid, $key );
}

/**
 * One section, normalised. Falls back to the original content when ACF is
 * off or the section has never been saved, so the design never breaks.
 */
function bm_section( $key ) {
	static $cache = array();
	if ( isset( $cache[ $key ] ) ) {
		return $cache[ $key ];
	}

	$schema = bm_schema();
	if ( ! isset( $schema[ $key ] ) ) {
		return array();
	}
	$defs     = $schema[ $key ]['fields'];
	$defaults = isset( bm_defaults()[ $key ] ) ? bm_defaults()[ $key ] : array();
	$pid      = bm_home_id();

	if ( bm_acf_ready() && bm_section_saved( $key, $pid ) ) {
		$stored_mode = get_post_meta( $pid, '_bm_list_mode', true );
		if ( $stored_mode && bm_list_mode() !== $stored_mode ) {
			// Content was saved with the other list storage (repeater plugin added or
			// removed since). Read it the way it was stored until it is converted.
			$raw = bm_raw_fields( $defs, $key . '_', $pid, $stored_mode );
			$out = bm_norm_fields( $defs, $raw, $defaults, $stored_mode );
		} else {
			$val = get_field( $key, $pid );
			$out = bm_norm_fields( $defs, is_array( $val ) ? $val : array(), $defaults, bm_list_mode() );
		}
	} else {
		$out = bm_norm_fields( $defs, $defaults, $defaults, null );
	}

	$cache[ $key ] = apply_filters( 'bm_section_' . $key, $out );
	return $cache[ $key ];
}

/** A single Brand & Contact value. */
function bm_opt( $name ) {
	$g = bm_section( 'global' );
	return isset( $g[ $name ] ) ? $g[ $name ] : '';
}

/**
 * Normalise a set of fields.
 *
 * @param array       $defs      Schema definitions.
 * @param array       $val       Values (ACF formatted values, raw meta, or defaults).
 * @param array       $dv        Default values for the same level (image fallback).
 * @param string|null $list_mode "repeater" | "slots" for ACF data, null for defaults.
 */
function bm_norm_fields( $defs, $val, $dv, $list_mode ) {
	$out = array();
	foreach ( $defs as $d ) {
		$n         = $d['name'];
		$v         = ( is_array( $val ) && array_key_exists( $n, $val ) ) ? $val[ $n ] : null;
		$dd        = ( is_array( $dv ) && array_key_exists( $n, $dv ) ) ? $dv[ $n ] : null;
		$out[ $n ] = bm_norm_value( $d, $v, $dd, $list_mode );
	}
	return $out;
}

function bm_norm_value( $d, $v, $dv, $list_mode ) {
	$from_defaults = ( null === $list_mode );

	switch ( $d['type'] ) {
		case 'bool':
			return (bool) $v;

		case 'number':
			return ( '' === $v || null === $v || false === $v ) ? '' : (string) (int) $v;

		case 'lines':
			if ( $from_defaults ) {
				return is_array( $v ) ? array_values( $v ) : array();
			}
			$lines = preg_split( '/\r\n|\r|\n/', (string) $v );
			return array_values( array_filter( array_map( 'trim', $lines ), 'strlen' ) );

		case 'paras':
			if ( $from_defaults ) {
				return is_array( $v ) ? array_values( $v ) : ( $v ? array( (string) $v ) : array() );
			}
			$paras = preg_split( '/(\r\n|\r|\n)\s*(\r\n|\r|\n)/', trim( (string) $v ) );
			return array_values( array_filter( array_map( 'trim', $paras ), 'strlen' ) );

		case 'image':
			if ( ! $from_defaults ) {
				$img = bm_image_from_id( $v );
				if ( $img ) {
					return $img;
				}
			}
			// Empty image → the original artwork, so a layout never loses its picture.
			return bm_image_from_default( $dv );

		case 'file':
			if ( is_numeric( $v ) && $v ) {
				$u = wp_get_attachment_url( (int) $v );
				return $u ? $u : '';
			}
			if ( is_array( $v ) ) {
				return isset( $v['url'] ) ? (string) $v['url'] : '';
			}
			return (string) $v;

		case 'group':
			return bm_norm_fields( $d['sub'], is_array( $v ) ? $v : array(), $dv, $list_mode );

		case 'fixed':
			$items = array();
			for ( $i = 1; $i <= $d['count']; $i++ ) {
				$dvi = ( is_array( $dv ) && isset( $dv[ $i - 1 ] ) ) ? $dv[ $i - 1 ] : array();
				if ( $from_defaults ) {
					$vi = $dvi;
				} else {
					$vi = ( is_array( $v ) && isset( $v[ 'item_' . $i ] ) ) ? $v[ 'item_' . $i ] : array();
				}
				$items[] = bm_norm_fields( $d['sub'], $vi, $dvi, $list_mode );
			}
			return $items;

		case 'repeater':
			$rows = array();
			if ( $from_defaults ) {
				$rows = is_array( $v ) ? array_values( $v ) : array();
			} elseif ( 'repeater' === $list_mode ) {
				$rows = is_array( $v ) ? array_values( $v ) : array();
			} elseif ( is_array( $v ) ) {
				for ( $i = 1; $i <= $d['max']; $i++ ) {
					$slot = isset( $v[ 'item_' . $i ] ) ? $v[ 'item_' . $i ] : null;
					if ( is_array( $slot ) && ! empty( $slot['_show'] ) ) {
						$rows[] = $slot;
					}
				}
			}
			$out = array();
			foreach ( $rows as $i => $row ) {
				$dvi   = ( is_array( $dv ) && isset( $dv[ $i ] ) ) ? $dv[ $i ] : array();
				$out[] = bm_norm_fields( $d['sub'], is_array( $row ) ? $row : array(), $dvi, $list_mode );
			}
			return $out;

		default: // text, textarea, svg, select
			if ( is_array( $v ) || is_object( $v ) ) {
				return '';
			}
			return null === $v || false === $v ? '' : (string) $v;
	}
}

/** Image array from an attachment ID (or ACF image array). */
function bm_image_from_id( $v ) {
	if ( is_array( $v ) && isset( $v['ID'] ) ) {
		$v = $v['ID'];
	}
	$id = (int) $v;
	if ( ! $id ) {
		return null;
	}
	$url = wp_get_attachment_image_url( $id, 'full' );
	if ( ! $url ) {
		return null;
	}
	return array(
		'id'   => $id,
		'file' => '',
		'url'  => $url,
		'alt'  => (string) get_post_meta( $id, '_wp_attachment_image_alt', true ),
	);
}

/** Image array from a default value (a file name inside assets/images). */
function bm_image_from_default( $dv ) {
	if ( is_array( $dv ) && isset( $dv['url'] ) ) { // already normalised
		return $dv;
	}
	if ( ! is_array( $dv ) || empty( $dv['file'] ) ) {
		return null;
	}
	return array(
		'id'   => 0,
		'file' => $dv['file'],
		'url'  => BM_URI . '/assets/images/' . $dv['file'],
		'alt'  => isset( $dv['alt'] ) ? (string) $dv['alt'] : '',
	);
}

/**
 * Reads a section straight from post meta, in the layout ACF uses for the
 * given list mode. Used when the stored layout differs from the active one.
 */
function bm_raw_fields( $defs, $prefix, $pid, $list_mode ) {
	$out = array();
	foreach ( $defs as $d ) {
		$name = $prefix . $d['name'];
		switch ( $d['type'] ) {
			case 'group':
				$out[ $d['name'] ] = bm_raw_fields( $d['sub'], $name . '_', $pid, $list_mode );
				break;

			case 'fixed':
				$items = array();
				for ( $i = 1; $i <= $d['count']; $i++ ) {
					$items[ 'item_' . $i ] = bm_raw_fields( $d['sub'], $name . '_item_' . $i . '_', $pid, $list_mode );
				}
				$out[ $d['name'] ] = $items;
				break;

			case 'repeater':
				$rows = array();
				if ( 'repeater' === $list_mode ) {
					$count = (int) get_post_meta( $pid, $name, true );
					for ( $i = 0; $i < $count; $i++ ) {
						$rows[] = bm_raw_fields( $d['sub'], $name . '_' . $i . '_', $pid, $list_mode );
					}
				} else {
					for ( $i = 1; $i <= $d['max']; $i++ ) {
						$row          = bm_raw_fields( $d['sub'], $name . '_item_' . $i . '_', $pid, $list_mode );
						$row['_show'] = get_post_meta( $pid, $name . '_item_' . $i . '__show', true );
						$rows[ 'item_' . $i ] = $row;
					}
				}
				$out[ $d['name'] ] = $rows;
				break;

			default:
				$out[ $d['name'] ] = get_post_meta( $pid, $name, true );
		}
	}
	return $out;
}
