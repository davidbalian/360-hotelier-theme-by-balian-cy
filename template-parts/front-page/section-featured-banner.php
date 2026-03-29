<?php
/**
 * Front page featured banner section.
 *
 * @package 360-hotelier
 */
?>
<section class="front-featured-banner card-border" style="background-image: url('<?php echo esc_url( content_url( '/uploads/2026/03/featured-360-hotelier.webp' ) ); ?>');">
    <div class="front-featured-banner__overlay section-overlay"></div>
    <div class="site-container front-featured-banner__content fade-in fade-in-delay-0">
        <h2 class="front-featured-banner__title"><?php esc_html_e( "We Become Your Hotel's External Commercial Team", '360-hotelier' ); ?></h2>
        <p class="front-featured-banner__text"><?php esc_html_e( 'Pricing, distribution, contracting and digital marketing — all handled.', '360-hotelier' ); ?></p>
        <div class="front-featured-banner__actions">
            <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( 'contact' ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'Book a Free Consultation', '360-hotelier' ); ?></a>
        </div>
    </div>
</section>
