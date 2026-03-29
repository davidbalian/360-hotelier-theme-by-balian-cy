<?php
/**
 * Front page results / trust indicators section.
 *
 * @package 360-hotelier
 */

// Load Pendeli SVG inline so CSS can target its paths directly.
$pendeli_svg_path = WP_CONTENT_DIR . '/uploads/2026/03/pendeli-resort-hotel-cyprus-logo-white.svg';
$pendeli_svg      = file_exists( $pendeli_svg_path ) ? file_get_contents( $pendeli_svg_path ) : '';
?>
<section class="front-results card-border">
    <div class="site-container">
        <h2 class="front-section__title fade-in fade-in-delay-0"><?php esc_html_e( 'Proven Impact for Hotels in Cyprus & Greece', '360-hotelier' ); ?></h2>
        <ul class="front-results__list">
            <li class="fade-in fade-in-delay-1">
                <span class="front-results__stat"><?php esc_html_e( '+20%', '360-hotelier' ); ?></span>
                <span class="front-results__label"><?php esc_html_e( 'increase in online bookings', '360-hotelier' ); ?></span>
            </li>
            <li class="fade-in fade-in-delay-2">
                <span class="front-results__stat"><?php esc_html_e( '+15%', '360-hotelier' ); ?></span>
                <span class="front-results__label"><?php esc_html_e( 'RevPAR improvement', '360-hotelier' ); ?></span>
            </li>
            <li class="fade-in fade-in-delay-3">
                <span class="front-results__stat"><?php esc_html_e( 'B2B', '360-hotelier' ); ?></span>
                <span class="front-results__label"><?php esc_html_e( 'Stronger portfolios and better contracting terms', '360-hotelier' ); ?></span>
            </li>
            <li class="fade-in fade-in-delay-4">
                <span class="front-results__stat"><?php esc_html_e( '360°', '360-hotelier' ); ?></span>
                <span class="front-results__label"><?php esc_html_e( 'Growth through smarter digital strategy', '360-hotelier' ); ?></span>
            </li>
        </ul>
        <p class="front-results__trust fade-in fade-in-delay-5"><?php esc_html_e( 'Trusted by hotels across Cyprus & Greece.', '360-hotelier' ); ?></p>
        <div class="front-results__ticker fade-in fade-in-delay-6">
            <div class="front-results__ticker-track">
                <span class="ticker-logo ticker-logo--pendeli" role="img" aria-label="<?php esc_attr_e( 'Pendeli Resort Hotel Cyprus', '360-hotelier' ); ?>"><?php echo $pendeli_svg; ?></span>
                <img src="<?php echo esc_url( content_url( '/uploads/2026/03/cap-st-georges-resort-logo-hd.webp' ) ); ?>" alt="<?php esc_attr_e( 'Cap St Georges Hotel & Resort Cyprus', '360-hotelier' ); ?>" loading="lazy" />
                <img src="<?php echo esc_url( content_url( '/uploads/2026/03/tsanotel-hd-logo.webp' ) ); ?>" alt="<?php esc_attr_e( 'Tsanotel Cyprus', '360-hotelier' ); ?>" loading="lazy" />
                <img class="ticker-logo ticker-logo--serbellas" src="<?php echo esc_url( content_url( '/uploads/2026/03/serbellas-boutique-hotel-logo-transparent.webp' ) ); ?>" alt="<?php esc_attr_e( 'Serbellas Boutique Hotel', '360-hotelier' ); ?>" loading="lazy" />
                <img src="<?php echo esc_url( content_url( '/uploads/2026/03/petit-palais-platres-hotel-logo-color-cyprus.webp' ) ); ?>" alt="<?php esc_attr_e( 'Petit Palais Hotel Platres Cyprus', '360-hotelier' ); ?>" loading="lazy" />
                <img src="<?php echo esc_url( content_url( '/uploads/2026/03/chic-centre-suites-athens-hotel-logo.webp' ) ); ?>" alt="<?php esc_attr_e( 'Chic Centre Suites Athens', '360-hotelier' ); ?>" loading="lazy" />
                <img src="<?php echo esc_url( content_url( '/uploads/2026/03/napa-jay-hotel-logo-cropped.png' ) ); ?>" alt="<?php esc_attr_e( 'Napa Jay Hotel Ayia Napa Cyprus', '360-hotelier' ); ?>" loading="lazy" />
                <!-- Duplicate set for seamless loop -->
                <span class="ticker-logo ticker-logo--pendeli" aria-hidden="true"><?php echo $pendeli_svg; ?></span>
                <img src="<?php echo esc_url( content_url( '/uploads/2026/03/cap-st-georges-resort-logo-hd.webp' ) ); ?>" alt="" loading="lazy" aria-hidden="true" />
                <img src="<?php echo esc_url( content_url( '/uploads/2026/03/tsanotel-hd-logo.webp' ) ); ?>" alt="" loading="lazy" aria-hidden="true" />
                <img class="ticker-logo ticker-logo--serbellas" src="<?php echo esc_url( content_url( '/uploads/2026/03/serbellas-boutique-hotel-logo-transparent.webp' ) ); ?>" alt="" loading="lazy" aria-hidden="true" />
                <img src="<?php echo esc_url( content_url( '/uploads/2026/03/petit-palais-platres-hotel-logo-color-cyprus.webp' ) ); ?>" alt="" loading="lazy" aria-hidden="true" />
                <img src="<?php echo esc_url( content_url( '/uploads/2026/03/chic-centre-suites-athens-hotel-logo.webp' ) ); ?>" alt="" loading="lazy" aria-hidden="true" />
                <img src="<?php echo esc_url( content_url( '/uploads/2026/03/napa-jay-hotel-logo-cropped.png' ) ); ?>" alt="" loading="lazy" aria-hidden="true" />
            </div>
        </div>
    </div>
</section>
