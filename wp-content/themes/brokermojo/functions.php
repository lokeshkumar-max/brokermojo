<?php
/**
 * BrokerMojo theme bootstrap.
 *
 * All home page content is edited on the Home page (the static front page)
 * through ACF fields — see inc/schema.php for the full list.
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

define( 'BM_VER', '1.0.0' );
define( 'BM_DIR', get_template_directory() );
define( 'BM_URI', get_template_directory_uri() );

require BM_DIR . '/inc/schema.php';
require BM_DIR . '/inc/fields.php';
require BM_DIR . '/inc/data.php';
require BM_DIR . '/inc/icons.php';
require BM_DIR . '/inc/template-tags.php';
require BM_DIR . '/inc/seed.php';
require BM_DIR . '/inc/setup.php';
