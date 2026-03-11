<?php
/**
 * Template for displaying all static pages.
 *
 * @package 360-hotelier
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="site-container">

        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'template-parts/content/content', 'page' ); ?>
        <?php endwhile; ?>

    </div>
</main>

<?php get_footer();
