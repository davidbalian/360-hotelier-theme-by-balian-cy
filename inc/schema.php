<?php
/**
 * JSON-LD Schema Markup
 *
 * Outputs LocalBusiness schema for SEO.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Output LocalBusiness JSON-LD schema in head.
 */
function hotelier_output_schema() {
    $schema = array(
        '@context'    => 'https://schema.org',
        '@type'       => 'LocalBusiness',
        'name'        => '360° Hotelier Consulting',
        'url'         => home_url( '/' ),
        'image'       => has_custom_logo() ? wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' ) : home_url( '/wp-content/uploads/2023/11/360-Hotelier-Logo-1.png' ),
        'priceRange'  => '$$',
        'telephone'   => '+35770001818',
        'address'     => array(
            '@type'           => 'PostalAddress',
            'streetAddress'   => 'Epaminondou 9',
            'addressLocality' => 'Limassol',
            'addressRegion'   => 'Limassol District',
            'postalCode'      => '3075',
            'addressCountry'  => 'CY',
        ),
        'description' => 'Hotel revenue management, digital marketing, online sales and tour operator contracting services for hotels in Cyprus.',
        'areaServed'  => 'Cyprus',
    );

    echo '<script type="application/ld+json">' . wp_json_encode( $schema ) . '</script>' . "\n";
}
add_action( 'wp_head', 'hotelier_output_schema', 5 );
