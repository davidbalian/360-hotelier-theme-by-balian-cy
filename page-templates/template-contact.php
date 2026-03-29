<?php
/**
 * Template Name: Contact
 *
 * @package 360-hotelier
 */

$page_hero_title    = __( 'Contact', '360-hotelier' );
$page_hero_tagline  = __( "Ready to Boost Your Hotel's Revenue & Distribution?", '360-hotelier' );
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
                        <?php Hotelier_Lucide_Icon::render( 'phone', 'page-contact__detail-icon' ); ?>
                        <div class="page-contact__detail-text">
                            <strong><?php esc_html_e( 'Phone', '360-hotelier' ); ?></strong>
                            <a href="tel:+35770001818">7000 1818</a>
                        </div>
                    </div>

                    <div class="page-contact__detail">
                        <?php Hotelier_Lucide_Icon::render( 'mail', 'page-contact__detail-icon' ); ?>
                        <div class="page-contact__detail-text">
                            <strong><?php esc_html_e( 'Email', '360-hotelier' ); ?></strong>
                            <a href="mailto:info@360hotelier.com">info@360hotelier.com</a>
                        </div>
                    </div>

                    <div class="page-contact__detail">
                        <?php Hotelier_Lucide_Icon::render( 'map-pin', 'page-contact__detail-icon' ); ?>
                        <div class="page-contact__detail-text">
                            <strong><?php esc_html_e( 'Address', '360-hotelier' ); ?></strong>
                            <?php esc_html_e( '9, Epaminondou street, 3075, Limassol, Cyprus', '360-hotelier' ); ?>
                        </div>
                    </div>
                </div>

                <?php get_template_part( 'template-parts/page/contact-form' ); ?>

            </div>
        </div>
    </section>

    <section class="front-featured-banner card-border" style="background-image: url('<?php echo esc_url( content_url( '/uploads/2026/03/featured-360-hotelier.webp' ) ); ?>');">
        <div class="front-featured-banner__overlay section-overlay"></div>
        <div class="site-container front-featured-banner__content fade-in fade-in-delay-0">
            <h2 class="front-featured-banner__title"><?php esc_html_e( 'Book a Free Strategy Session', '360-hotelier' ); ?></h2>
            <p class="front-featured-banner__text"><?php esc_html_e( "Tell us about your hotel and we'll walk you through how 360° Hotelier Consulting can support your commercial growth — at no cost or commitment.", '360-hotelier' ); ?></p>
            <p class="front-featured-banner__text"><?php esc_html_e( 'We work with a select number of hotels so every client gets real attention and real results.', '360-hotelier' ); ?></p>
            <div class="front-featured-banner__actions">
                <a href="#page-contact-form" class="btn btn--primary"><?php esc_html_e( 'Book a Free Strategy Session', '360-hotelier' ); ?></a>
            </div>
        </div>
    </section>

</main>

<?php get_footer();
