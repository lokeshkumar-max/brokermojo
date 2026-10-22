<?php
/**
 * S5 · How it works (pinned, one step + screen per scroll step)
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

$s     = bm_section( 'how' );
$steps = $s['steps'];
$n     = max( 1, count( $steps ) );
?>
<section class="panel--paper2" id="how">
  <div class="panel panel--paper2" style="padding-bottom:0">
    <div class="wrap">
      <div class="center stack" style="gap:24px; max-width:48rem">
        <h2 class="d2 sp"><?php bm_heading( $s['title'], $s['accent'] ); ?></h2>
        <p class="body-lg rv" style="--d:110ms"><?php bm_t( $s['text'] ); ?></p>
      </div>
    </div>
  </div>

  <div class="pin" id="pin5" style="height:calc(<?php echo (int) $n; ?> * 80vh + 100svh)">
    <div class="pin__stage">
      <div class="p5__in">

        <div class="p5__left">
          <div class="thr" id="p5thr" role="tablist" aria-label="Workflow steps">
            <span class="thr__rail" aria-hidden="true"><i id="p5line"></i></span>
<?php foreach ( $steps as $i => $st ) : ?>
            <button type="button" class="thr__n<?php echo 0 === $i ? ' on' : ''; ?>" role="tab" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" data-s="<?php echo (int) $i; ?>"><b><?php echo esc_html( bm_n( $i + 1 ) ); ?></b></button>
<?php endforeach; ?>
            <span class="thr__of" aria-hidden="true"><i id="p5cur">01</i> / <?php echo esc_html( bm_n( $n ) ); ?></span>
          </div>

          <div class="p5__txt">
<?php foreach ( $steps as $i => $st ) : ?>
            <div class="p5__s<?php echo 0 === $i ? ' on' : ''; ?>">
              <h3><?php bm_t( $st['title'] ); ?></h3>
              <p><?php bm_t( $st['text'] ); ?></p>
            </div>
<?php endforeach; ?>
          </div>

        </div>

        <div class="p5__shot" id="p5shot">
          <span class="p5__ghost" aria-hidden="true">01</span>
          <div class="p5__frame">
            <div class="p5__imgs" id="p5imgs">
<?php foreach ( $steps as $i => $st ) : ?>
              <?php bm_img( $st['image'], 0 === $i ? ' class="live"' : '' ); ?>

<?php endforeach; ?>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
