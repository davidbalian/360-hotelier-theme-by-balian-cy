<?php
/**
 * Front page template.
 *
 * Outputs landing page sections when a static front page is set in Settings > Reading.
 *
 * @package 360-hotelier
 */

get_header(); ?>

<main id="main" class="site-main front-page-main">

    <?php get_template_part( 'template-parts/front-page/section', 'hero' ); ?>
    <?php get_template_part( 'template-parts/front-page/section', 'services-overview' ); ?>
    <?php get_template_part( 'template-parts/front-page/section', 'why-choose' ); ?>
    <?php get_template_part( 'template-parts/front-page/section', 'results' ); ?>
    <?php get_template_part( 'template-parts/front-page/section', 'approach' ); ?>
    <?php get_template_part( 'template-parts/front-page/section', 'founder' ); ?>
    <?php get_template_part( 'template-parts/front-page/section', 'featured-banner' ); ?>
    <?php get_template_part( 'template-parts/front-page/section', 'contact' ); ?>

</main>

<?php get_footer();
