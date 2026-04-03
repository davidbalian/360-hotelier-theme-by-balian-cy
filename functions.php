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

// Language detection and locale switching — must load before theme setup.
require_once HOTELIER_THEME_DIR . '/inc/language.php';

// Include theme setup functions
require_once HOTELIER_THEME_DIR . '/inc/theme-setup.php';

// Include service content (before menu fallback — submenu labels)
require_once HOTELIER_THEME_DIR . '/inc/service-content.php';

// Include menu fallback
require_once HOTELIER_THEME_DIR . '/inc/menu-fallback.php';

// Primary nav walker (Services submenu footer link)
require_once HOTELIER_THEME_DIR . '/inc/class-hotelier-primary-nav-walker.php';

// Include schema markup
require_once HOTELIER_THEME_DIR . '/inc/schema.php';

// Lucide icon placeholders
require_once HOTELIER_THEME_DIR . '/inc/class-hotelier-lucide-icon.php';

// FAQ content (reusable sections)
require_once HOTELIER_THEME_DIR . '/inc/class-hotelier-faq-content.php';

// Contact form (admin-post handler self-registers on load)
require_once HOTELIER_THEME_DIR . '/inc/class-hotelier-contact-form-handler.php';

// CTA band cover images (object-fit)
require_once HOTELIER_THEME_DIR . '/inc/class-hotelier-cta-band-image.php';

// Include enqueue functions
require_once HOTELIER_THEME_DIR . '/inc/enqueue.php';

// Editable page content (post meta) + site-wide content options
require_once HOTELIER_THEME_DIR . '/inc/page-meta/hotelier-page-meta.php';
require_once HOTELIER_THEME_DIR . '/inc/class-hotelier-site-content-options.php';
require_once HOTELIER_THEME_DIR . '/inc/class-hotelier-defaults-snapshot-builder.php';
require_once HOTELIER_THEME_DIR . '/inc/class-hotelier-defaults-export-admin.php';

