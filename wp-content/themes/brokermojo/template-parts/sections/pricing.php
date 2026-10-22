<?php
/**
 * S9 · Pricing + closing download band
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

$s = bm_section( 'pricing' );
?>
<section class="panel price9 on-dark" id="pricing">
  <div class="wrap">
    <div class="center stack" style="gap:30px; align-items:center; max-width:54rem">
      <h2 class="d2 rv" style="--d:70ms"><?php bm_heading( $s['title'], $s['accent'] ); ?></h2>
    </div>

    <div class="plans9" id="plans9">
<?php foreach ( $s['plans'] as $p ) : ?>
      <article class="pl<?php echo $p['popular'] ? ' pl--pop' : ''; ?>" data-tilt2>
<?php if ( '' !== trim( $p['tag_text'] ) ) : ?>
        <span class="pl__tag pl__tag--<?php echo 'best' === $p['tag_style'] ? 'best' : 'pop'; ?>"><?php bm_t( $p['tag_text'] ); ?></span>
<?php endif; ?>
        <span class="pl__t"><?php bm_t( $p['name'] ); ?></span>
        <div class="pl__price"><span><?php bm_t( $p['price'] ); ?></span><i aria-hidden="true"></i></div>
        <div class="pl__free"><?php bm_t( $p['free_title'] ); ?><em><?php bm_t( $p['free_note'] ); ?></em></div>
        <div class="pl__r"></div>
        <ul class="pl__l">
<?php foreach ( $p['features'] as $i => $feat ) : ?>
          <li style="--i:<?php echo (int) $i; ?>"><svg><use href="#ck"/></svg><?php bm_t( $feat ); ?></li>
<?php endforeach; ?>
        </ul>
        <button type="button" class="btn <?php echo $p['popular'] ? 'btn--brand' : 'btn--onDark'; ?> btn--wide" data-mag data-appm><span><?php bm_t( $p['button_text'] ); ?></span></button>
      </article>

<?php endforeach; ?>
    </div>

    <div class="ctaband rv on-brand" id="ctaband">
      <h2 class="d3" style="max-width:24ch; margin-inline:auto"><?php bm_t( $s['cta_title'] ); ?></h2>
      <p class="body-lg" style="margin-top:18px; max-width:40rem; margin-inline:auto"><?php bm_t( $s['cta_text'] ); ?></p>
      <div class="stores">
<?php bm_store_buttons( '        ' ); ?>
      </div>
    </div>
  </div>
</section>
