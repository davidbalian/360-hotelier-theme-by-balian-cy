<?php
/**
 * Template Name: About Us
 *
 * @package 360-hotelier
 */

$page_hero_title    = __( 'About Us', '360-hotelier' );
$page_hero_tagline  = __( 'Your Trusted Hotel Consultant in Cyprus', '360-hotelier' );
$page_hero_subtitle = __( '360° Hotelier Consulting — 15+ years of hospitality expertise driving revenue for independent hotels across Cyprus.', '360-hotelier' );
$page_hero_image    = content_url( '/uploads/2026/03/featured-360-hotelier.webp' );

get_header();
get_template_part( 'template-parts/page/page-hero' );
?>

<main id="main" class="site-main page-about">

    <!-- Intro Section -->
    <section class="page-section page-section--white">
        <div class="site-container">
            <div class="page-about__intro-grid">
                <div class="page-about__intro-text fade-in fade-in-delay-0">
                    <h2 class="page-section__title"><?php esc_html_e( 'About 360° Hotelier Consulting', '360-hotelier' ); ?></h2>
                    <p><?php esc_html_e( '360° Hotelier Consulting is a Cyprus-based hotel consultancy providing strategic commercial support to independent hotels, boutique properties and resorts across the island.', '360-hotelier' ); ?></p>
                    <p><?php esc_html_e( 'As an experienced hotel consultant in Cyprus, we specialize in hotel revenue management, online sales & B2B distribution, e-commerce, digital marketing and tour-operator contracting — helping hotels increase revenue, improve profitability and strengthen their market positioning.', '360-hotelier' ); ?></p>
                    <p><?php esc_html_e( "With more than 15 years of experience in the hospitality and travel industry, we support hotels in navigating today's complex commercial environment through data-driven strategies, digital expertise and hands-on execution. We work with a select number of hotels, allowing us to remain fully engaged, responsive and accountable.", '360-hotelier' ); ?></p>
                </div>
                <div class="page-about__intro-image fade-in fade-in-delay-1" style="background-image: url('<?php echo esc_url( home_url( '/wp-content/uploads/2026/03/why-choose-360-hotelier.webp' ) ); ?>');" aria-hidden="true"></div>
            </div>
        </div>
    </section>

    <!-- What We Do -->
    <section class="page-section page-section--gray">
        <div class="site-container">
            <div class="page-section__heading page-section__heading--center fade-in fade-in-delay-0">
                <h2 class="page-section__title"><?php esc_html_e( 'What We Do', '360-hotelier' ); ?></h2>
                <p class="page-section__subtitle"><?php esc_html_e( "End-to-end commercial consulting tailored to each property's market and goals.", '360-hotelier' ); ?></p>
            </div>
            <div class="page-about__services-grid">
                <div class="front-why-choose__box card-border fade-in fade-in-delay-1">
                    <div class="front-why-choose__box-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M4 10h12"/><path d="M4 14h12"/><path d="M19 6a7.7 7.7 0 0 0-5.2-2H7"/><path d="M7 18h6.8a7.7 7.7 0 0 0 5.2-2"/></svg>
                    </div>
                    <h3 class="front-why-choose__box-title text-md"><?php esc_html_e( 'Yield & Revenue Management', '360-hotelier' ); ?></h3>
                    <p class="front-why-choose__box-text text-body"><?php esc_html_e( 'Strategic pricing, demand forecasting and segmentation designed to maximize RevPAR and revenue performance.', '360-hotelier' ); ?></p>
                </div>
                <div class="front-why-choose__box card-border fade-in fade-in-delay-2">
                    <div class="front-why-choose__box-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                    </div>
                    <h3 class="front-why-choose__box-title text-md"><?php esc_html_e( 'Online Sales & B2B Distribution', '360-hotelier' ); ?></h3>
                    <p class="front-why-choose__box-text text-body"><?php esc_html_e( 'OTA optimization, channel-mix strategy and development of profitable B2B partnerships.', '360-hotelier' ); ?></p>
                </div>
                <div class="front-why-choose__box card-border fade-in fade-in-delay-3">
                    <div class="front-why-choose__box-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    </div>
                    <h3 class="front-why-choose__box-title text-md"><?php esc_html_e( 'E-Commerce & Digital Marketing', '360-hotelier' ); ?></h3>
                    <p class="front-why-choose__box-text text-body"><?php esc_html_e( 'Direct booking optimization, SEO & SEM, social media marketing and digital performance analysis.', '360-hotelier' ); ?></p>
                </div>
                <div class="front-why-choose__box card-border fade-in fade-in-delay-4">
                    <div class="front-why-choose__box-icon" aria-hidden="true">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <h3 class="front-why-choose__box-title text-md"><?php esc_html_e( 'Contracting & Tour Operator Negotiations', '360-hotelier' ); ?></h3>
                    <p class="front-why-choose__box-text text-body"><?php esc_html_e( 'Professional representation and negotiation with tour operators and wholesalers, acting in the hotel\'s best commercial interest.', '360-hotelier' ); ?></p>
                </div>
            </div>
        </div>
    </section>

    <?php
    $GLOBALS['hotelier_section_founder_hide_about_cta'] = true;
    get_template_part(
        'template-parts/front-page/section',
        'founder',
        array(
            'hide_about_cta' => true,
        )
    );
    unset( $GLOBALS['hotelier_section_founder_hide_about_cta'] );
    ?>

    <!-- CTA Banner -->
    <section class="front-featured-banner card-border" style="background-image: url('<?php echo esc_url( content_url( '/uploads/2026/03/featured-360-hotelier.webp' ) ); ?>');">
        <div class="front-featured-banner__overlay section-overlay"></div>
        <div class="site-container front-featured-banner__content fade-in fade-in-delay-0">
            <h2 class="front-featured-banner__title text-4xl"><?php esc_html_e( 'Looking for a Hotel Consultant in Cyprus?', '360-hotelier' ); ?></h2>
            <p class="front-featured-banner__text"><?php esc_html_e( "Let's discuss how 360° Hotelier Consulting can support your hotel's revenue, distribution and digital growth.", '360-hotelier' ); ?></p>
            <div class="front-featured-banner__actions">
                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'Book a Free Consultation', '360-hotelier' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="btn btn--ghost"><?php esc_html_e( 'Explore Our Services', '360-hotelier' ); ?></a>
            </div>
        </div>
    </section>

</main>

<?php get_footer();
