<?php
/**
 * Main template file — fallback for all unmatched templates.
 *
 * @package 360-hotelier
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="site-container">

        <?php if ( have_posts() ) : ?>

            <div class="posts-loop">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/content/content' ); ?>
                <?php endwhile; ?>
            </div>

            <?php the_posts_navigation(); ?>

        <?php else : ?>

            <?php get_template_part( 'template-parts/content/content', 'none' ); ?>

        <?php endif; ?>

    </div>
</main>

<?php get_footer();
