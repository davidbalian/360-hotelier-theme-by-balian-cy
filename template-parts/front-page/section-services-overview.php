<?php
/**
 * Front page services overview section.
 *
 * @package 360-hotelier
 */
$services_url = home_url( '/services/' );
?>
<section class="front-services-overview card-border">
    <div class="site-container">
        <h2 class="front-section__title"><?php esc_html_e( 'Our Core Services', '360-hotelier' ); ?></h2>
        <p class="front-section__subtitle"><?php esc_html_e( 'We provide complete hotel commercial solutions built to drive revenue, strengthen your online presence and improve profitability.', '360-hotelier' ); ?></p>
        <div class="front-services-overview__grid">
            <div class="front-services-overview__card card-border">
                <h3 class="front-services-overview__card-title"><?php esc_html_e( 'Yield & Revenue Management', '360-hotelier' ); ?></h3>
                <p class="front-services-overview__card-text"><?php esc_html_e( "Dynamic pricing, forecasting and RevPAR optimization tailored to your hotel's performance.", '360-hotelier' ); ?></p>
            </div>
            <div class="front-services-overview__card card-border">
                <h3 class="front-services-overview__card-title"><?php esc_html_e( 'Online Sales & B2B Distribution', '360-hotelier' ); ?></h3>
                <p class="front-services-overview__card-text"><?php esc_html_e( 'OTA optimization, channel-mix management and new B2B strategic partnerships.', '360-hotelier' ); ?></p>
            </div>
            <div class="front-services-overview__card card-border">
                <h3 class="front-services-overview__card-title"><?php esc_html_e( 'E-Commerce & Digital Marketing', '360-hotelier' ); ?></h3>
                <p class="front-services-overview__card-text"><?php esc_html_e( 'Direct booking strategy, SEO/SEM, social media management and digital performance tracking.', '360-hotelier' ); ?></p>
            </div>
            <div class="front-services-overview__card card-border">
                <h3 class="front-services-overview__card-title"><?php esc_html_e( 'Contracting & Negotiations (Tour Operators)', '360-hotelier' ); ?></h3>
                <p class="front-services-overview__card-text"><?php esc_html_e( 'Professional negotiation and full contracting support with key tour operators and wholesalers.', '360-hotelier' ); ?></p>
            </div>
        </div>
        <p class="front-services-overview__cta">
            <a href="<?php echo esc_url( $services_url ); ?>" class="btn btn--primary"><?php esc_html_e( 'Explore Our Hotel Consulting Services', '360-hotelier' ); ?></a>
        </p>
    </div>
</section>
