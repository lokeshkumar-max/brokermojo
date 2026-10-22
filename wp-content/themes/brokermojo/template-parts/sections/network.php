<?php
/**
 * S2 · The network gap (pinned card deck + without / with comparison)
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

$s     = bm_section( 'network' );
$cards = $s['cards'];
$n     = max( 1, count( $cards ) );
$ring  = '<svg class="vs3__ring" viewBox="0 0 180 62" preserveAspectRatio="none" aria-hidden="true"><path pathLength="1" d="M138 13c-26-9-74-9-105 1-22 7-27 23-6 31 25 9 82 10 112 0 21-7 24-22 4-30-13-5-36-8-57-8" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>';
?>
<section class="panel--dark on-dark" id="network">

  <div class="pin" id="pin2" style="height:calc(<?php echo (int) $n; ?> * 72vh + 100svh)">
    <div class="pin__stage">
      <div class="g2">
        <div class="g2__lead">
          <span class="kicker"><?php bm_t( $s['kicker'] ); ?></span>
          <h2 class="d2 sp" style="margin-top:20px"><?php bm_heading( $s['title'], $s['accent'] ); ?></h2>
          <p class="body-lg" style="margin-top:22px"><?php bm_t( $s['text'] ); ?></p>
          <div class="g2__dots" id="g2dots" aria-hidden="true"><?php foreach ( $cards as $i => $c ) { echo 0 === $i ? '<b class="on"></b>' : '<b></b>'; } ?></div>
        </div>

        <div class="g2__deck">
<?php foreach ( $cards as $i => $c ) : ?>
          <article class="g2c<?php echo 0 === $i ? ' on' : ''; ?>">
            <span class="g2c__n"><?php echo esc_html( bm_n( $i + 1 ) ); ?></span>
            <span class="g2c__ic" aria-hidden="true"><?php bm_svg( $c['icon'] ); ?></span>
            <h3><?php bm_t( $c['title'] ); ?></h3>
            <p><?php bm_t( $c['text'] ); ?></p>
          </article>
<?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>

  <div class="panel panel--dark on-dark" style="padding-top:0">
    <div class="wrap">
      <div class="vsxcard">
        <div class="vs3" id="vsx">

          <div class="vs3__col vs3__col--a">
            <p class="vs3__head">
              <span class="vs3__kicker"><?php bm_t( $s['without_kicker'] ); ?></span>
              <span class="vs3__big"><?php bm_t( $s['without_title'] ); ?></span>
            </p>
            <div class="vs3__thread">
<?php foreach ( $s['messages'] as $i => $msg ) : ?>
            <p class="vs3__msg vs3__msg--<?php echo 0 === $i % 2 ? 'in' : 'out'; ?>" style="--i:<?php echo (int) $i; ?>"><?php bm_t( $msg ); ?></p>
<?php endforeach; ?>
              <span class="vs3__typing" aria-hidden="true"><i></i><i></i><i></i></span>
            </div>
          </div>

          <span class="vs3__rule" aria-hidden="true"></span>

          <div class="vs3__col vs3__col--b">
            <p class="vs3__head vs3__head--b">
              <span class="vs3__kicker"><?php bm_t( $s['with_kicker'] ); ?><?php echo $ring; // phpcs:ignore ?></span>
              <span class="vs3__big"><?php bm_t( $s['with_title'] ); ?></span>
            </p>
            <ul class="vs3__cards">
<?php foreach ( $s['vs_cards'] as $i => $c ) : ?>
            <li class="vs3__card<?php echo $c['highlight'] ? ' vs3__card--hero' : ''; ?>" style="--i:<?php echo (int) $i; ?>">
              <span class="vs3__ic" aria-hidden="true"><?php bm_svg( $c['icon'] ); ?></span>
              <span class="vs3__t"><?php bm_t( $c['title'] ); ?></span>
            </li>
<?php endforeach; ?>
          </ul>
          </div>

        </div>
      </div>
    </div>
  </div>

</section>
