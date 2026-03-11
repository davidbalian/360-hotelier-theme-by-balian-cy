<?php
/**
 * Front page template.
 *
 * Used when a static front page is set in Settings > Reading.
 *
 * @package 360-hotelier
 */

get_header(); ?>

<main id="main" class="site-main">

    <?php while ( have_posts() ) : the_post(); ?>
        <?php get_template_part( 'template-parts/content/content', 'page' ); ?>
    <?php endwhile; ?>

</main>

<?php get_footer();
