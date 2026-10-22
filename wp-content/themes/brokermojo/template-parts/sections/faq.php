<?php
/**
 * S11 · FAQ + contact card
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

$s = bm_section( 'faq' );
?>
<section class="panel panel--paper" id="faq">
  <div class="wrap">
    <div class="faq2">

      <aside class="faq2__side">
        <h2 class="d2 sp"><?php bm_heading( $s['title'], $s['accent'] ); ?></h2>
        <div class="faq2__contact rv" style="--d:140ms">
          <h3><?php bm_t( $s['contact_heading'] ); ?></h3>
          <div class="faq2__links">
            <span>
              <?php echo bm_contact_svg( 'pin', '1.9' ); // phpcs:ignore ?>

              <?php bm_br( bm_opt( 'address' ) ); ?>

            </span>
            <a href="mailto:<?php echo esc_attr( bm_opt( 'email' ) ); ?>">
              <?php echo bm_contact_svg( 'mail', '1.9' ); // phpcs:ignore ?>

              <?php bm_t( bm_opt( 'email' ) ); ?>

            </a>
            <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', bm_opt( 'phone_link' ) ) ); ?>">
              <?php echo bm_contact_svg( 'phone', '1.9' ); // phpcs:ignore ?>

              <?php bm_t( bm_opt( 'phone_display' ) ); ?>

            </a>
          </div>
          <a class="btn btn--brand" data-mag href="<?php echo bm_url( $s['button_url'] ); ?>"<?php bm_ext( $s['button_url'] ); ?>><span><?php bm_t( $s['button_text'] ); ?></span></a>
        </div>
      </aside>

      <div class="faq2__list" id="faqList">
<?php foreach ( $s['items'] as $i => $qa ) : ?>
        <div class="qa rv" style="--d:<?php echo (int) ( 30 * $i ); ?>ms">
          <button class="qa__q" aria-expanded="false">
            <span class="qa__i"><?php echo esc_html( bm_n( $i + 1 ) ); ?></span>
            <span><?php bm_t( $qa['question'] ); ?></span>
            <span class="qa__x" aria-hidden="true"></span>
          </button>
          <div class="qa__a"><div><?php foreach ( $qa['answer'] as $para ) { echo '<p>' . bm_tr( $para ) . '</p>'; } ?></div></div>
        </div>
<?php endforeach; ?>

      </div>

    </div>
  </div>
</section>
