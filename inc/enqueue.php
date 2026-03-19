<?php
/**
 * Asset Enqueue Functions
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Enqueue front-end styles and scripts.
 */
function hotelier_enqueue_assets() {
    // Main theme stylesheet (style.css)
    wp_enqueue_style(
        '360-hotelier-style',
        get_stylesheet_uri(),
        array(),
        HOTELIER_THEME_VERSION
    );

    // Main CSS (navigation, components, layout)
    wp_enqueue_style(
        '360-hotelier-main',
        HOTELIER_THEME_URI . '/assets/css/main.css',
        array( '360-hotelier-style' ),
        HOTELIER_THEME_VERSION
    );

    // Navigation JS (mobile menu toggle)
    wp_enqueue_script(
        '360-hotelier-navigation',
        HOTELIER_THEME_URI . '/assets/js/navigation.js',
        array(),
        HOTELIER_THEME_VERSION,
        true
    );
}
add_action( 'wp_enqueue_scripts', 'hotelier_enqueue_assets' );

/**
 * Preload the hero background image and add a meta description on the front page.
 */
function hotelier_front_page_head() {
    if ( ! is_front_page() ) {
        return;
    }

    $hero_image_url = content_url( '/uploads/2026/03/360-hotelier-consulting-cyprus-hero.webp' );
    echo '<link rel="preload" as="image" href="' . esc_url( $hero_image_url ) . '" fetchpriority="high">' . "\n";
    echo '<meta name="description" content="' . esc_attr__( 'Revenue management, B2B distribution and digital growth for hotels in Cyprus. 360° Hotelier Consulting — your external commercial team, built around measurable results.', '360-hotelier' ) . '">' . "\n";
}
add_action( 'wp_head', 'hotelier_front_page_head', 1 );
