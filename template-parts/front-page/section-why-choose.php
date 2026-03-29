<?php
/**
 * Front page "Why Choose Us" section.
 *
 * @package 360-hotelier
 */
?>
<section class="front-why-choose">
    <div class="site-container">
        <h2 class="front-section__title fade-in fade-in-delay-0"><?php esc_html_e( 'Why Hotels Choose 360° Hotelier Consulting', '360-hotelier' ); ?></h2>
        <p class="front-section__subtitle fade-in fade-in-delay-1"><?php esc_html_e( 'Deep local knowledge, hands-on experience and real results.', '360-hotelier' ); ?></p>
        <div class="front-why-choose__layout">
            <div class="front-why-choose__grid">
                <div class="front-why-choose__box card-border fade-in fade-in-delay-2">
                    <div class="front-why-choose__box-icon" aria-hidden="true">
                        <?php Hotelier_Lucide_Icon::render( 'map-pin' ); ?>
                    </div>
                    <h3 class="front-why-choose__box-title"><?php esc_html_e( 'Cyprus Market Knowledge', '360-hotelier' ); ?></h3>
                    <p class="front-why-choose__box-text text-body"><?php esc_html_e( 'Island seasonality, tour-operator networks and source market demand - we know this market from the inside.', '360-hotelier' ); ?></p>
                </div>
                <div class="front-why-choose__box card-border fade-in fade-in-delay-3">
                    <div class="front-why-choose__box-icon" aria-hidden="true">
                        <?php Hotelier_Lucide_Icon::render( 'clock' ); ?>
                    </div>
                    <h3 class="front-why-choose__box-title"><?php esc_html_e( 'Experience', '360-hotelier' ); ?></h3>
                    <p class="front-why-choose__box-text text-body"><?php esc_html_e( '15+ years of hotel sales, revenue, marketing and OTA experience.', '360-hotelier' ); ?></p>
                </div>
                <div class="front-why-choose__box card-border fade-in fade-in-delay-4">
                    <div class="front-why-choose__box-icon" aria-hidden="true">
                        <?php Hotelier_Lucide_Icon::render( 'briefcase' ); ?>
                    </div>
                    <h3 class="front-why-choose__box-title"><?php esc_html_e( 'Full Commercial Support', '360-hotelier' ); ?></h3>
                    <p class="front-why-choose__box-text text-body"><?php esc_html_e( 'We cover the full revenue cycle: contracting, pricing, distribution and digital.', '360-hotelier' ); ?></p>
                </div>
                <div class="front-why-choose__box card-border fade-in fade-in-delay-5">
                    <div class="front-why-choose__box-icon" aria-hidden="true">
                        <?php Hotelier_Lucide_Icon::render( 'users' ); ?>
                    </div>
                    <h3 class="front-why-choose__box-title"><?php esc_html_e( 'Trusted Partnerships', '360-hotelier' ); ?></h3>
                    <p class="front-why-choose__box-text text-body"><?php esc_html_e( 'We keep our client roster small so every hotel gets real attention and real results.', '360-hotelier' ); ?></p>
                </div>
            </div>
            <div class="front-why-choose__image fade-in fade-in-delay-3" aria-hidden="true" style="background-image: url('<?php echo esc_url( content_url( '/uploads/2026/03/why-choose-360-hotelier.webp' ) ); ?>');"></div>
        </div>
    </div>
</section>
