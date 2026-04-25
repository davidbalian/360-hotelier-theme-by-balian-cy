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
        '360-hotelier-main-08'  => '/assets/css/parts/08-cookie-banner.css',
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

    if ( hotelier_should_enqueue_portfolio_testimonials_assets() ) {
        wp_enqueue_style(
            '360-hotelier-portfolio-testimonials',
            HOTELIER_THEME_URI . '/assets/css/parts/05c-portfolio-testimonials.css',
            array( $last_main_css_handle ),
            HOTELIER_THEME_VERSION
        );
    }

    if ( hotelier_should_enqueue_portfolio_gallery_assets() ) {
        wp_enqueue_style(
            '360-hotelier-portfolio-gallery',
            HOTELIER_THEME_URI . '/assets/css/parts/05d-portfolio-gallery-marquee.css',
            array( $last_main_css_handle ),
            HOTELIER_THEME_VERSION
        );
    }

    // Navigation JS (mobile menu toggle)
    wp_enqueue_script(
        '360-hotelier-navigation',
        HOTELIER_THEME_URI . '/assets/js/navigation.js',
        array( 'wp-i18n' ),
        HOTELIER_THEME_VERSION,
        true
    );
    wp_set_script_translations( '360-hotelier-navigation', '360-hotelier', HOTELIER_THEME_DIR . '/languages' );

    if ( function_exists( 'hotelier_get_current_lang' ) ) {
        wp_localize_script(
            '360-hotelier-navigation',
            'hotelierPathLocale',
            array(
                'lang' => hotelier_get_current_lang(),
            )
        );
    }

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

    if ( hotelier_should_enqueue_portfolio_testimonials_assets() ) {
        $pt_js = HOTELIER_THEME_DIR . '/assets/js/portfolio-testimonials-carousel.js';
        $pt_ver = file_exists( $pt_js ) ? (string) filemtime( $pt_js ) : HOTELIER_THEME_VERSION;

        wp_enqueue_script(
            '360-hotelier-portfolio-testimonials',
            HOTELIER_THEME_URI . '/assets/js/portfolio-testimonials-carousel.js',
            array( '360-hotelier-lucide-icons' ),
            $pt_ver,
            true
        );
    }

    if ( hotelier_should_enqueue_portfolio_gallery_assets() ) {
        $pg_js  = HOTELIER_THEME_DIR . '/assets/js/portfolio-gallery-marquee.js';
        $pg_ver = file_exists( $pg_js ) ? (string) filemtime( $pg_js ) : HOTELIER_THEME_VERSION;

        wp_enqueue_script(
            '360-hotelier-portfolio-gallery',
            HOTELIER_THEME_URI . '/assets/js/portfolio-gallery-marquee.js',
            array(),
            $pg_ver,
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
 * Portfolio template: testimonials carousel CSS/JS.
 */
function hotelier_should_enqueue_portfolio_testimonials_assets() {
    return is_page() && is_page_template( 'page-templates/template-portfolio.php' );
}

/**
 * Portfolio template: image marquee gallery CSS.
 */
function hotelier_should_enqueue_portfolio_gallery_assets() {
    return is_page() && is_page_template( 'page-templates/template-portfolio.php' );
}

/**
 * Preload the hero background image and add a meta description on the front page.
 */
function hotelier_front_page_head() {
    if ( ! is_front_page() ) {
        return;
    }

    $hero_image_url = content_url( '/uploads/2026/03/cyprus-hotel-revenue-consulting.webp' );
    echo '<link rel="preload" as="image" href="' . esc_url( $hero_image_url ) . '" fetchpriority="high">' . "\n";
    echo '<meta name="description" content="' . esc_attr( hotelier_front_page_meta_description() ) . '">' . "\n";
}
add_action( 'wp_head', 'hotelier_front_page_head', 1 );

/**
 * Home page SEO title by current language.
 */
function hotelier_front_page_meta_title() {
    if ( function_exists( 'hotelier_get_current_lang' ) && 'el' === hotelier_get_current_lang() ) {
        return '360° Hotelier Consulting | Έσοδα, Διανομή & Digital Marketing για Ξενοδοχεία στην Κύπρο';
    }

    return '360° Hotelier Consulting | Revenue, Distribution & Digital Strategy for Hotels in Cyprus';
}

/**
 * Home page meta description by current language.
 */
function hotelier_front_page_meta_description() {
    if ( function_exists( 'hotelier_get_current_lang' ) && 'el' === hotelier_get_current_lang() ) {
        return 'Διαχείριση εσόδων, online πωλήσεις, digital marketing & συμβόλαια με tour operators για ξενοδοχεία Κύπρου. Αυξήστε κρατήσεις & κέρδη.';
    }

    return 'Hotel revenue management, online sales, digital marketing and tour-operator contracting for Cyprus hotels. Boost bookings, optimize distribution, increase profit.';
}

/**
 * Overrides the browser title for the homepage.
 *
 * @param array<string, string> $title_parts Title parts from WordPress.
 * @return array<string, string>
 */
function hotelier_front_page_title_parts( $title_parts ) {
    if ( ! is_front_page() ) {
        return $title_parts;
    }

    $title_parts['title'] = hotelier_front_page_meta_title();
    unset( $title_parts['site'], $title_parts['tagline'] );

    return $title_parts;
}
add_filter( 'document_title_parts', 'hotelier_front_page_title_parts', 20 );

/**
 * Founder page meta description by current language.
 */
function hotelier_founder_page_meta_description() {
    if ( function_exists( 'hotelier_get_current_lang' ) && 'el' === hotelier_get_current_lang() ) {
        return 'Γνωρίστε τον Γιώργο Πεγιαζή, ιδρυτή της 360 Hotelier Consulting και σύμβουλο ξενοδοχείων με εξειδίκευση σε revenue management και online πωλήσεις.';
    }

    return 'Meet Giorgos Peyiazis, founder of 360 Hotelier Consulting. Hospitality consultant specialising in hotel revenue management, online sales and digital distribution.';
}

/**
 * Founder page SEO title by current language.
 */
function hotelier_founder_page_meta_title() {
    if ( function_exists( 'hotelier_get_current_lang' ) && 'el' === hotelier_get_current_lang() ) {
        return 'Γιώργος Πεγιαζής | Ιδρυτής 360 Hotelier Consulting';
    }

    return 'Giorgos Peyiazis | Founder of 360 Hotelier Consulting Cyprus';
}

/**
 * Outputs founder page meta tags.
 */
function hotelier_founder_page_head() {
    if ( ! is_page_template( 'page-templates/template-founder.php' ) ) {
        return;
    }

    echo '<meta name="description" content="' . esc_attr( hotelier_founder_page_meta_description() ) . '">' . "\n";
}
add_action( 'wp_head', 'hotelier_founder_page_head', 1 );

/**
 * Overrides the browser title for the founder page.
 *
 * @param array<string, string> $title_parts Title parts from WordPress.
 * @return array<string, string>
 */
function hotelier_founder_page_title_parts( $title_parts ) {
    if ( ! is_page_template( 'page-templates/template-founder.php' ) ) {
        return $title_parts;
    }

    $title_parts['title'] = hotelier_founder_page_meta_title();
    unset( $title_parts['site'], $title_parts['tagline'] );

    return $title_parts;
}
add_filter( 'document_title_parts', 'hotelier_founder_page_title_parts', 21 );
