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
define( 'HOTELIER_THEME_VERSION', '2.0.0' );
define( 'HOTELIER_THEME_DIR', get_template_directory() );
define( 'HOTELIER_THEME_URI', get_template_directory_uri() );

// Include theme setup functions
require_once HOTELIER_THEME_DIR . '/inc/theme-setup.php';

// Include service content (before menu fallback — submenu labels)
require_once HOTELIER_THEME_DIR . '/inc/class-hotelier-service-single-defaults.php';
require_once HOTELIER_THEME_DIR . '/inc/service-content.php';

// Include menu fallback
require_once HOTELIER_THEME_DIR . '/inc/menu-fallback.php';

// Cookie consent banner (assets + constants)
require_once HOTELIER_THEME_DIR . '/inc/class-hotelier-cookie-consent.php';

// Path-prefix locale (en default, Greek /el/)
require_once HOTELIER_THEME_DIR . '/inc/i18n/hotelier-i18n-bootstrap.php';

// Primary nav walker (Services submenu footer link)
require_once HOTELIER_THEME_DIR . '/inc/class-hotelier-primary-nav-walker.php';

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

Hotelier_Cookie_Consent::register();

// Hardcoded page content + site-wide content options
require_once HOTELIER_THEME_DIR . '/inc/page-meta/hotelier-page-meta.php';
require_once HOTELIER_THEME_DIR . '/inc/class-hotelier-front-service-card-image.php';
require_once HOTELIER_THEME_DIR . '/inc/seo/hotelier-seo-bootstrap.php';
Hotelier_Seo_Bootstrap::register();
require_once HOTELIER_THEME_DIR . '/inc/class-hotelier-site-content-options.php';
require_once HOTELIER_THEME_DIR . '/inc/class-hotelier-founder-card-contact.php';

require_once HOTELIER_THEME_DIR . '/inc/seo/structured-data/class-hotelier-structured-data-bootstrap.php';
Hotelier_Structured_Data_Bootstrap::register();

// Portfolio gallery picker (admin meta box + postmeta-backed image list)
require_once HOTELIER_THEME_DIR . '/inc/admin/portfolio-gallery/hotelier-portfolio-gallery-bootstrap.php';

