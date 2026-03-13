<?php
/**
 * Template Name: Contact
 *
 * @package 360-hotelier
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="site-container page-contact">

        <h1 class="page-contact__title"><?php esc_html_e( "Ready to Boost Your Hotel's Revenue & Distribution?", '360-hotelier' ); ?></h1>
        <p class="page-contact__text"><?php esc_html_e( "Let's discuss your property and explore how we can support your commercial growth.", '360-hotelier' ); ?></p>

        <a href="#" class="front-cta-button page-contact__cta"><?php esc_html_e( 'Start Your Free Hotel Strategy Session', '360-hotelier' ); ?></a>

        <p class="page-contact__or"><?php esc_html_e( 'Or contact us directly:', '360-hotelier' ); ?></p>
        <div class="page-contact__details">
            <p><strong><?php esc_html_e( 'Phone:', '360-hotelier' ); ?></strong> <a href="tel:+35770001818">7000 1818</a></p>
            <p><strong><?php esc_html_e( 'Email:', '360-hotelier' ); ?></strong> <a href="mailto:info@360hotelier.com">info@360hotelier.com</a></p>
            <p><strong><?php esc_html_e( 'Address:', '360-hotelier' ); ?></strong> 9, Epaminondou street, 3075, Limassol, Cyprus</p>
        </div>

    </div>
</main>

<?php get_footer();
