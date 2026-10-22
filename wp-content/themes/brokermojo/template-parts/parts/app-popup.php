<?php
/**
 * “Get the App” chooser — opened by every button carrying data-appm.
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

$s = bm_section( 'popup' );
?>
<div class="appm" id="appm" hidden role="dialog" aria-modal="true" aria-labelledby="appmT">
  <div class="appm__p">
    <button class="appm__c" id="appmC" aria-label="Close"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M6 6l12 12M18 6 6 18"/></svg></button>
    <span class="appm__ic" aria-hidden="true"><?php echo bm_logo_svg( 'lg lg--glyph' ); // phpcs:ignore ?></span>
    <h3 id="appmT"><?php bm_t( $s['title'] ); ?></h3>
    <p class="appm__sub"><?php bm_t( $s['subtitle'] ); ?></p>
    <div class="appm__get">
      <span class="appm__qr">
<?php if ( ! empty( $s['qr_image']['url'] ) ) : ?>
        <img class="qr" src="<?php echo esc_url( $s['qr_image']['url'] ); ?>" alt="" aria-hidden="true">
<?php else : ?>
        <?php echo bm_qr_svg(); // phpcs:ignore ?>

<?php endif; ?>
        <small><?php bm_t( $s['qr_caption'] ); ?></small>
      </span>
      <div class="stores">
<?php bm_store_buttons( '        ' ); ?>
      </div>
    </div>

    <div class="appm__contact">
      <a href="mailto:<?php echo esc_attr( bm_opt( 'email' ) ); ?>">
        <?php echo bm_contact_svg( 'mail', '1.9' ); // phpcs:ignore ?>

        <?php bm_t( bm_opt( 'email' ) ); ?>

      </a>
      <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', bm_opt( 'phone_link' ) ) ); ?>">
        <?php echo bm_contact_svg( 'phone', '1.9' ); // phpcs:ignore ?>

        <?php bm_t( bm_opt( 'phone_display' ) ); ?>

      </a>
    </div>

    <span class="appm__note"><i></i> <?php bm_t( bm_opt( 'launch_note' ) ); ?></span>
  </div>
</div>
