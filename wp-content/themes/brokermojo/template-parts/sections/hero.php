<?php
/**
 * S1 · Hero
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

$s     = bm_section( 'hero' );
$check = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.4" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12.5 4.5 4.5L19 7"/></svg>';
$star  = '<path d="m12 2 3 6.6 7 .8-5.2 4.8 1.4 7L12 17.8 5.8 21.2l1.4-7L2 9.4l7-.8L12 2Z"/>';
?>
<section class="hero on-brand" id="hero">
  <canvas class="mesh" id="mesh" aria-hidden="true"></canvas>

  <div class="hero__in">
    <div class="hero__copy">
      <span class="tagline rv" style="--d:60ms"><i></i><?php bm_t( $s['tagline'] ); ?></span>

      <h1 class="d1">
<?php foreach ( $s['title_lines'] as $i => $line ) : ?>
        <span class="mask"><span style="--d:<?php echo (int) ( 220 + 110 * $i ); ?>ms"><?php bm_t( $line ); ?></span></span>
<?php endforeach; ?>
      </h1>

      <p class="hero__sub rv" style="--d:560ms"><?php bm_t( $s['subtitle'] ); ?></p>

      <ul class="bullets">
<?php foreach ( $s['bullets'] as $i => $bullet ) : ?>
        <li style="--i:<?php echo (int) $i; ?>"><i class="bx"><?php echo $check; // phpcs:ignore ?></i><span><?php bm_t( $bullet ); ?></span></li>
<?php endforeach; ?>
      </ul>

      <div class="stores rv" style="--d:960ms">
<?php bm_store_buttons( '        ' ); ?>
      </div>

      <p class="hero__tag rv" style="--d:1040ms"><?php bm_t( $s['bottom_tag'] ); ?></p>

      <a class="scrollcue rv" style="--d:1160ms" href="#network">
        <?php bm_t( $s['scroll_text'] ); ?>

        <i><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M6 13l6 6 6-6"/></svg></i>
      </a>
    </div>

    <div class="phones" id="phones">
      <span class="hhalo" aria-hidden="true"></span>
      <div class="ph ph--banner"><?php bm_img( $s['banner_image'] ); ?></div>

<?php foreach ( $s['chips'] as $i => $chip ) : ?>
      <span class="chip chip--<?php echo (int) ( $i + 1 ); ?>" aria-hidden="true">
        <i><?php bm_svg( $chip['icon'] ); ?></i>
        <?php bm_t( $chip['label'] ); ?>

      </span>
<?php endforeach; ?>
    </div>
  </div>

  <div class="trust">
    <div class="trust__in">
      <div class="trust__i">
        <span class="stars" id="stars" aria-hidden="true">
<?php for ( $i = 0; $i < 5; $i++ ) : ?>
          <svg viewBox="0 0 24 24" fill="currentColor" style="--i:<?php echo (int) $i; ?>"><?php echo $star; // phpcs:ignore ?></svg>
<?php endfor; ?>
        </span>
        <span class="trust__l"><?php bm_t( $s['rating_label'] ); ?></span>
      </div>
<?php foreach ( $s['stats'] as $stat ) : ?>
      <div class="trust__i"><span class="trust__n" data-count="<?php echo (int) $stat['number']; ?>" data-suffix="<?php bm_a( $stat['suffix'] ); ?>">0</span><span class="trust__l"><?php bm_t( $stat['label'] ); ?></span></div>
<?php endforeach; ?>
    </div>
  </div>
</section>
