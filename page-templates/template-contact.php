<?php
/**
 * Template Name: Contact
 *
 * @package 360-hotelier
 */

$page_hero_title    = __( "Ready to Boost Your Hotel's Revenue & Distribution?", '360-hotelier' );
$page_hero_subtitle = __( "Let's discuss your property and explore how we can support your commercial growth.", '360-hotelier' );
$page_hero_image    = content_url( '/uploads/2026/03/featured-360-hotelier.webp' );

get_header();
get_template_part( 'template-parts/page/page-hero' );
?>

<main id="main" class="site-main page-contact">

    <section class="page-contact__section">
        <div class="site-container">
            <div class="page-contact__grid">

                <!-- Contact details card -->
                <div class="page-contact__card card-border fade-in fade-in-delay-0">
                    <h2 class="page-contact__card-title"><?php esc_html_e( 'Contact Us Directly', '360-hotelier' ); ?></h2>

                    <div class="page-contact__detail">
                        <svg class="page-contact__detail-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13.5 19.79 19.79 0 0 1 1.6 4.87 2 2 0 0 1 3.57 2.7h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 10.5a16 16 0 0 0 6 6l.9-.9a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 21.41 18l.01-1.08z"/></svg>
                        <div class="page-contact__detail-text">
                            <strong><?php esc_html_e( 'Phone', '360-hotelier' ); ?></strong>
                            <a href="tel:+35770001818">7000 1818</a>
                        </div>
                    </div>

                    <div class="page-contact__detail">
                        <svg class="page-contact__detail-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        <div class="page-contact__detail-text">
                            <strong><?php esc_html_e( 'Email', '360-hotelier' ); ?></strong>
                            <a href="mailto:info@360hotelier.com">info@360hotelier.com</a>
                        </div>
                    </div>

                    <div class="page-contact__detail">
                        <svg class="page-contact__detail-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7z"/><circle cx="12" cy="9" r="2.5"/></svg>
                        <div class="page-contact__detail-text">
                            <strong><?php esc_html_e( 'Address', '360-hotelier' ); ?></strong>
                            <?php esc_html_e( '9, Epaminondou street, 3075, Limassol, Cyprus', '360-hotelier' ); ?>
                        </div>
                    </div>
                </div>

                <!-- CTA card -->
                <div class="page-contact__card page-contact__card--cta fade-in fade-in-delay-1">
                    <h2 class="page-contact__card-title"><?php esc_html_e( 'Book a Free Strategy Session', '360-hotelier' ); ?></h2>
                    <p><?php esc_html_e( "Tell us about your hotel and we'll walk you through how 360° Hotelier Consulting can support your commercial growth — at no cost or commitment.", '360-hotelier' ); ?></p>
                    <p><?php esc_html_e( 'We work with a select number of hotels so every client gets real attention and real results.', '360-hotelier' ); ?></p>
                    <a href="#" class="btn btn--ghost" style="margin-top: 1rem;"><?php esc_html_e( 'Start Your Free Session', '360-hotelier' ); ?></a>
                </div>

            </div>
        </div>
    </section>

</main>

<?php get_footer();
