<?php
/**
 * Template Name: Portfolio
 *
 * @package 360-hotelier
 */

$page_hero_title    = __( 'Our Hotel Partners', '360-hotelier' );
$page_hero_subtitle = __( 'Boutique, independent and resort hotels across Cyprus and beyond — each collaboration built on trust and measurable results.', '360-hotelier' );
$page_hero_image    = content_url( '/uploads/2026/03/why-choose-360-hotelier.webp' );

$hotels = array(
    array( 'name' => 'Cap St. Georges Hotel & Resort', 'location' => 'Paphos, Cyprus', 'url' => 'https://www.capstgeorges.com/' ),
    array( 'name' => 'Serbellas Boutique Hotel', 'location' => 'Paphos, Cyprus', 'url' => 'https://serbellashotel.com/' ),
    array( 'name' => 'TSANotel', 'location' => 'Limassol, Cyprus', 'url' => 'https://www.tsanotel.com/' ),
    array( 'name' => 'Pendeli Resort', 'location' => 'Platres, Cyprus', 'url' => 'https://www.pendeliresort.com/' ),
    array( 'name' => 'Petit Palais Platres Boutique Hotel', 'location' => 'Platres, Cyprus', 'url' => 'https://www.petitpalais.com.cy/' ),
    array( 'name' => 'Napa Jay Hotel', 'location' => 'Ayia Napa, Cyprus', 'url' => 'https://napajayhotel.com/' ),
    array( 'name' => 'Chic Centre Suites Athens', 'location' => 'Athens, Greece', 'url' => 'https://chiccentresuites.com/' ),
);

get_header();
get_template_part( 'template-parts/page/page-hero' );
?>

<main id="main" class="site-main page-portfolio">

    <section class="page-portfolio__section">
        <div class="site-container">

            <div class="page-portfolio__intro fade-in fade-in-delay-0">
                <h2 class="page-section__title"><?php esc_html_e( 'Hotels We Work With', '360-hotelier' ); ?></h2>
                <p><?php esc_html_e( 'At 360° Hotelier Consulting, we collaborate with independent, boutique and resort hotels in Cyprus, providing revenue management, online sales & B2B distribution, digital marketing and tour-operator contracting services.', '360-hotelier' ); ?></p>
                <p><?php esc_html_e( 'Each project is tailored to the hotel\'s market positioning, seasonality and commercial goals — delivering measurable results through data-driven hotel consulting and strategic execution.', '360-hotelier' ); ?></p>
            </div>

            <div class="page-portfolio__grid">
                <?php foreach ( $hotels as $index => $hotel ) : ?>
                    <div class="page-portfolio__hotel-card card-border fade-in fade-in-delay-<?php echo min( $index + 1, 10 ); ?>">
                        <h3 class="page-portfolio__hotel-name"><?php echo esc_html( $hotel['name'] ); ?></h3>
                        <span class="page-portfolio__hotel-location">
                            <?php Hotelier_Lucide_Icon::render( 'map-pin', 'page-portfolio__location-icon' ); ?>
                            <?php echo esc_html( $hotel['location'] ); ?>
                        </span>
                        <a href="<?php echo esc_url( $hotel['url'] ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn--outline btn--sm page-portfolio__hotel-link"><?php esc_html_e( 'Visit Website →', '360-hotelier' ); ?></a>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <!-- CTA Banner -->
    <section class="front-featured-banner card-border" style="background-image: url('<?php echo esc_url( content_url( '/uploads/2026/03/featured-360-hotelier.webp' ) ); ?>');">
        <div class="front-featured-banner__overlay section-overlay"></div>
        <div class="site-container front-featured-banner__content fade-in fade-in-delay-0">
            <h2 class="front-featured-banner__title"><?php esc_html_e( 'Ready to Join Our Portfolio?', '360-hotelier' ); ?></h2>
            <p class="front-featured-banner__text"><?php esc_html_e( "We work with a select number of hotels so every client gets real attention and real results. Let's talk.", '360-hotelier' ); ?></p>
            <div class="front-featured-banner__actions">
                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'Book a Free Consultation', '360-hotelier' ); ?></a>
            </div>
        </div>
    </section>

</main>

<?php get_footer();
