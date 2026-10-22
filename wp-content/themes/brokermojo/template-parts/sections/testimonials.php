<?php
/**
 * S10 · Testimonials (video + quote cards, arrow carousel)
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

$s    = bm_section( 'testimonials' );
$play = '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M7 4.5v15l13-7.5-13-7.5Z"/></svg>';
?>
<section class="panel panel--dark on-dark" id="testimonials">
  <div class="wrap">
    <div class="center stack" style="gap:26px; align-items:center; max-width:52rem">
      <h2 class="d2 rv"><?php bm_heading( $s['title'], $s['accent'] ); ?></h2>
    </div>

        <div class="tnav">
      <button type="button" class="tnav__b" id="tPrev" aria-label="Previous testimonials" aria-controls="tb-a">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 5l-7 7 7 7"/></svg>
      </button>
      <button type="button" class="tnav__b" id="tNext" aria-label="Next testimonials" aria-controls="tb-a">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 5l7 7-7 7"/></svg>
      </button>
    </div>

<div class="tg" id="tb-a" tabindex="0" role="group" aria-label="Testimonials">
<?php
foreach ( $s['items'] as $i => $t ) :
	if ( 'quote' === $t['type'] ) :
		?>
      <article class="qt tilt" data-tilt style="--i:<?php echo (int) $i; ?>">
        <span class="qt__bg" aria-hidden="true"><?php bm_img( $t['bg_image'], ' loading="lazy"', '' ); ?></span>
        <span class="qt__m" aria-hidden="true">&ldquo;</span>
        <p><?php bm_t( $t['quote'] ); ?></p>
        <div class="qt__w"><span class="qt__a" aria-hidden="true">&mdash;</span><span><span class="qt__n"><?php bm_t( $t['name'] ); ?></span><br><span class="qt__r"><?php bm_t( $t['role'] ); ?></span></span></div>
      </article>
		<?php
	else :
		$video = '' !== $t['video_file'] ? $t['video_file'] : trim( $t['video_url'] );
		?>
      <button class="vc tilt" data-tilt style="--i:<?php echo (int) $i; ?>" data-video="<?php echo esc_url( $video ); ?>" data-poster="" data-name="<?php bm_a( $t['name'] ); ?>" data-role="<?php bm_a( $t['role'] ); ?>">
        <span class="vc__p<?php echo $t['cutout'] ? ' vc__p--cut' : ''; ?>"><?php bm_img( $t['photo'], ' loading="lazy"' ); ?></span>
        <span class="vc__ring" aria-hidden="true"></span>
        <span class="vc__play" aria-hidden="true"><?php echo $play; // phpcs:ignore ?></span>
        <span class="vc__f"><span class="vc__tag"><?php bm_t( $t['tag'] ); ?></span><span class="vc__n"><?php bm_t( $t['name'] ); ?></span><span class="vc__r"><?php bm_t( $t['role'] ); ?></span></span>
      </button>
		<?php
	endif;
endforeach;
?>
    </div>

    <div class="tcta__w">
      <button type="button" class="btn btn--brand tcta rv" data-mag data-appm><span><?php bm_t( $s['button_text'] ); ?></span></button>
    </div>
  </div>
</section>
