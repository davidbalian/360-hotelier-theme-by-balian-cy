<?php
/**
 * Template Name: Services
 *
 * @package 360-hotelier
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="site-container page-services">

        <h1 class="page-services__title"><?php esc_html_e( 'Our Core Services', '360-hotelier' ); ?></h1>
        <p class="page-services__intro"><?php esc_html_e( 'We help hotels drive direct bookings, optimise channel mix, and negotiate better tour-operator & B2B agreements.', '360-hotelier' ); ?></p>

        <div class="page-services__grid">
            <div class="page-services__card card-border">
                <h2 class="page-services__card-title"><?php esc_html_e( 'Yield & Revenue Management', '360-hotelier' ); ?></h2>
                <p class="page-services__card-text"><?php esc_html_e( 'Dynamic pricing, forecasting, segmentation and performance analysis to maximise RevPAR and increase revenue.', '360-hotelier' ); ?></p>
                <a href="<?php echo esc_url( home_url( '/services/revenue-management/' ) ); ?>" class="page-services__link"><?php esc_html_e( 'Learn more', '360-hotelier' ); ?></a>
            </div>

            <div class="page-services__card card-border">
                <h2 class="page-services__card-title"><?php esc_html_e( 'Online Sales & B2B Distribution', '360-hotelier' ); ?></h2>
                <p class="page-services__card-text"><?php esc_html_e( 'OTA optimisation, B2B partnerships, channel-mix strategy and distribution management across global and regional markets.', '360-hotelier' ); ?></p>
                <a href="<?php echo esc_url( home_url( '/services/online-sales-distribution/' ) ); ?>" class="page-services__link"><?php esc_html_e( 'Learn more', '360-hotelier' ); ?></a>
            </div>

            <div class="page-services__card card-border">
                <h2 class="page-services__card-title"><?php esc_html_e( 'E-Commerce & Digital Marketing', '360-hotelier' ); ?></h2>
                <p class="page-services__card-text"><?php esc_html_e( 'Direct booking strategy, SEO/SEM campaigns, social media management and digital performance tracking.', '360-hotelier' ); ?></p>
                <a href="<?php echo esc_url( home_url( '/services/digital-marketing/' ) ); ?>" class="page-services__link"><?php esc_html_e( 'Learn more', '360-hotelier' ); ?></a>
            </div>

            <div class="page-services__card card-border">
                <h2 class="page-services__card-title"><?php esc_html_e( 'Contracting & Negotiations (Tour Operators)', '360-hotelier' ); ?></h2>
                <p class="page-services__card-text"><?php esc_html_e( 'Full contracting services, benchmarking, negotiation support and relationship management with key tour operators & travel partners.', '360-hotelier' ); ?></p>
                <a href="<?php echo esc_url( home_url( '/services/tour-operator-contracting/' ) ); ?>" class="page-services__link"><?php esc_html_e( 'Learn more', '360-hotelier' ); ?></a>
            </div>
        </div>

        <p class="page-services__cta">
            <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'Explore All Services', '360-hotelier' ); ?></a>
        </p>

    </div>
</main>

<?php get_footer();
