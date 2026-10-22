<?php
/**
 * Fixed brand artwork, copied byte-for-byte from the original build.
 * These are design assets (not content), so they live in code.
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

/** The BrokerMojo mark. $class = "lg" (header / footer) or "lg lg--glyph" (hub / popup). */
function bm_logo_svg( $class = 'lg' ) {
	return '<svg class="' . esc_attr( $class ) . '" viewBox="0 0 123 123" role="img" aria-label="' . esc_attr( bm_opt( 'brand_name' ) ) . '" xmlns="http://www.w3.org/2000/svg">' . '<path class="lg__tile" fill-rule="evenodd" clip-rule="evenodd" d="M17.9992 0H105.001C114.903 0 123 8.09702 123 17.9992V105.001C123 114.903 114.903 123 105.001 123H17.9992C8.09702 123 0 114.903 0 105.001V17.9992C0 8.09702 8.09702 0 17.9992 0Z"/><g class="lg__glyph" transform="translate(13.45 13.09)"><path class="lg__ink" fill-rule="evenodd" clip-rule="evenodd" d="M47.0321 32.0295C41.9362 26.9403 46.9152 31.9128 41.8193 26.8235L65.1717 22.8549L61.1511 46.1533C55.9149 40.9707 61.1511 46.1533 55.9383 40.9473C1.56619 95.2714 56.3824 40.854 0 96.8122H10.4256C52.2449 55.0478 10.4256 96.8122 52.2449 55.0478C87.1216 89.8787 52.1981 55.0011 87.1216 89.8787C90.7214 87.264 93.9005 82.7351 95.1161 77.3891C96.7991 69.942 96.168 64.9928 94.2979 59.2499C92.2409 52.9234 86.7943 47.6474 79.0803 45.7097C86.2567 42.208 90.8617 36.3717 92.4045 29.8351C93.994 22.9949 92.7318 15.5945 89.0384 9.85164C85.8125 4.83244 80.74 1.00384 74.0779 0C25.877 0 74.0779 0 25.877 0C22.2304 0.116726 19.5655 1.58747 18.1396 3.40839C15.802 6.39656 15.8254 6.55998 15.8254 13.3067C15.8254 63.2419 15.8254 13.3067 15.8254 63.2419L47.0321 32.0762V32.0295Z"/><path class="lg__ink" fill-rule="evenodd" clip-rule="evenodd" d="M20.851 96.8123H66.9714C66.9714 96.8123 76.0412 96.9757 81.3241 94.4778C52.268 65.4598 81.3241 94.4778 52.268 65.4598L20.8743 96.8123H20.851Z"/><path class="lg__cut" fill-rule="evenodd" clip-rule="evenodd" d="M53.016 84.7901H59.2808V91.0466H53.016V84.7901Z"/><path class="lg__cut" fill-rule="evenodd" clip-rule="evenodd" d="M45.2089 84.7901H51.4736V91.0466H45.2089V84.7901Z"/><path class="lg__cut" fill-rule="evenodd" clip-rule="evenodd" d="M51.4736 76.9931V83.2496H45.2089C45.2089 79.8179 48.0374 76.9931 51.4736 76.9931Z"/><path class="lg__cut" fill-rule="evenodd" clip-rule="evenodd" d="M53.016 76.9931C56.4523 76.9931 59.2808 79.8179 59.2808 83.2496H53.016V76.9931Z"/></g>' . '</svg>';
}

/** Google Play / App Store glyphs. $size = "default" (21x23 / 20x23) or "small" (footer: 20x22 / 19x22). */
function bm_store_svg( $store, $size = 'default' ) {
	$dims = array(
		'play'  => 'small' === $size ? array( 20, 22 ) : array( 21, 23 ),
		'apple' => 'small' === $size ? array( 19, 22 ) : array( 20, 23 ),
	);
	$body = 'play' === $store ? '<path d="M2.5.9a1.7 1.7 0 0 0-.6 1.3v21.6c0 .5.2 1 .6 1.3l.1.1L14.7 13v-.3L2.6.8l-.1.1Z" opacity=".75"/><path d="m18.7 17.1-4-4v-.3l4-4 .1.1 4.8 2.7c1.4.8 1.4 2 0 2.8l-4.9 2.7Z"/><path d="m18.8 17-4.1-4.1L2.5 25.1c.5.5 1.2.5 2 .1L18.8 17"/><path d="M18.8 8.8 4.5.7c-.8-.4-1.5-.4-2 .2l12.2 12.1 4.1-4.2Z" opacity=".55"/>' : '<path d="M17.6 13.6c0-2.9 2.4-4.3 2.5-4.4-1.4-2-3.5-2.3-4.2-2.3-1.8-.2-3.5 1-4.4 1-.9 0-2.3-1-3.8-1-2 0-3.8 1.1-4.8 2.9-2 3.5-.5 8.7 1.5 11.6 1 1.4 2.1 3 3.6 2.9 1.5-.1 2-.9 3.8-.9s2.3.9 3.8.9c1.6 0 2.6-1.4 3.5-2.8 1.1-1.6 1.6-3.2 1.6-3.3 0 0-3.1-1.2-3.1-4.6ZM14.7 4.9c.8-1 1.3-2.4 1.2-3.8-1.2 0-2.7.8-3.5 1.8-.8.9-1.4 2.3-1.3 3.7 1.3.1 2.7-.7 3.6-1.7Z"/>';
	return '<svg width="' . $dims[ $store ][0] . '" height="' . $dims[ $store ][1] . '" viewBox="0 0 24 26" fill="currentColor" aria-hidden="true">' . $body . '</svg>';
}

