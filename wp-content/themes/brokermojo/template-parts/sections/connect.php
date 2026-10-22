<?php
/**
 * S3 · Connect (photo background + animated network diagram)
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

$s = bm_section( 'connect' );

// The diagram's geometry is fixed artwork: six links into the hub.
$paths = array(
	'M150 104 C 276 104 314 160 392 222',
	'M150 310 L 356 310',
	'M150 516 C 276 516 314 460 392 398',
	'M810 104 C 684 104 646 160 568 222',
	'M810 310 L 604 310',
	'M810 516 C 684 516 646 460 568 398',
);
$spots = array(
	array( 'l', 'left:0; top:16.77%' ),
	array( 'l', 'left:0; top:50.00%' ),
	array( 'l', 'left:0; top:83.23%' ),
	array( 'r', 'right:0; top:16.77%' ),
	array( 'r', 'right:0; top:50.00%' ),
	array( 'r', 'right:0; top:83.23%' ),
);
?>
<section class="panel connect3" id="connect">
  <div class="connect3__bg" aria-hidden="true"><?php bm_img( $s['bg_image'], ' id="c3img"', '' ); ?></div>
  <span class="connect3__wash" aria-hidden="true"></span>
  <div class="wrap" style="position:relative; z-index:3">
    <div class="c3">
      <div class="c3__head">
        <h2 class="d2"><?php bm_heading( $s['title'], $s['accent'] ); ?></h2>
      </div>

      <div class="c3__copy">
<?php foreach ( $s['paragraphs'] as $p ) : ?>
        <p class="body-lg"><span class="words" data-words><?php bm_t( $p ); ?></span></p>
<?php endforeach; ?>
        <div class="c3__cta">
          <p class="h-sm"><?php bm_t( $s['cta_heading'] ); ?></p>
          <button type="button" class="btn btn--brand btn--dl" data-mag data-appm>
            <span><?php bm_t( $s['button_text'] ); ?></span>
            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 4v13M6 11.5l6 6 6-6"/><path d="M5 20h14"/></svg>
          </button>
        </div>
      </div>

    <div class="nw rv-s" style="--d:100ms" id="nw" role="img"
         aria-label="<?php bm_a( $s['diagram_label'] ); ?>">
      <svg viewBox="0 0 960 620" aria-hidden="true">
        <defs>
          <marker id="nwHead" viewBox="0 0 10 10" refX="7" refY="5" markerWidth="6.5" markerHeight="6.5" orient="auto-start-reverse">
            <path d="M0 1.6 L8 5 L0 8.4 z" fill="currentColor"/>
          </marker>
        </defs>
<?php foreach ( $paths as $d ) : ?>
        <path class="nw__base" d="<?php echo esc_attr( $d ); ?>"/>
<?php endforeach; ?>
<?php foreach ( $paths as $i => $d ) : ?>
        <path class="nw__flow" id="fl<?php echo (int) $i; ?>" d="<?php echo esc_attr( $d ); ?>" marker-end="url(#nwHead)"/>
<?php endforeach; ?>
<?php foreach ( $paths as $i => $d ) : ?>
        <circle class="nw__dot" id="dot<?php echo (int) $i; ?>" r="5" style="offset-path:path('<?php echo esc_attr( $d ); ?>')"/>
<?php endforeach; ?>
      </svg>

      <span class="nw__hub" id="nwHub">
        <span class="nw__halo" aria-hidden="true"></span>
        <span class="nw__halo b" aria-hidden="true"></span>
        <?php echo bm_logo_svg( 'lg lg--glyph' ); // phpcs:ignore ?>

      </span>

<?php foreach ( $s['nodes'] as $i => $node ) : ?>
      <button type="button" class="nw__n nw__n--<?php echo esc_attr( $spots[ $i ][0] ); ?>" data-n="<?php echo (int) $i; ?>" style="<?php echo esc_attr( $spots[ $i ][1] ); ?>">
        <span class="nw__ic"><?php bm_svg( $node['icon'] ); ?></span>
        <b><?php bm_t( $node['label'] ); ?></b>
      </button>
<?php endforeach; ?>
    </div>
    </div>
  </div>
</section>
