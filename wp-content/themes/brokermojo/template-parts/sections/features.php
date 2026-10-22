<?php
/**
 * S6 · Features (pinned, one tool + phone screen per scroll step)
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

$s     = bm_section( 'features' );
$items = $s['items'];
$n     = max( 1, count( $items ) );
?>
<section class="panel--dark on-dark" id="features">
  <div class="panel panel--dark on-dark" style="padding-bottom:0">
    <div class="wrap">
      <div class="center stack" style="gap:24px; max-width:50rem">
        <h2 class="d2 rv"><?php bm_heading( $s['title'], $s['accent'] ); ?></h2>
        <p class="body-lg rv" style="--d:110ms"><?php bm_t( $s['text'] ); ?></p>
      </div>
    </div>
  </div>

  <div class="pin" id="pin6" style="height:calc(<?php echo (int) $n; ?> * 82vh + 100svh)">
    <div class="pin__stage">
      <div class="p6__in">
        <div class="p6__txt">
<?php foreach ( $items as $i => $it ) : ?>
          <div class="p6__s<?php echo 0 === $i ? ' on' : ''; ?>">
            <span class="p6__n"><?php echo esc_html( bm_n( $i + 1 ) . ' / ' . bm_n( $n ) ); ?></span>
            <span class="p6__ic" aria-hidden="true"><?php bm_svg( $it['icon'] ); ?></span>
            <h3><?php bm_t( $it['title'] ); ?></h3>
            <p><?php bm_t( $it['text'] ); ?></p>
          </div>
<?php endforeach; ?>
        </div>

        <div class="p6__ph" id="p6ph">
          <span class="p6__glow" aria-hidden="true"></span>
          <div class="p6__d">
            <div class="p6__s2" id="p6screens">
<?php foreach ( $items as $i => $it ) : ?>
              <?php bm_img( $it['image'], 0 === $i ? ' class="live"' : '' ); ?>

<?php endforeach; ?>
            </div>
          </div>
        </div>
      </div>

      <div class="pin__rail" id="p6rail" aria-hidden="true">
        <?php foreach ( $items as $i => $it ) { echo 0 === $i ? '<b class="on"></b>' : '<b></b>'; } ?>

      </div>
    </div>
  </div>
</section>
