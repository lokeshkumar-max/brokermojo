<?php
/**
 * S7 · Statement
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

$s = bm_section( 'more' );
?>
<section class="panel panel--brand on-brand" id="more" data-par=".06">
  <canvas class="mesh" id="mesh3" aria-hidden="true"></canvas>
  <div class="wrap">
    <h2 class="mega"><span class="words" data-words><?php bm_t( $s['title'] ); ?></span></h2>
    <div class="center stack rv" style="--d:120ms; gap:26px; align-items:center; margin-top:clamp(36px,4.4vw,58px)">
      <p class="body-lg" style="max-width:44rem; color:var(--on-brand-soft)"><?php bm_t( $s['text'] ); ?></p>
      <a class="btn btn--onBrand" data-mag data-mag href="<?php echo bm_url( $s['button_url'] ); ?>"<?php bm_ext( $s['button_url'] ); ?>>
        <span><?php bm_t( $s['button_text'] ); ?></span>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h13M12.5 5.5 19 12l-6.5 6.5"/></svg>
      </a>
    </div>
  </div>
</section>
