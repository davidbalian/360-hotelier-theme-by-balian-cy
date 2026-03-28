<?php
/**
 * Front page "How We Work" section.
 *
 * @package 360-hotelier
 */
?>
<section class="front-approach">
    <div class="site-container">

        <div class="front-approach__heading fade-in fade-in-delay-0">
            <h2 class="front-section__title text-2xl"><?php esc_html_e( 'How We Work', '360-hotelier' ); ?></h2>
            <p class="front-section__subtitle"><?php esc_html_e( 'Four steps. Nothing hidden.', '360-hotelier' ); ?></p>
        </div>

        <div class="front-approach__bento">

            <div class="front-approach__bento-card card-border fade-in fade-in-delay-1">
                <span class="front-approach__step-number text-3xl">01</span>
                <h3 class="front-approach__step-title text-base"><?php esc_html_e( 'Audit & Insights', '360-hotelier' ); ?></h3>
                <p class="front-approach__step-text text-body"><?php esc_html_e( 'We analyze your current performance, channels, website, pricing and contracts.', '360-hotelier' ); ?></p>
            </div>

            <div class="front-approach__bento-card card-border fade-in fade-in-delay-2">
                <span class="front-approach__step-number text-3xl">02</span>
                <h3 class="front-approach__step-title text-base"><?php esc_html_e( 'Strategy & Planning', '360-hotelier' ); ?></h3>
                <p class="front-approach__step-text text-body"><?php esc_html_e( "A tailored commercial strategy aligned with your hotel's goals and market positioning.", '360-hotelier' ); ?></p>
            </div>

            <div class="front-approach__bento-card card-border fade-in fade-in-delay-3">
                <span class="front-approach__step-number text-3xl">03</span>
                <h3 class="front-approach__step-title text-base"><?php esc_html_e( 'Execution & Management', '360-hotelier' ); ?></h3>
                <p class="front-approach__step-text text-body"><?php esc_html_e( 'Hands-on management across sales, pricing, digital and contracting.', '360-hotelier' ); ?></p>
            </div>

            <div class="front-approach__bento-card card-border fade-in fade-in-delay-4">
                <span class="front-approach__step-number text-3xl">04</span>
                <h3 class="front-approach__step-title text-base"><?php esc_html_e( 'Review & Optimization', '360-hotelier' ); ?></h3>
                <p class="front-approach__step-text text-body"><?php esc_html_e( 'Monthly reporting, KPI analysis and continuous improvements.', '360-hotelier' ); ?></p>
            </div>

        </div>

        <div class="front-approach__bento-cta fade-in fade-in-delay-5">
            <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'Book a Free Consultation', '360-hotelier' ); ?></a>
        </div>

    </div>
</section>