/** Social network icons used in the footer. */
function bm_social_svg( $network ) {
	$icons = array(
		'instagram' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="3.8"/><circle cx="17.4" cy="6.6" r="1.1" fill="currentColor" stroke="none"/></svg>',
		'facebook'  => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M22 12a10 10 0 1 0-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7A10 10 0 0 0 22 12Z"/></svg>',
		'linkedin'  => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M4.98 3.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5ZM3 9.5h4v11H3v-11Zm6.5 0h3.8v1.5h.1a4.2 4.2 0 0 1 3.8-2c4 0 4.8 2.6 4.8 6v5.5h-4V16c0-1.4 0-3.2-2-3.2s-2.3 1.5-2.3 3.1v4.6h-4v-11Z"/></svg>',
		'youtube'   => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M22.5 7.2a2.7 2.7 0 0 0-1.9-1.9C18.9 4.8 12 4.8 12 4.8s-6.9 0-8.6.5A2.7 2.7 0 0 0 1.5 7.2 28 28 0 0 0 1 12a28 28 0 0 0 .5 4.8 2.7 2.7 0 0 0 1.9 1.9c1.7.5 8.6.5 8.6.5s6.9 0 8.6-.5a2.7 2.7 0 0 0 1.9-1.9A28 28 0 0 0 23 12a28 28 0 0 0-.5-4.8ZM9.8 15.3V8.7l5.7 3.3-5.7 3.3Z"/></svg>',
		'x'         => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.8 3h3.1l-6.8 7.8 8 10.2h-6.3l-4.9-6.4L5.3 21H2.2l7.3-8.3L1.8 3h6.4l4.4 5.9L17.8 3Zm-1.1 16.2h1.7L7.4 4.7H5.6l11.1 14.5Z"/></svg>',
		'whatsapp'  => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2a9.9 9.9 0 0 0-8.5 15l-1.4 5 5.2-1.4A10 10 0 1 0 12 2Zm0 18.2a8.2 8.2 0 0 1-4.2-1.1l-.3-.2-3.1.8.8-3-.2-.3A8.2 8.2 0 1 1 12 20.2Zm4.5-6.1c-.2-.1-1.5-.7-1.7-.8-.2-.1-.4-.1-.6.1l-.8 1c-.1.2-.3.2-.5.1a6.7 6.7 0 0 1-3.3-2.9c-.3-.4.3-.4.7-1.4.1-.2 0-.3 0-.4l-.8-1.8c-.2-.5-.4-.4-.6-.4h-.5c-.2 0-.4.1-.7.3-.2.3-.9.9-.9 2.2s.9 2.5 1 2.7c.1.2 1.8 2.8 4.4 3.9 1.6.7 2.3.8 3.1.6.5-.1 1.5-.6 1.7-1.2.2-.6.2-1.1.2-1.2-.1-.1-.3-.2-.6-.3Z"/></svg>',
	);
	return isset( $icons[ $network ] ) ? $icons[ $network ] : '';
}

