<?php
/**
 * Template for displaying single posts.
 *
 * @package 360-hotelier
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="site-container">

        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part( 'template-parts/content/content' ); ?>
        <?php endwhile; ?>

        <?php
        the_post_navigation( array(
            'prev_text' => '&larr; %title',
            'next_text' => '%title &rarr;',
        ) );
        ?>

    </div>
</main>

<?php get_footer();
