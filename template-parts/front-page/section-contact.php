<?php
/**
 * Front page contact / consultation section.
 *
 * @package 360-hotelier
 */
?>
<section class="front-contact" style="background-image: url('<?php echo esc_url( content_url( '/uploads/2026/03/contact-360-hotelier.webp' ) ); ?>');">
    <div class="front-contact__overlay section-overlay"></div>
    <div class="site-container front-contact__content">
        <h2 class="front-contact__title fade-in fade-in-delay-0"><?php esc_html_e( "Grow Your Hotel's Revenue.", '360-hotelier' ); ?></h2>
        <p class="front-contact__text fade-in fade-in-delay-1"><?php esc_html_e( "Tell us about your property. We'll identify where you're leaving revenue on the table.", '360-hotelier' ); ?></p>
        <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( 'contact' ) ); ?>" class="btn btn--primary front-contact__cta fade-in fade-in-delay-2"><?php esc_html_e( 'Book a Free Strategy Session', '360-hotelier' ); ?></a>
    </div>
</section>