/** Contact icons. $w = "1.9" (FAQ card / popup) or "1.8" (footer). */
function bm_contact_svg( $kind, $w = '1.9' ) {
	$icons = array(
		'1.9' => array( 'pin' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10.5c0 5.5-8 12-8 12s-8-6.5-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10.2" r="2.8"/></svg>', 'mail' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><rect x="2.5" y="5" width="19" height="14" rx="2"/><path d="m3 6.5 9 6 9-6"/></svg>', 'phone' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16.5v2.8a1.9 1.9 0 0 1-2.1 1.9 18.8 18.8 0 0 1-8.2-2.9 18.5 18.5 0 0 1-5.7-5.7A18.8 18.8 0 0 1 2.1 4.3 1.9 1.9 0 0 1 4 2.2h2.8a1.9 1.9 0 0 1 1.9 1.6c.1 1 .3 1.8.7 2.7a1.9 1.9 0 0 1-.4 2L7.7 9.6a15 15 0 0 0 5.7 5.7l1.1-1.3a1.9 1.9 0 0 1 2-.4c.9.4 1.8.6 2.7.7a1.9 1.9 0 0 1 1.8 2Z"/></svg>' ),
		'1.8' => array( 'pin' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10.5c0 5.5-8 12-8 12s-8-6.5-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10.2" r="2.8"/></svg>', 'mail' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2.5" y="5" width="19" height="14" rx="2"/><path d="m3 6.5 9 6 9-6"/></svg>', 'phone' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16.5v2.8a1.9 1.9 0 0 1-2.1 1.9 18.8 18.8 0 0 1-8.2-2.9 18.5 18.5 0 0 1-5.7-5.7A18.8 18.8 0 0 1 2.1 4.3 1.9 1.9 0 0 1 4 2.2h2.8a1.9 1.9 0 0 1 1.9 1.6c.1 1 .3 1.8.7 2.7a1.9 1.9 0 0 1-.4 2L7.7 9.6a15 15 0 0 0 5.7 5.7l1.1-1.3a1.9 1.9 0 0 1 2-.4c.9.4 1.8.6 2.7.7a1.9 1.9 0 0 1 1.8 2Z"/></svg>' ),
	);
	return $icons[ $w ][ $kind ];
}

/** The built-in QR code shown in the download popup (used when no QR image is uploaded). */
function bm_qr_svg() {
	return '<svg class="qr" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29"><path class="qrline" stroke="currentColor" d="M2 2.5h7m2 0h1m1 0h3m2 0h1m1 0h7m-25 1h1m5 0h1m2 0h1m1 0h5m2 0h1m5 0h1m-25 1h1m1 0h3m1 0h1m1 0h1m5 0h1m3 0h1m1 0h3m1 0h1m-25 1h1m1 0h3m1 0h1m1 0h2m1 0h3m4 0h1m1 0h3m1 0h1m-25 1h1m1 0h3m1 0h1m1 0h1m4 0h1m2 0h1m1 0h1m1 0h3m1 0h1m-25 1h1m5 0h1m1 0h2m2 0h5m1 0h1m5 0h1m-25 1h7m1 0h1m1 0h1m1 0h1m1 0h1m1 0h1m1 0h7m-17 1h1m1 0h2m4 0h1m-17 1h1m1 0h5m3 0h5m3 0h5m-23 1h2m1 0h2m4 0h1m1 0h1m4 0h2m1 0h1m3 0h1m-22 1h1m1 0h1m1 0h2m1 0h3m1 0h1m1 0h2m1 0h1m1 0h2m1 0h2m-24 1h2m1 0h2m1 0h1m1 0h1m2 0h1m1 0h3m7 0h1m-22 1h2m1 0h1m2 0h1m2 0h3m2 0h2m1 0h1m1 0h3m-25 1h2m1 0h2m2 0h1m5 0h1m2 0h1m2 0h1m1 0h1m1 0h1m-24 1h1m2 0h1m2 0h1m1 0h1m1 0h6m1 0h1m1 0h3m1 0h2m-25 1h1m2 0h1m1 0h1m2 0h2m1 0h1m2 0h1m2 0h1m1 0h2m3 0h1m-25 1h1m2 0h1m2 0h4m1 0h1m1 0h8m1 0h1m-15 1h3m1 0h2m2 0h1m3 0h2m-22 1h7m3 0h1m3 0h1m1 0h1m1 0h1m1 0h1m1 0h3m-25 1h1m5 0h1m1 0h2m2 0h1m1 0h1m1 0h1m3 0h2m-22 1h1m1 0h3m1 0h1m1 0h1m1 0h1m1 0h1m2 0h6m1 0h3m-25 1h1m1 0h3m1 0h1m1 0h3m6 0h2m1 0h5m-25 1h1m1 0h3m1 0h1m1 0h1m1 0h3m8 0h2m1 0h1m-25 1h1m5 0h1m2 0h1m1 0h1m3 0h2m2 0h3m2 0h1m-25 1h7m1 0h1m2 0h2m4 0h1m1 0h6"/></svg>';
}
