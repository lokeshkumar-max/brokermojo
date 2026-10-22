<?php
/**
 * Theme setup, assets, <head> tags and the Appearance → BrokerMojo page.
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'after_setup_theme',
	function () {
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );
	}
);

/* ─────────────────────────── assets ─────────────────────────── */

add_action(
	'wp_enqueue_scripts',
	function () {
		// Same font request as the static build.
		wp_enqueue_style( 'bm-fonts', 'https://fonts.googleapis.com/css2?family=Jost:wght@300;400;500&family=Inter:wght@400;500;600;700&display=swap', array(), null );
		// The original stylesheet, untouched.
		wp_enqueue_style( 'bm-main', BM_URI . '/assets/css/main.css', array( 'bm-fonts' ), BM_VER );
		if ( ! is_front_page() ) {
			wp_enqueue_style( 'bm-pages', BM_URI . '/assets/css/pages.css', array( 'bm-main' ), BM_VER );
		}
		// The original script, in the footer exactly where it sat before.
		wp_enqueue_script( 'bm-main', BM_URI . '/assets/js/main.js', array(), BM_VER, true );

	},
	20
);

/*
 * WordPress' own front-end styles (block library, global styles, classic
 * theme styles, block supports, emoji) are not part of this design. Keep
 * them off the home page so they cannot change a single pixel. Inner pages
 * keep them, so block content written in the editor still looks right.
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
add_filter( 'wp_img_tag_add_auto_sizes', '__return_false' );

add_action(
	'wp',
	function () {
		if ( ! is_front_page() ) {
			return;
		}
		remove_action( 'wp_enqueue_scripts', 'wp_enqueue_global_styles' );
		remove_action( 'wp_footer', 'wp_enqueue_global_styles', 1 );
		remove_action( 'wp_enqueue_scripts', 'wp_enqueue_classic_theme_styles' );
		remove_action( 'wp_footer', 'wp_enqueue_stored_styles', 1 );
		remove_action( 'wp_head', 'wp_print_auto_sizes_contain_css_fix', 1 );
		add_action(
			'wp_enqueue_scripts',
			function () {
				foreach ( array( 'wp-block-library', 'wp-block-library-theme', 'classic-theme-styles', 'global-styles', 'core-block-supports' ) as $h ) {
					wp_dequeue_style( $h );
				}
			},
			100
		);
	}
);

// Pre-connect to Google Fonts, as the static build did.
add_filter(
	'wp_resource_hints',
	function ( $urls, $relation ) {
		if ( 'preconnect' === $relation ) {
			$urls[] = 'https://fonts.googleapis.com';
			$urls[] = array(
				'href'        => 'https://fonts.gstatic.com',
				'crossorigin' => 'anonymous',
			);
		}
		return $urls;
	},
	10,
	2
);

/* ─────────────────────────── <head> ─────────────────────────── */

/** SEO plugins already print these tags; don't double them. */
function bm_seo_plugin_active() {
	return defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' ) || class_exists( 'The_SEO_Framework\Load' );
}

add_filter(
	'pre_get_document_title',
	function ( $title ) {
		if ( is_front_page() && ! bm_seo_plugin_active() ) {
			$t = bm_section( 'seo' )['meta_title'];
			if ( '' !== $t ) {
				return esc_html( $t );
			}
		}
		return $title;
	},
	20
);

add_action(
	'wp_head',
	function () {
		echo '<meta name="theme-color" content="#E04400">' . "\n";

		if ( ! has_site_icon() ) {
			$icon = esc_url( BM_URI . '/assets/images/favicon.png' );
			echo '<link rel="icon" type="image/png" href="' . $icon . '">' . "\n";
			echo '<link rel="apple-touch-icon" href="' . $icon . '">' . "\n";
		}

		if ( ! is_front_page() || bm_seo_plugin_active() ) {
			return;
		}
		$seo   = bm_section( 'seo' );
		$title = '' !== $seo['meta_title'] ? $seo['meta_title'] : wp_get_document_title();
		if ( '' !== $seo['meta_description'] ) {
			echo '<meta name="description" content="' . esc_attr( $seo['meta_description'] ) . '">' . "\n";
		}
		echo '<meta property="og:type" content="website">' . "\n";
		echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
		if ( '' !== $seo['meta_description'] ) {
			echo '<meta property="og:description" content="' . esc_attr( $seo['meta_description'] ) . '">' . "\n";
		}
		if ( ! empty( $seo['og_image']['url'] ) ) {
			echo '<meta property="og:image" content="' . esc_url( $seo['og_image']['url'] ) . '">' . "\n";
		}
		echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
	},
	2
);

