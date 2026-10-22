<?php
/**
 * Video testimonial lightbox (filled by the script when a card is clicked).
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="lb" id="lb" hidden role="dialog" aria-modal="true" aria-label="Video testimonial">
  <div class="lb__p">
    <button class="lb__c" id="lbC" aria-label="Close video"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M6 6l12 12M18 6 6 18"/></svg></button>
    <div class="lb__m" id="lbM"></div>
    <div class="lb__bar"><div><h3 id="lbN">&nbsp;</h3><p id="lbR">&nbsp;</p></div></div>
  </div>
</div>
