<?php
/**
 * Template Name: Portfolio
 *
 * @package 360-hotelier
 */

$page_hero_title    = __( 'Our Hotel Partners', '360-hotelier' );
$page_hero_subtitle = __( 'Boutique, independent and resort hotels across Cyprus and beyond, each delivering measurable results.', '360-hotelier' );
$page_hero_image    = content_url( '/uploads/2026/03/why-choose-360-hotelier.webp' );

$pendeli_svg_path = WP_CONTENT_DIR . '/uploads/2026/03/pendeli-resort-hotel-cyprus-logo-white.svg';
$pendeli_svg      = file_exists( $pendeli_svg_path ) ? file_get_contents( $pendeli_svg_path ) : '';

$hotels = array(
    array(
        'name'     => 'Cap St. Georges Hotel & Resort',
        'location' => 'Paphos, Cyprus',
        'url'      => 'https://www.capstgeorges.com/',
        'logo'     => array(
            'type' => 'img',
            'src'  => content_url( '/uploads/2026/03/cap-st-georges-resort-logo-hd.webp' ),
            'alt'  => __( 'Cap St Georges Hotel & Resort Cyprus', '360-hotelier' ),
        ),
    ),
    array(
        'name'     => 'Serbellas Boutique Hotel',
        'location' => 'Paphos, Cyprus',
        'url'      => 'https://serbellashotel.com/',
        'logo'     => array(
            'type'    => 'img',
            'src'     => content_url( '/uploads/2026/03/serbellas-boutique-hotel-logo-transparent.webp' ),
            'alt'     => __( 'Serbellas Boutique Hotel', '360-hotelier' ),
            'variant' => 'serbellas',
        ),
    ),
    array(
        'name'     => 'TSANotel',
        'location' => 'Limassol, Cyprus',
        'url'      => 'https://www.tsanotel.com/',
        'logo'     => array(
            'type' => 'img',
            'src'  => content_url( '/uploads/2026/03/tsanotel-hd-logo.webp' ),
            'alt'  => __( 'Tsanotel Cyprus', '360-hotelier' ),
        ),
    ),
    array(
        'name'     => 'Pendeli Resort',
        'location' => 'Platres, Cyprus',
        'url'      => 'https://www.pendeliresort.com/',
        'logo'     => array(
            'type' => 'pendeli',
        ),
    ),
    array(
        'name'     => 'Petit Palais Platres Boutique Hotel',
        'location' => 'Platres, Cyprus',
        'url'      => 'https://www.petitpalais.com.cy/',
        'logo'     => array(
            'type' => 'img',
            'src'  => content_url( '/uploads/2026/03/petit-palais-platres-hotel-logo-color-cyprus.webp' ),
            'alt'  => __( 'Petit Palais Hotel Platres Cyprus', '360-hotelier' ),
        ),
    ),
    array(
        'name'     => 'Napa Jay Hotel',
        'location' => 'Ayia Napa, Cyprus',
        'url'      => 'https://napajayhotel.com/',
        'logo'     => array(
            'type' => 'img',
            'src'  => content_url( '/uploads/2026/03/napa-jay-hotel-logo-cropped.png' ),
            'alt'  => __( 'Napa Jay Hotel Ayia Napa Cyprus', '360-hotelier' ),
        ),
    ),
    array(
        'name'     => 'Chic Centre Suites Athens',
        'location' => 'Athens, Greece',
        'url'      => 'https://chiccentresuites.com/',
        'logo'     => array(
            'type' => 'img',
            'src'  => content_url( '/uploads/2026/03/chic-centre-suites-athens-hotel-logo.webp' ),
            'alt'  => __( 'Chic Centre Suites Athens', '360-hotelier' ),
        ),
    ),
);

get_header();
get_template_part( 'template-parts/page/page-hero' );
?>

