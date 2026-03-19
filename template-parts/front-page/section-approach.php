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

        <div class="front-approach__inner">

            <!-- Image column (left) -->
            <div class="front-approach__image fade-in fade-in-delay-1">
                <img src="<?php echo esc_url( content_url( 'uploads/2026/03/person-at-hotel-reception-scaled.webp' ) ); ?>" alt="<?php esc_attr_e( 'Hotel reception consultant at work', '360-hotelier' ); ?>" class="front-approach__img">
            </div>

            <!-- Steps column (right) -->
            <div class="front-approach__content front-approach__card card-border">
                <div class="front-approach__steps">

                    <div class="front-approach__step fade-in fade-in-delay-2">
                        <span class="front-approach__step-number text-3xl">01</span>
                        <div class="front-approach__step-body">
                            <h3 class="front-approach__step-title text-base"><?php esc_html_e( 'Audit & Insights', '360-hotelier' ); ?></h3>
                            <p class="front-approach__step-text text-body"><?php esc_html_e( 'We analyze your current performance, channels, website, pricing and contracts.', '360-hotelier' ); ?></p>
                        </div>
                    </div>
                    <hr class="front-approach__divider">

                    <div class="front-approach__step fade-in fade-in-delay-3">
                        <span class="front-approach__step-number text-3xl">02</span>
                        <div class="front-approach__step-body">
                            <h3 class="front-approach__step-title text-base"><?php esc_html_e( 'Strategy & Planning', '360-hotelier' ); ?></h3>
                            <p class="front-approach__step-text text-body"><?php esc_html_e( "A tailored commercial strategy aligned with your hotel's goals and market positioning.", '360-hotelier' ); ?></p>
                        </div>
                    </div>
                    <hr class="front-approach__divider">

                    <div class="front-approach__step fade-in fade-in-delay-4">
                        <span class="front-approach__step-number text-3xl">03</span>
                        <div class="front-approach__step-body">
                            <h3 class="front-approach__step-title text-base"><?php esc_html_e( 'Execution & Management', '360-hotelier' ); ?></h3>
                            <p class="front-approach__step-text text-body"><?php esc_html_e( 'Hands-on management across sales, pricing, digital and contracting.', '360-hotelier' ); ?></p>
                        </div>
                    </div>
                    <hr class="front-approach__divider">

                    <div class="front-approach__step fade-in fade-in-delay-5">
                        <span class="front-approach__step-number text-3xl">04</span>
                        <div class="front-approach__step-body">
                            <h3 class="front-approach__step-title text-base"><?php esc_html_e( 'Review & Optimization', '360-hotelier' ); ?></h3>
                            <p class="front-approach__step-text text-body"><?php esc_html_e( 'Monthly reporting, KPI analysis and continuous improvements.', '360-hotelier' ); ?></p>
                        </div>
                    </div>

                </div>

                <a href="#" class="btn btn--primary front-approach__cta fade-in fade-in-delay-6"><?php esc_html_e( 'Book a Free Consultation', '360-hotelier' ); ?></a>
            </div>

        </div>
    </div>
</section>
