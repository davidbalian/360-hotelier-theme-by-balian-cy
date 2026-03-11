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

// Include enqueue functions
require_once HOTELIER_THEME_DIR . '/inc/enqueue.php';