/* The admin bar sits on top of the fixed header — off unless switched on. */
add_filter(
	'show_admin_bar',
	function ( $show ) {
		if ( is_admin() ) {
			return $show;
		}
		return $show && ! empty( bm_section( 'seo' )['show_admin_bar'] );
	}
);

/* ─────────────────────────── editor ─────────────────────────── */

/** Is $post_id the BrokerMojo home page? */
function bm_is_home_page_id( $post_id ) {
	return $post_id && 'page' === get_option( 'show_on_front' ) && (int) get_option( 'page_on_front' ) === (int) $post_id;
}

// The home page is built from fields only — give it the classic screen with
// the field tabs instead of an empty block editor.
add_filter(
	'use_block_editor_for_post',
	function ( $use, $post ) {
		return ( $post && bm_is_home_page_id( $post->ID ) && bm_acf_ready() ) ? false : $use;
	},
	10,
	2
);

add_action(
	'admin_init',
	function () {
		global $pagenow;
		$id = isset( $_GET['post'] ) ? (int) $_GET['post'] : 0; // phpcs:ignore WordPress.Security.NonceVerification
		if ( 'post.php' === $pagenow && bm_is_home_page_id( $id ) && bm_acf_ready() ) {
			remove_post_type_support( 'page', 'editor' );
		}
	}
);

/* ─────────────────────── admin notices & tools ─────────────────────── */

