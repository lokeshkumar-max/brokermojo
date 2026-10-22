<?php
/**
 * S4 · Property + requirements
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

$s = bm_section( 'inventory' );
?>
<section class="panel panel--brand on-brand" id="inventory">
  <canvas class="mesh" id="mesh2" aria-hidden="true"></canvas>
  <div class="wrap">
    <div class="center stack" style="gap:26px; max-width:54rem">
      <span class="kicker rv" style="align-self:center"><?php bm_t( $s['kicker'] ); ?></span>
      <h2 class="d2 rv" style="--d:70ms"><?php bm_t( $s['title'] ); ?></h2>
      <p class="body-lg rv" style="--d:130ms; max-width:44rem; margin-inline:auto"><?php bm_t( $s['text'] ); ?></p>
    </div>

    <div class="scatter">
<?php foreach ( $s['cards'] as $i => $c ) : ?>
      <article class="scard<?php echo $c['dark'] ? ' scard--dark' : ''; ?> rv tilt" data-tilt style="--d:<?php echo (int) ( 60 + 80 * $i ); ?>ms">
        <span class="scard__ic" aria-hidden="true"><?php bm_svg( $c['icon'] ); ?></span>
        <h3><?php bm_t( $c['title'] ); ?></h3>
        <p><?php bm_t( $c['text'] ); ?></p>
      </article>
<?php endforeach; ?>
    </div>

    <div class="center stack rv" style="--d:140ms; gap:22px; align-items:center; margin-top:clamp(48px,6vw,78px)">
      <p class="h-sm"><?php bm_t( $s['cta_heading'] ); ?></p>
      <a class="btn btn--onBrand" data-mag data-mag href="<?php echo bm_url( $s['button_url'] ); ?>"<?php bm_ext( $s['button_url'] ); ?>>
        <span><?php bm_t( $s['button_text'] ); ?></span>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h13M12.5 5.5 19 12l-6.5 6.5"/></svg>
      </a>
    </div>
  </div>
</section>
