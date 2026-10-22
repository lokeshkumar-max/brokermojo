<?php
/**
 * S8 · Why BrokerMojo
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

$s = bm_section( 'why' );
?>
<section class="panel why8 on-dark" id="why">
  <div class="why8__bg" aria-hidden="true">
    <?php bm_img( $s['bg_image'], ' id="why8img"', '' ); ?>

  </div>
  <span class="why8__veil" aria-hidden="true"></span>

  <div class="wrap" style="position:relative; z-index:3">
    <div class="center stack" style="gap:24px; max-width:50rem">
      <h2 class="d2 sp"><?php bm_heading( $s['title'], $s['accent'] ); ?></h2>
      <p class="body-lg rv" style="--d:110ms; color:rgba(255,255,255,.82)"><?php bm_t( $s['text'] ); ?></p>
    </div>

    <div class="why8__grid">
<?php foreach ( $s['cards'] as $c ) : ?>
      <article class="gcard tilt" data-tilt>
        <span class="gcard__ic" aria-hidden="true"><?php bm_svg( $c['icon'] ); ?></span>
        <h3><?php bm_t( $c['title'] ); ?></h3>
        <p class="gcard__k"><?php bm_t( $c['kicker'] ); ?></p>
        <p><?php bm_t( $c['text'] ); ?></p>
      </article>
<?php endforeach; ?>
    </div>
  </div>
</section>
