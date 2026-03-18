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
        <h2 class="front-contact__title text-xl"><?php esc_html_e( "Ready to Boost Your Hotel's Revenue & Distribution?", '360-hotelier' ); ?></h2>
        <p class="front-contact__text"><?php esc_html_e( "Let's discuss your property and explore how we can support your commercial growth.", '360-hotelier' ); ?></p>
        <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--primary front-contact__cta"><?php esc_html_e( 'Start Your Free Hotel Strategy Session', '360-hotelier' ); ?></a>
    </div>
</section>
