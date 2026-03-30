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
    <?php get_template_part( 'template-parts/front-page/section', 'featured-banner' ); ?>
    <?php get_template_part( 'template-parts/front-page/section', 'founder' ); ?>
    <?php
    get_template_part(
        'template-parts/components/section-faq',
        null,
        array(
            'hotelier_section_faq' => array(
                'context'          => Hotelier_Faq_Content::CONTEXT_FRONT_PAGE,
                'heading'          => __( 'Frequently asked questions', '360-hotelier' ),
                'intro'            => __( 'Quick answers about occupancy, revenue management, and how we work with hotels in Cyprus and Greece.', '360-hotelier' ),
                'section_modifier' => 'front-page',
            ),
        )
    );
    ?>
    <?php get_template_part( 'template-parts/front-page/section', 'contact' ); ?>

</main>

<?php get_footer();
