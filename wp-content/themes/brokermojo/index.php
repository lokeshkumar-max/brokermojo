<?php
/**
 * Fallback template for any page other than the home page
 * (blog posts, plain pages, archives, search, 404).
 *
 * @package BrokerMojo
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="panel panel--paper bm-page">
  <div class="wrap">
<?php if ( have_posts() ) : ?>
<?php if ( ! is_singular() ) : ?>
    <h1 class="d2 bm-page__title"><?php the_archive_title(); ?></h1>
<?php endif; ?>
<?php while ( have_posts() ) : the_post(); ?>
    <article <?php post_class( 'bm-page__item' ); ?>>
<?php if ( is_singular() ) : ?>
      <h1 class="d2 bm-page__title"><?php the_title(); ?></h1>
      <div class="bm-page__content"><?php the_content(); ?></div>
<?php else : ?>
      <h2 class="d3"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
      <div class="bm-page__content"><?php the_excerpt(); ?></div>
<?php endif; ?>
    </article>
<?php endwhile; ?>
    <div class="bm-page__nav"><?php the_posts_pagination(); ?></div>
<?php else : ?>
    <h1 class="d2 bm-page__title"><?php esc_html_e( 'Page not found', 'brokermojo' ); ?></h1>
    <p class="body-lg"><a class="btn btn--brand" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span><?php esc_html_e( 'Back to home', 'brokermojo' ); ?></span></a></p>
<?php endif; ?>
  </div>
</section>
<?php
get_footer();
