<?php
/**
 * 360 Hotelier Theme Functions
 *
 * @package 360-hotelier
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define theme constants
define( 'HOTELIER_THEME_VERSION', '1.0.0' );
define( 'HOTELIER_THEME_DIR', get_template_directory() );
define( 'HOTELIER_THEME_URI', get_template_directory_uri() );

// Include theme setup functions
require_once HOTELIER_THEME_DIR . '/inc/theme-setup.php';

// Include menu fallback
require_once HOTELIER_THEME_DIR . '/inc/menu-fallback.php';

// Include schema markup
require_once HOTELIER_THEME_DIR . '/inc/schema.php';

// Include service content
require_once HOTELIER_THEME_DIR . '/inc/service-content.php';

// Include enqueue functions
require_once HOTELIER_THEME_DIR . '/inc/enqueue.php';

// TEMPORARY: Redirect all non-admin, non-homepage requests to the homepage.
add_action( 'template_redirect', function() {
    if ( is_front_page() || is_admin() ) {
        return;
    }
    wp_redirect( home_url( '/' ), 302 );
    exit;
} );

// TEMPORARY: Point all WordPress nav menu links to #.
add_filter( 'nav_menu_link_attributes', function( $atts ) {
    $atts['href'] = '#';
    return $atts;
}, 10, 4 );