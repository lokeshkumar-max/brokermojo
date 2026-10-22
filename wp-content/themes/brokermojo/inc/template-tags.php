<?php
/**
 * Output helpers used by the templates.
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

/** Inline tags allowed inside text fields. */
function bm_inline_tags() {
	return array(
		'b'      => array(),
		'strong' => array(),
		'em'     => array(),
		'i'      => array(),
		'u'      => array(),
		'br'     => array(),
		'small'  => array(),
		'span'   => array( 'class' => true ),
	);
}

/** Echo text, allowing simple inline tags. */
function bm_t( $s ) {
	echo wp_kses( (string) $s, bm_inline_tags() );
}

/** Return text, allowing simple inline tags. */
function bm_tr( $s ) {
	return wp_kses( (string) $s, bm_inline_tags() );
}

/** Echo an attribute value. */
function bm_a( $s ) {
	echo esc_attr( wp_strip_all_tags( (string) $s ) );
}

/** Multi-line text with its line breaks kept as <br>. */
function bm_br( $s ) {
	$lines = preg_split( '/\r\n|\r|\n/', trim( (string) $s ) );
	echo implode( '<br>', array_map( 'bm_tr', $lines ) );
}

/** Zero-padded index: 1 → "01". */
function bm_n( $i ) {
	return str_pad( (string) $i, 2, '0', STR_PAD_LEFT );
}

/**
 * Heading text with its optional orange part:
 * "Build Your Broker Network. <span class="accent">Get More Business.</span>"
 */
function bm_heading( $title, $accent ) {
	bm_t( $title );
	if ( '' !== trim( (string) $accent ) ) {
		echo ( '' !== trim( (string) $title ) ? ' ' : '' ) . '<span class="accent">' . bm_tr( $accent ) . '</span>';
	}
}

/**
 * A link URL. On-page anchors (#features) stay anchors on the home page and
 * point back to the home page everywhere else.
 */
function bm_url( $url ) {
	$url = trim( (string) $url );
	if ( '' === $url ) {
		return '#';
	}
	if ( '#' === $url[0] ) {
		if ( is_front_page() ) {
			return esc_attr( $url );
		}
		return esc_url( home_url( '/' ) . $url );
	}
	return esc_url( $url );
}

/** target/rel for button links: new tab unless it is an on-page / relative link. */
function bm_ext( $url ) {
	$url = trim( (string) $url );
	if ( '' === $url || '#' === $url[0] || '/' === $url[0] ) {
		return;
	}
	echo ' target="_blank" rel="noopener"';
}

/** The two store buttons (Google Play + App Store). */
function bm_store_buttons( $indent = '', $size = 'default' ) {
	$items = array(
		array( bm_opt( 'play_url' ), 'play', bm_opt( 'android_label' ) ),
		array( bm_opt( 'ios_url' ), 'apple', bm_opt( 'ios_label' ) ),
	);
	$small = bm_opt( 'store_small' );
	foreach ( $items as $it ) {
		echo $indent . '<a class="store store--light" href="' . esc_url( $it[0] ) . '" target="_blank" rel="noopener">' . "\n";
		echo $indent . '  ' . bm_store_svg( $it[1], $size ) . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput -- fixed artwork.
		echo $indent . '  <span class="store__t"><small>' . bm_tr( $small ) . '</small><span>' . bm_tr( $it[2] ) . '</span></span>' . "\n";
		echo $indent . '</a>' . "\n";
	}
}

/** The brand mark: uploaded logo image, else the built-in SVG. */
function bm_brand_mark() {
	$logo = bm_opt( 'logo_image' );
	if ( $logo && ! empty( $logo['id'] ) ) {
		echo '<img src="' . esc_url( $logo['url'] ) . '" alt="' . esc_attr( $logo['alt'] ? $logo['alt'] : bm_opt( 'brand_name' ) ) . '">';
		return;
	}
	echo bm_logo_svg( 'lg' ); // phpcs:ignore WordPress.Security.EscapeOutput -- fixed artwork.
}

/** <img> for an image value (nothing when empty). */
function bm_img( $img, $attrs = '', $alt = null ) {
	if ( empty( $img['url'] ) ) {
		return;
	}
	$alt = null === $alt ? $img['alt'] : $alt;
	echo '<img src="' . esc_url( $img['url'] ) . '" alt="' . esc_attr( $alt ) . '"' . $attrs . '>';
}

/** Allowed markup for SVG icon fields. */
function bm_svg_tags() {
	$common = array(
		'class'             => true,
		'id'                => true,
		'fill'              => true,
		'fill-rule'         => true,
		'fill-opacity'      => true,
		'clip-rule'         => true,
		'clip-path'         => true,
		'stroke'            => true,
		'stroke-width'      => true,
		'stroke-linecap'    => true,
		'stroke-linejoin'   => true,
		'stroke-miterlimit' => true,
		'stroke-dasharray'  => true,
		'stroke-opacity'    => true,
		'opacity'           => true,
		'transform'         => true,
		'aria-hidden'       => true,
		'role'              => true,
		'focusable'         => true,
	);
	$shape = array_merge(
		$common,
		array(
			'd'      => true,
			'cx'     => true,
			'cy'     => true,
			'r'      => true,
			'rx'     => true,
			'ry'     => true,
			'x'      => true,
			'y'      => true,
			'x1'     => true,
			'x2'     => true,
			'y1'     => true,
			'y2'     => true,
			'width'  => true,
			'height' => true,
			'points' => true,
			'offset' => true,
			'pathlength' => true,
		)
	);
	return array(
		'svg'            => array_merge( $common, array( 'viewbox' => true, 'xmlns' => true, 'width' => true, 'height' => true, 'preserveaspectratio' => true, 'aria-label' => true ) ),
		'g'              => $common,
		'path'           => $shape,
		'circle'         => $shape,
		'ellipse'        => $shape,
		'rect'           => $shape,
		'line'           => $shape,
		'polyline'       => $shape,
		'polygon'        => $shape,
		'defs'           => $common,
		'lineargradient' => array_merge( $common, array( 'x1' => true, 'x2' => true, 'y1' => true, 'y2' => true, 'gradientunits' => true, 'gradienttransform' => true ) ),
		'radialgradient' => array_merge( $common, array( 'cx' => true, 'cy' => true, 'r' => true, 'fx' => true, 'fy' => true, 'gradientunits' => true ) ),
		'stop'           => array_merge( $common, array( 'offset' => true, 'stop-color' => true, 'stop-opacity' => true ) ),
		'clippath'       => $common,
		'title'          => array(),
	);
}

/** Echo a sanitised SVG icon from a field. */
function bm_svg( $code ) {
	echo wp_kses( trim( (string) $code ), bm_svg_tags() );
}
