<?php
/**
 * Footer, sticky mobile bar and back-to-top button.
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

$bm_f   = bm_section( 'footer' );
$bm_mb  = bm_section( 'mobile_bar' );

// On the home page the two dialogs sit between Pricing and FAQ (as in the
// original build). Every other page still needs them for the header button.
if ( ! is_front_page() ) {
	get_template_part( 'template-parts/parts/video-lightbox' );
	get_template_part( 'template-parts/parts/app-popup' );
}
?>
</main>

<footer class="ftr">
  <div class="wrap">
    <div class="ftr__t">
      <div class="ftr__b1">
        <span class="brand"><?php bm_brand_mark(); ?><b><?php bm_t( bm_opt( 'brand_name' ) ); ?></b></span>
        <p><?php bm_t( bm_opt( 'tagline' ) ); ?></p>
        <span class="ftr__legal"><?php bm_t( $bm_f['legal_name'] ); ?></span>
        <div class="ftr__ct">
          <span><?php echo bm_contact_svg( 'pin', '1.8' ); // phpcs:ignore ?><?php bm_br( bm_opt( 'address' ) ); ?></span>
          <a href="mailto:<?php echo esc_attr( bm_opt( 'email' ) ); ?>"><?php echo bm_contact_svg( 'mail', '1.8' ); // phpcs:ignore ?><?php bm_t( bm_opt( 'email' ) ); ?></a>
          <a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', bm_opt( 'phone_link' ) ) ); ?>"><?php echo bm_contact_svg( 'phone', '1.8' ); // phpcs:ignore ?><?php bm_t( bm_opt( 'phone_display' ) ); ?></a>
        </div>
      </div>

      <div>
        <h4><?php bm_t( $bm_f['col1_heading'] ); ?></h4>
        <nav class="ftr__ln">
<?php foreach ( $bm_f['col1_links'] as $bm_link ) : ?>
          <a href="<?php echo bm_url( $bm_link['url'] ); ?>"><?php bm_t( $bm_link['label'] ); ?></a>
<?php endforeach; ?>
        </nav>
      </div>

      <div>
        <h4><?php bm_t( $bm_f['col2_heading'] ); ?></h4>
        <nav class="ftr__ln">
<?php foreach ( $bm_f['col2_links'] as $bm_link ) : ?>
          <a href="<?php echo bm_url( $bm_link['url'] ); ?>"><?php bm_t( $bm_link['label'] ); ?></a>
<?php endforeach; ?>
        </nav>
      </div>

      <div>
        <h4><?php bm_t( $bm_f['col3_heading'] ); ?></h4>
        <div class="stores" style="flex-direction:column">
<?php bm_store_buttons( '          ', 'small' ); ?>
        </div>
        <div class="ftr__so">
<?php foreach ( $bm_f['socials'] as $bm_so ) : ?>
<?php
	$bm_names = array(
		'instagram' => 'Instagram',
		'facebook'  => 'Facebook',
		'linkedin'  => 'LinkedIn',
		'youtube'   => 'YouTube',
		'x'         => 'X',
		'whatsapp'  => 'WhatsApp',
	);
	$bm_net   = isset( $bm_names[ $bm_so['network'] ] ) ? $bm_so['network'] : 'instagram';
?>
          <a href="<?php echo esc_url( $bm_so['url'] ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( $bm_names[ $bm_net ] ); ?>"><?php echo bm_social_svg( $bm_net ); // phpcs:ignore ?></a>
<?php endforeach; ?>
        </div>
      </div>
    </div>

    <div class="ftr__bt">
      <span><?php bm_t( $bm_f['copyright_before'] ); ?> <span id="yr"><?php echo esc_html( gmdate( 'Y' ) ); ?></span> <?php bm_t( $bm_f['copyright_after'] ); ?></span>
      <span class="ftr__city"><i></i> <?php bm_t( bm_opt( 'launch_note' ) ); ?></span>
    </div>
  </div>
</footer>
</div>

<div class="mcta" id="mcta">
  <span class="mcta__t"><strong><?php bm_t( bm_opt( 'brand_name' ) ); ?></strong><span><?php bm_t( bm_opt( 'tagline' ) ); ?></span></span>
  <button type="button" class="btn btn--brand btn--sm" data-appm><span><?php bm_t( $bm_mb['button_text'] ); ?></span></button>
</div>

<button class="totop" id="totop" aria-label="Back to top">
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 19V6M5.5 12.5 12 6l6.5 6.5"/></svg>
</button>

<?php wp_footer(); ?>
</body>
</html>
