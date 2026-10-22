<?php
/**
 * The home page — every section, in the original order.
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<?php
get_template_part( 'template-parts/sections/hero' );
get_template_part( 'template-parts/sections/network' );
get_template_part( 'template-parts/sections/connect' );
get_template_part( 'template-parts/sections/inventory' );
get_template_part( 'template-parts/sections/how' );
get_template_part( 'template-parts/sections/features' );
get_template_part( 'template-parts/sections/more' );
get_template_part( 'template-parts/sections/why' );
?>
<svg style="display:none" aria-hidden="true"><symbol id="ck" viewBox="0 0 24 24"><path d="m5 12.5 4.5 4.5L19 7" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></symbol></svg>
<?php
get_template_part( 'template-parts/sections/testimonials' );
get_template_part( 'template-parts/sections/pricing' );
get_template_part( 'template-parts/parts/video-lightbox' );
get_template_part( 'template-parts/parts/app-popup' );
get_template_part( 'template-parts/sections/faq' );
?>

<?php
get_footer();
