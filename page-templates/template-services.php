<?php
/**
 * Template Name: Services
 *
 * @package 360-hotelier
 */

$page_hero_title    = __( 'Our Core Services', '360-hotelier' );
$page_hero_subtitle = __( 'Revenue, distribution and digital growth — end to end. Your external commercial team for hotels in Cyprus.', '360-hotelier' );
$page_hero_image    = content_url( '/uploads/2026/03/360-hotelier-consulting-cyprus-hero.webp' );

get_header();
get_template_part( 'template-parts/page/page-hero' );
?>

<main id="main" class="site-main page-services">

    <!-- Services Grid -->
    <section class="page-section page-services__section">
        <div class="site-container">
            <div class="page-section__heading fade-in fade-in-delay-0">
                <h2 class="page-section__title"><?php esc_html_e( 'What We Offer', '360-hotelier' ); ?></h2>
                <p class="page-section__subtitle"><?php esc_html_e( 'We help hotels drive direct bookings, optimise channel mix and negotiate stronger tour-operator & B2B agreements.', '360-hotelier' ); ?></p>
            </div>

            <div class="page-services__grid">
                <div class="page-services__card card-border fade-in fade-in-delay-1">
                    <?php Hotelier_Lucide_Icon::render( 'circle-dollar-sign', 'page-services__card-icon' ); ?>
                    <h2 class="page-services__card-title"><?php esc_html_e( 'Yield & Revenue Management', '360-hotelier' ); ?></h2>
                    <p class="page-services__card-text"><?php esc_html_e( 'Dynamic pricing, forecasting, segmentation and performance analysis to maximise RevPAR and increase revenue.', '360-hotelier' ); ?></p>
                    <a href="<?php echo esc_url( home_url( '/services/revenue-management/' ) ); ?>" class="page-services__link"><?php esc_html_e( 'Learn more →', '360-hotelier' ); ?></a>
                </div>

                <div class="page-services__card card-border fade-in fade-in-delay-2">
                    <?php Hotelier_Lucide_Icon::render( 'globe', 'page-services__card-icon' ); ?>
                    <h2 class="page-services__card-title"><?php esc_html_e( 'Online Sales & B2B Distribution', '360-hotelier' ); ?></h2>
                    <p class="page-services__card-text"><?php esc_html_e( 'OTA optimisation, B2B partnerships, channel-mix strategy and distribution management across global and regional markets.', '360-hotelier' ); ?></p>
                    <a href="<?php echo esc_url( home_url( '/services/online-sales-distribution/' ) ); ?>" class="page-services__link"><?php esc_html_e( 'Learn more →', '360-hotelier' ); ?></a>
                </div>

                <div class="page-services__card card-border fade-in fade-in-delay-3">
                    <?php Hotelier_Lucide_Icon::render( 'monitor', 'page-services__card-icon' ); ?>
                    <h2 class="page-services__card-title"><?php esc_html_e( 'E-Commerce & Digital Marketing', '360-hotelier' ); ?></h2>
                    <p class="page-services__card-text"><?php esc_html_e( 'Direct booking strategy, SEO/SEM campaigns, social media management and digital performance tracking.', '360-hotelier' ); ?></p>
                    <a href="<?php echo esc_url( home_url( '/services/digital-marketing/' ) ); ?>" class="page-services__link"><?php esc_html_e( 'Learn more →', '360-hotelier' ); ?></a>
                </div>

                <div class="page-services__card card-border fade-in fade-in-delay-4">
                    <?php Hotelier_Lucide_Icon::render( 'users', 'page-services__card-icon' ); ?>
                    <h2 class="page-services__card-title"><?php esc_html_e( 'Contracting & Negotiations (Tour Operators)', '360-hotelier' ); ?></h2>
                    <p class="page-services__card-text"><?php esc_html_e( 'Full contracting services, benchmarking, negotiation support and relationship management with key tour operators & travel partners.', '360-hotelier' ); ?></p>
                    <a href="<?php echo esc_url( home_url( '/services/tour-operator-contracting/' ) ); ?>" class="page-services__link"><?php esc_html_e( 'Learn more →', '360-hotelier' ); ?></a>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="front-featured-banner card-border" style="background-image: url('<?php echo esc_url( content_url( '/uploads/2026/03/featured-360-hotelier.webp' ) ); ?>');">
        <div class="front-featured-banner__overlay section-overlay"></div>
        <div class="site-container front-featured-banner__content fade-in fade-in-delay-0">
            <h2 class="front-featured-banner__title text-4xl"><?php esc_html_e( "Ready to Grow Your Hotel's Revenue?", '360-hotelier' ); ?></h2>
            <p class="front-featured-banner__text"><?php esc_html_e( "Let's build a commercial strategy tailored to your property, market and goals.", '360-hotelier' ); ?></p>
            <div class="front-featured-banner__actions">
                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'Book a Free Consultation', '360-hotelier' ); ?></a>
            </div>
        </div>
    </section>

</main>

<?php get_footer();
