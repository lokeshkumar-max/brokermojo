<?php
/**
 * Header: <head>, progress bar, fixed header and the mobile menu.
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

$bm_header = bm_section( 'header' );
$bm_home   = is_front_page() ? '#top' : home_url( '/' );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div class="prog" id="prog"></div>

<header class="hdr inv" id="hdr">
  <div class="hdr__in">
    <a class="brand" href="<?php echo is_front_page() ? '#top' : esc_url( $bm_home ); ?>" aria-label="<?php bm_a( bm_opt( 'brand_name' ) . ' home' ); ?>">
      <?php bm_brand_mark(); ?>
      <b><?php bm_t( bm_opt( 'brand_name' ) ); ?></b>
    </a>
    <nav class="nav" id="nav" aria-label="Primary">
<?php foreach ( $bm_header['nav'] as $bm_link ) : ?>
      <a href="<?php echo bm_url( $bm_link['url'] ); ?>"><?php bm_t( $bm_link['label'] ); ?></a>
<?php endforeach; ?>
    </nav>
    <button type="button" class="btn btn--sm" data-mag data-appm><span><?php bm_t( $bm_header['cta_text'] ); ?></span></button>
    <button class="burger" id="burger" aria-label="Open menu" aria-expanded="false" aria-controls="mnav"><i></i></button>
  </div>
</header>

<div class="mnav" id="mnav">
<?php foreach ( $bm_header['nav'] as $bm_i => $bm_link ) : ?>
  <a href="<?php echo bm_url( $bm_link['url'] ); ?>" style="--i:<?php echo (int) $bm_i; ?>"><?php bm_t( $bm_link['label'] ); ?></a>
<?php endforeach; ?>
  <div class="stores">
<?php bm_store_buttons( '    ' ); ?>
  </div>
</div>

<div class="frame" id="top">
<main>
