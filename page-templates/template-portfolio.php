<?php
/**
 * Template Name: Portfolio
 *
 * @package 360-hotelier
 */

get_header();

$hotels = array(
    array( 'name' => 'Cap St. Georges Hotel & Resort', 'location' => 'Paphos, Cyprus', 'url' => 'https://www.capstgeorges.com/' ),
    array( 'name' => 'Serbellas Boutique Hotel', 'location' => 'Paphos, Cyprus', 'url' => 'https://serbellashotel.com/' ),
    array( 'name' => 'TSANotel', 'location' => 'Limassol, Cyprus', 'url' => 'https://www.tsanotel.com/' ),
    array( 'name' => 'Pendeli Resort', 'location' => 'Platres, Cyprus', 'url' => 'https://www.pendeliresort.com/' ),
    array( 'name' => 'Petit Palais Platres Boutique Hotel', 'location' => 'Platres, Cyprus', 'url' => 'https://www.petitpalais.com.cy/' ),
    array( 'name' => 'Napa Jay Hotel', 'location' => 'Ayia Napa, Cyprus', 'url' => 'https://napajayhotel.com/' ),
    array( 'name' => 'Chic Centre Suites Athens', 'location' => 'Athens, Greece', 'url' => 'https://chiccentresuites.com/' ),
);
?>

<main id="main" class="site-main">
    <div class="site-container page-portfolio">

        <h1 class="page-portfolio__title"><?php esc_html_e( 'Our Portfolio', '360-hotelier' ); ?></h1>

        <p><?php esc_html_e( 'At 360° Hotelier Consulting, we collaborate with independent, boutique and resort hotels in Cyprus, providing revenue management, online sales & B2B distribution, digital marketing and tour-operator contracting services.', '360-hotelier' ); ?></p>

        <p><?php esc_html_e( 'Our portfolio reflects hands-on partnerships where we have helped hotels increase revenue, optimise channel performance, grow direct bookings and secure stronger commercial agreements.', '360-hotelier' ); ?></p>

        <p><?php esc_html_e( "Each project is tailored to the hotel's market positioning, seasonality and commercial goals - delivering measurable results through data-driven hotel consulting and strategic execution.", '360-hotelier' ); ?></p>

        <h2><?php esc_html_e( 'Our Hotel Partners', '360-hotelier' ); ?></h2>
        <ul class="page-portfolio__list">
            <?php foreach ( $hotels as $hotel ) : ?>
                <li class="page-portfolio__item">
                    <a href="<?php echo esc_url( $hotel['url'] ); ?>" target="_blank" rel="noopener noreferrer">
                        <strong><?php echo esc_html( $hotel['name'] ); ?></strong> (<?php echo esc_html( $hotel['location'] ); ?>)
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>

    </div>
</main>

<?php get_footer();
