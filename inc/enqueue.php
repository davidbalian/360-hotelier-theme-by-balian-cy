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

    // Main CSS — split partials (load order = cascade order)
    $main_css_deps = array( '360-hotelier-style' );
    $main_css_parts  = array(
        '360-hotelier-main-01'  => '/assets/css/parts/01-global-header.css',
        '360-hotelier-main-01b' => '/assets/css/parts/01b-primary-nav-submenu.css',
        '360-hotelier-main-02'  => '/assets/css/parts/02-footer-content-buttons.css',
        '360-hotelier-main-03' => '/assets/css/parts/03-front-page-hero-through-banner.css',
        '360-hotelier-main-04' => '/assets/css/parts/04-front-page-founder-through-contact.css',
        '360-hotelier-main-05'  => '/assets/css/parts/05-inner-pages.css',
        '360-hotelier-main-05b' => '/assets/css/parts/05b-contact-page.css',
        '360-hotelier-main-06'  => '/assets/css/parts/06-style-guide-responsive-fade.css',
    );
    $last_main_css_handle = '360-hotelier-style';
    foreach ( $main_css_parts as $handle => $relative_path ) {
        wp_enqueue_style(
            $handle,
            HOTELIER_THEME_URI . $relative_path,
            $main_css_deps,
            HOTELIER_THEME_VERSION
        );
        $main_css_deps        = array( $handle );
        $last_main_css_handle = $handle;
    }

    if ( hotelier_should_enqueue_faq_assets() ) {
        wp_enqueue_style(
            '360-hotelier-faq-accordions',
            HOTELIER_THEME_URI . '/assets/css/parts/07-faq-accordions.css',
            array( $last_main_css_handle ),
            HOTELIER_THEME_VERSION
        );
    }

    // Navigation JS (mobile menu toggle)
    wp_enqueue_script(
        '360-hotelier-navigation',
        HOTELIER_THEME_URI . '/assets/js/navigation.js',
        array(),
        HOTELIER_THEME_VERSION,
        true
    );

    $lucide_bundle = HOTELIER_THEME_DIR . '/assets/js/lucide-icons.bundle.js';
    $lucide_ver    = file_exists( $lucide_bundle ) ? (string) filemtime( $lucide_bundle ) : HOTELIER_THEME_VERSION;

    wp_enqueue_script(
        '360-hotelier-lucide-icons',
        HOTELIER_THEME_URI . '/assets/js/lucide-icons.bundle.js',
        array(),
        $lucide_ver,
        true
    );

    if ( hotelier_should_enqueue_faq_assets() ) {
        $faq_bundle = HOTELIER_THEME_DIR . '/assets/js/faq-accordions.bundle.js';
        $faq_ver    = file_exists( $faq_bundle ) ? (string) filemtime( $faq_bundle ) : HOTELIER_THEME_VERSION;

        wp_enqueue_script(
            '360-hotelier-faq-accordions',
            HOTELIER_THEME_URI . '/assets/js/faq-accordions.bundle.js',
            array( '360-hotelier-lucide-icons' ),
            $faq_ver,
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'hotelier_enqueue_assets' );

/**
 * Load FAQ section scripts only where the FAQ block is rendered.
 */
function hotelier_should_enqueue_faq_assets() {
    if ( is_front_page() ) {
        return true;
    }

    if ( ! is_page() ) {
        return false;
    }

    return is_page_template( 'page-templates/template-contact.php' )
        || is_page_template( 'page-templates/template-services.php' );
}

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
