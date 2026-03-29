<?php
/**
 * Front page services overview section.
 *
 * @package 360-hotelier
 */
$services_url = '#';
?>
<section class="front-services-overview card-border">
    <div class="site-container">
        <h2 class="front-section__title fade-in fade-in-delay-0"><?php esc_html_e( 'Our Core Services', '360-hotelier' ); ?></h2>
        <p class="front-section__subtitle fade-in fade-in-delay-1"><?php esc_html_e( 'Full commercial support to grow revenue, strengthen distribution and sharpen your digital presence.', '360-hotelier' ); ?></p>
        <div class="front-services-overview__grid">

            <div class="front-services-overview__card card-border fade-in fade-in-delay-2">
                <div class="front-services-overview__card-image">
                    <img src="<?php echo esc_url( content_url( '/uploads/2026/03/service-yield-revenue-management.webp' ) ); ?>" alt="Yield & Revenue Management" width="1920" height="1081" loading="lazy" sizes="(max-width: 768px) calc(100vw - 64px), 696px" />
                </div>
                <div class="front-services-overview__card-content">
                    <h3 class="front-services-overview__card-title"><?php esc_html_e( 'Yield & Revenue Management', '360-hotelier' ); ?></h3>
                    <p class="front-services-overview__card-text text-body"><?php esc_html_e( "Dynamic pricing, forecasting and RevPAR optimization tailored to your hotel's performance.", '360-hotelier' ); ?></p>
                </div>
            </div>

            <div class="front-services-overview__card card-border fade-in fade-in-delay-3">
                <div class="front-services-overview__card-image">
                    <img src="<?php echo esc_url( content_url( '/uploads/2026/03/service-online-sales-b2b-distribution.webp' ) ); ?>" alt="Online Sales & B2B Distribution" width="1920" height="1081" loading="lazy" sizes="(max-width: 768px) calc(100vw - 64px), 696px" />
                </div>
                <div class="front-services-overview__card-content">
                    <h3 class="front-services-overview__card-title"><?php esc_html_e( 'Online Sales & B2B Distribution', '360-hotelier' ); ?></h3>
                    <p class="front-services-overview__card-text text-body"><?php esc_html_e( 'OTA optimization, channel-mix management and new B2B strategic partnerships.', '360-hotelier' ); ?></p>
                </div>
            </div>

            <div class="front-services-overview__card card-border fade-in fade-in-delay-4">
                <div class="front-services-overview__card-image">
                    <img src="<?php echo esc_url( content_url( '/uploads/2026/03/service-ecommerce-digital-marketing.webp' ) ); ?>" alt="E-Commerce & Digital Marketing" width="1920" height="1081" loading="lazy" sizes="(max-width: 768px) calc(100vw - 64px), 696px" />
                </div>
                <div class="front-services-overview__card-content">
                    <h3 class="front-services-overview__card-title"><?php esc_html_e( 'E-Commerce & Digital Marketing', '360-hotelier' ); ?></h3>
                    <p class="front-services-overview__card-text text-body"><?php esc_html_e( 'Direct booking strategy, SEO/SEM, social media management and digital performance tracking.', '360-hotelier' ); ?></p>
                </div>
            </div>

            <div class="front-services-overview__card card-border fade-in fade-in-delay-5">
                <div class="front-services-overview__card-image">
                    <img src="<?php echo esc_url( content_url( '/uploads/2026/03/service-contracting-negotiations.webp' ) ); ?>" alt="Contracting & Negotiations" width="1920" height="1081" loading="lazy" sizes="(max-width: 768px) calc(100vw - 64px), 696px" />
                </div>
                <div class="front-services-overview__card-content">
                    <h3 class="front-services-overview__card-title"><?php esc_html_e( 'Contracting & Negotiations (Tour Operators)', '360-hotelier' ); ?></h3>
                    <p class="front-services-overview__card-text text-body"><?php esc_html_e( 'Professional negotiation and full contracting support with key tour operators and wholesalers.', '360-hotelier' ); ?></p>
                </div>
            </div>

        </div>
        <p class="front-services-overview__cta fade-in fade-in-delay-6">
            <a href="<?php echo esc_url( $services_url ); ?>" class="btn btn--primary"><?php esc_html_e( 'View Our Services', '360-hotelier' ); ?></a>
        </p>
    </div>
</section>
