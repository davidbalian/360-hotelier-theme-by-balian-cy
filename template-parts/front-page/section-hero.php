<?php
/**
 * Front page hero section.
 *
 * @package 360-hotelier
 */
?>
<section class="front-hero">
    <div class="site-container">
        <h1 class="front-hero__title"><?php esc_html_e( 'Revenue, Distribution & Digital Growth for Hotels in Cyprus', '360-hotelier' ); ?></h1>
        <p class="front-hero__subheadline"><?php esc_html_e( 'We help hotels increase revenue, optimize online sales and strengthen their digital presence through expert revenue management, B2B distribution strategy, e-commerce optimization and tour-operator contracting.', '360-hotelier' ); ?></p>
        <p class="front-hero__intro"><?php esc_html_e( "360° Hotelier Consulting is a hotel sales, revenue and digital distribution agency based in Cyprus. We act as your hotel's extended commercial team - driving performance, improving visibility and transforming your profit potential.", '360-hotelier' ); ?></p>
        <div class="front-hero__ctas">
            <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="front-hero__cta front-hero__cta--primary"><?php esc_html_e( 'Start Your Free Hotel Strategy Session', '360-hotelier' ); ?></a>
            <a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="front-hero__cta front-hero__cta--secondary"><?php esc_html_e( 'Explore Our Hotel Consulting Services', '360-hotelier' ); ?></a>
        </div>
    </div>
</section>
