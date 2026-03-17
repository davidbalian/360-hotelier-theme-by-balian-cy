<?php
/**
 * Front page featured banner section.
 *
 * @package 360-hotelier
 */
?>
<section class="front-featured-banner card-border" style="background-image: url('<?php echo esc_url( content_url( '/uploads/2026/03/featured-360-hotelier.webp' ) ); ?>');">
    <div class="front-featured-banner__overlay"></div>
    <div class="site-container front-featured-banner__content">
        <h2 class="front-featured-banner__title"><?php esc_html_e( "We Become Your Hotel's External Commercial Team", '360-hotelier' ); ?></h2>
        <p class="front-featured-banner__text"><?php esc_html_e( 'From pricing to distribution, from contracting to digital marketing - we support every part of your revenue journey.', '360-hotelier' ); ?></p>
        <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'Schedule Your Free Revenue Strategy Consultation', '360-hotelier' ); ?></a>
    </div>
</section>
