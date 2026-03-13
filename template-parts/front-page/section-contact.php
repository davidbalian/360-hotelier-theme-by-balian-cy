<?php
/**
 * Front page contact / consultation section.
 *
 * @package 360-hotelier
 */
?>
<section class="front-contact">
    <div class="site-container">
        <h2 class="front-contact__title"><?php esc_html_e( "Ready to Boost Your Hotel's Revenue & Distribution?", '360-hotelier' ); ?></h2>
        <p class="front-contact__text"><?php esc_html_e( "Let's discuss your property and explore how we can support your commercial growth.", '360-hotelier' ); ?></p>
        <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="front-contact__cta"><?php esc_html_e( 'Start Your Free Hotel Strategy Session', '360-hotelier' ); ?></a>
        <p class="front-contact__or"><?php esc_html_e( 'Or contact us directly:', '360-hotelier' ); ?></p>
        <div class="front-contact__details">
            <p><a href="tel:+35770001818">7000 1818</a></p>
            <p><a href="mailto:info@360hotelier.com">info@360hotelier.com</a></p>
            <p>9, Epaminondou street, 3075, Limassol, Cyprus</p>
        </div>
    </div>
</section>