<main id="main" class="site-main page-portfolio">

    <section class="page-section page-section--white">
        <div class="site-container">
            <div class="page-about__intro-grid">
                <div class="page-about__intro-text fade-in fade-in-delay-0">
                    <h2 class="page-section__title"><?php esc_html_e( 'Hotels We Work With', '360-hotelier' ); ?></h2>
                    <p><?php esc_html_e( 'We work with independent, boutique and resort hotels in Cyprus across revenue management, online sales & B2B distribution, digital marketing and tour-operator contracting.', '360-hotelier' ); ?></p>
                    <p><?php esc_html_e( 'Each engagement is built around the hotel\'s market, seasonality and commercial goals.', '360-hotelier' ); ?></p>
                </div>
                <div class="page-about__intro-image fade-in fade-in-delay-1" style="background-image: url('<?php echo esc_url( content_url( '/uploads/2026/03/why-choose-360-hotelier.webp' ) ); ?>');" aria-hidden="true"></div>
            </div>
        </div>
    </section>

    <section class="page-section page-section--gray">
        <div class="site-container">
            <div class="page-section__heading page-section__heading--center fade-in fade-in-delay-0">
                <h2 class="page-section__title"><?php esc_html_e( 'Partner hotels', '360-hotelier' ); ?></h2>
                <p class="page-section__subtitle"><?php esc_html_e( 'Independent, boutique and resort properties we support with revenue, distribution and digital strategy.', '360-hotelier' ); ?></p>
            </div>
            <div class="page-portfolio__rows">
                <?php foreach ( $hotels as $index => $hotel ) : ?>
                    <?php
                    $logo      = $hotel['logo'];
                    $logo_mods = array( 'page-portfolio__hotel-logo' );
                    if ( ! empty( $logo['variant'] ) ) {
                        $logo_mods[] = 'page-portfolio__hotel-logo--' . $logo['variant'];
                    }
                    if ( 'pendeli' === $logo['type'] ) {
                        $logo_mods[] = 'page-portfolio__hotel-logo--pendeli';
                    }
                    $logo_class = implode( ' ', $logo_mods );
                    $row_class  = 'page-portfolio__row fade-in fade-in-delay-' . min( $index + 1, 10 );
                    if ( 1 === ( $index % 2 ) ) {
                        $row_class .= ' page-portfolio__row--flip';
                    }
                    ?>
                    <div class="<?php echo esc_attr( $row_class ); ?>">
                        <div class="page-portfolio__hotel-card card-border">
                            <?php if ( 'pendeli' === $logo['type'] && $pendeli_svg ) : ?>
                                <div class="<?php echo esc_attr( $logo_class ); ?>" role="img" aria-label="<?php echo esc_attr( __( 'Pendeli Resort Hotel Cyprus', '360-hotelier' ) ); ?>">
                                    <?php echo $pendeli_svg; ?>
                                </div>
                            <?php elseif ( 'img' === $logo['type'] ) : ?>
                                <div class="<?php echo esc_attr( $logo_class ); ?>">
                                    <img src="<?php echo esc_url( $logo['src'] ); ?>" alt="<?php echo esc_attr( $logo['alt'] ); ?>" loading="lazy" />
                                </div>
                            <?php endif; ?>
                            <h3 class="page-portfolio__hotel-name"><?php echo esc_html( $hotel['name'] ); ?></h3>
                            <span class="page-portfolio__hotel-location">
                                <?php Hotelier_Lucide_Icon::render( 'map-pin', 'page-portfolio__location-icon' ); ?>
                                <?php echo esc_html( $hotel['location'] ); ?>
                            </span>
                            <a href="<?php echo esc_url( $hotel['url'] ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn--outline btn--sm page-portfolio__hotel-link"><?php esc_html_e( 'Visit Website', '360-hotelier' ); ?></a>
                        </div>
                        <div class="page-portfolio__row-media" aria-hidden="true"></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="front-featured-banner card-border">
        <?php Hotelier_Cta_Band_Image::render( content_url( '/uploads/2026/03/featured-360-hotelier.webp' ) ); ?>
        <div class="front-featured-banner__overlay section-overlay"></div>
        <div class="site-container front-featured-banner__content fade-in fade-in-delay-0">
            <h2 class="front-featured-banner__title"><?php esc_html_e( 'Add Your Hotel to Our Portfolio.', '360-hotelier' ); ?></h2>
            <p class="front-featured-banner__text"><?php esc_html_e( "We keep our client list small. Every hotel gets direct access to Giorgos and full commercial support.", '360-hotelier' ); ?></p>
            <div class="front-featured-banner__actions">
                <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( 'contact' ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'Book a Free Consultation', '360-hotelier' ); ?></a>
            </div>
        </div>
    </section>

</main>

<?php get_footer();