add_action(
	'admin_notices',
	function () {
		if ( ! current_user_can( 'edit_pages' ) ) {
			return;
		}
		if ( ! bm_acf_ready() ) {
			echo '<div class="notice notice-warning"><p><strong>BrokerMojo theme:</strong> install and activate <strong>Advanced Custom Fields PRO</strong> or <strong>Secure Custom Fields</strong> (free) to edit the home page. The site keeps showing its original content until then.</p></div>';
			return;
		}
		$pid = (int) get_option( 'page_on_front' );
		if ( 'page' !== get_option( 'show_on_front' ) || ! $pid ) {
			echo '<div class="notice notice-warning"><p><strong>BrokerMojo theme:</strong> set a static front page (Settings → Reading) — its edit screen holds all of the home page content. <a href="' . esc_url( admin_url( 'themes.php?page=brokermojo' ) ) . '">Fix this for me</a></p></div>';
			return;
		}
		$stored = get_post_meta( $pid, '_bm_list_mode', true );
		if ( $stored && bm_list_mode() !== $stored ) {
			echo '<div class="notice notice-info"><p><strong>BrokerMojo theme:</strong> your custom fields plugin changed, so lists (cards, FAQs, plans…) are stored the old way. The site still shows them correctly. <a href="' . esc_url( admin_url( 'themes.php?page=brokermojo' ) ) . '">Convert them</a> to edit them in the new layout.</p></div>';
		}
		if ( 'slots' === bm_list_mode() && isset( $_GET['post'] ) && bm_is_home_page_id( (int) $_GET['post'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			echo '<div class="notice notice-info"><p><strong>Tip:</strong> with the free ACF plugin, lists have a fixed number of slots (switch “Show” on or off). For add / remove / drag-to-reorder buttons, use <strong>ACF PRO</strong> or the free <strong>Secure Custom Fields</strong> plugin — existing content converts automatically.</p></div>';
		}
	}
);

add_action(
	'admin_menu',
	function () {
		add_theme_page( 'BrokerMojo', 'BrokerMojo', 'edit_pages', 'brokermojo', 'bm_tools_page' );
	}
);

add_action( 'admin_post_bm_tools', 'bm_tools_action' );

function bm_tools_action() {
	if ( ! current_user_can( 'edit_pages' ) ) {
		wp_die( 'Not allowed.' );
	}
	check_admin_referer( 'bm_tools' );
	$do  = isset( $_POST['bm_do'] ) ? sanitize_key( $_POST['bm_do'] ) : '';
	$msg = '';

	if ( 'front' === $do ) {
		bm_setup_front_page();
		$msg = 'front';
	}
	$pid = (int) get_option( 'page_on_front' );
	if ( 'reset' === $do && $pid && bm_acf_ready() ) {
		bm_seed( $pid );
		$msg = 'reset';
	}
	if ( 'convert' === $do && $pid && bm_acf_ready() ) {
		bm_convert_lists( $pid );
		$msg = 'convert';
	}
	wp_safe_redirect( admin_url( 'themes.php?page=brokermojo&done=' . $msg ) );
	exit;
}

function bm_tools_page() {
	$pid    = (int) get_option( 'page_on_front' );
	$ok     = 'page' === get_option( 'show_on_front' ) && $pid && get_post( $pid );
	$done   = isset( $_GET['done'] ) ? sanitize_key( $_GET['done'] ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	$stored = $ok ? get_post_meta( $pid, '_bm_list_mode', true ) : '';
	$labels = array(
		'front'   => 'Home page created and set as the front page.',
		'reset'   => 'Original content restored.',
		'convert' => 'Lists converted to the new layout.',
	);
	$form = function ( $do, $label, $class = 'button', $confirm = '' ) {
		echo '<form method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '" style="display:inline-block;margin:0 8px 8px 0"' . ( $confirm ? ' onsubmit="return confirm(\'' . esc_js( $confirm ) . '\')"' : '' ) . '>';
		wp_nonce_field( 'bm_tools' );
		echo '<input type="hidden" name="action" value="bm_tools"><input type="hidden" name="bm_do" value="' . esc_attr( $do ) . '">';
		echo '<button class="' . esc_attr( $class ) . '">' . esc_html( $label ) . '</button></form>';
	};

	echo '<div class="wrap"><h1>BrokerMojo</h1>';
	if ( $done && isset( $labels[ $done ] ) ) {
		echo '<div class="notice notice-success is-dismissible"><p>' . esc_html( $labels[ $done ] ) . '</p></div>';
	}

	echo '<div class="card" style="max-width:720px"><h2>Edit the home page</h2>';
	if ( ! bm_acf_ready() ) {
		echo '<p>Install and activate <strong>ACF PRO</strong>, <strong>Secure Custom Fields</strong> (free) or <strong>Advanced Custom Fields</strong> (free). The site shows its original content until then.</p>';
	} elseif ( ! $ok ) {
		echo '<p>No static front page is set.</p>';
		$form( 'front', 'Create the Home page and set it as the front page', 'button button-primary' );
	} else {
		echo '<p>All content — every heading, paragraph, image, button and link — is edited on the Home page’s edit screen, one tab per section.</p>';
		echo '<p><a class="button button-primary" href="' . esc_url( get_edit_post_link( $pid ) ) . '">Edit Home page content</a> <a class="button" href="' . esc_url( home_url( '/' ) ) . '" target="_blank">View site</a></p>';
		echo '<p style="color:#646970">Field plugin: ' . ( 'repeater' === bm_list_mode() ? 'repeater lists available (add / remove / reorder).' : 'free ACF — lists use fixed slots with a “Show” switch.' ) . '</p>';
	}
	echo '</div>';

	if ( bm_acf_ready() && $ok ) {
		echo '<div class="card" style="max-width:720px"><h2>Tools</h2>';
		if ( $stored && bm_list_mode() !== $stored ) {
			echo '<p>Lists on the Home page were saved with a different custom fields plugin.</p>';
			$form( 'convert', 'Convert lists to the active plugin', 'button button-primary' );
		}
		echo '<p>Put the original content back into every field (images are re-used from the Media Library). <strong>This overwrites your edits.</strong></p>';
		$form( 'reset', 'Restore original content', 'button', 'Overwrite all home page fields with the original content?' );
		echo '</div>';
	}
	echo '</div>';
}
