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
