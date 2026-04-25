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

/**
 * SEO map for services overview and service single pages.
 *
 * @return array<string, array<string, array<string, string>>>
 */
function hotelier_services_seo_map() {
    return array(
        'services' => array(
            'en' => array(
                'title'       => 'Hotel Consulting Services | Revenue Management & Hotel Sales Strategy',
                'description' => 'Discover hotel consulting services including revenue management, OTA optimisation, digital marketing and tour operator contracting to increase hotel revenue and direct bookings.',
            ),
            'el' => array(
                'title'       => 'Υπηρεσίες Hotel Consulting | Revenue Management & Online Sales Strategy',
                'description' => 'Ανακαλύψτε τις υπηρεσίες hotel consulting της 360 Hotelier: revenue management, online sales, OTA optimization, digital marketing και contracting με tour operators.',
            ),
        ),
        'revenue-management' => array(
            'en' => array(
                'title'       => 'Hotel Revenue Management Services | Pricing Strategy & RevPAR Growth',
                'description' => 'Professional revenue management for hotels: dynamic pricing, forecasting, competitor benchmarking and channel optimisation to increase RevPAR and overall profitability.',
            ),
            'el' => array(
                'title'       => 'Revenue Management για Ξενοδοχεία | Pricing Strategy & RevPAR Growth',
                'description' => 'Επαγγελματικές υπηρεσίες revenue management για ξενοδοχεία. Dynamic pricing, forecasting, competitor benchmarking και στρατηγική αύξησης RevPAR και πληρότητας.',
            ),
        ),
        'online-sales-distribution' => array(
            'en' => array(
                'title'       => 'Hotel Online Sales & Distribution Strategy | OTA & B2B Partnerships',
                'description' => 'Improve your hotel distribution strategy with OTA optimisation, wholesaler contracts and B2B partnerships that increase visibility and reduce OTA dependency.',
            ),
            'el' => array(
                'title'       => 'Digital Marketing για Ξενοδοχεία | SEO, Direct Bookings & Online Growth',
                'description' => 'Αυξήστε τις απευθείας κρατήσεις του ξενοδοχείου σας με στρατηγικές SEO, Google Ads, social media marketing και βελτιστοποίηση booking engine.',
            ),
        ),
        'digital-marketing' => array(
            'en' => array(
                'title'       => 'Hotel Digital Marketing Services | SEO, Direct Bookings & Growth',
                'description' => 'Increase direct hotel bookings with SEO, Google Ads, social media strategy and booking engine optimisation designed to boost your hotel’s online performance.',
            ),
            'el' => array(
                'title'       => 'Digital Marketing για Ξενοδοχεία | SEO, Direct Bookings & Online Growth',
                'description' => 'Αυξήστε τις απευθείας κρατήσεις του ξενοδοχείου σας με στρατηγικές SEO, Google Ads, social media marketing και βελτιστοποίηση booking engine.',
            ),
        ),
        'tour-operator-contracting' => array(
            'en' => array(
                'title'       => 'Tour Operator Contracting for Hotels | Negotiation & Distribution',
                'description' => 'Expert negotiation and contracting with tour operators and travel partners to secure competitive rates, optimise allotments and grow hotel revenue.',
            ),
            'el' => array(
                'title'       => 'Tour Operator Contracting για Ξενοδοχεία | Συμβόλαια & Διαπραγματεύσεις',
                'description' => 'Διαπραγμάτευση συμβολαίων με tour operators και ταξιδιωτικούς οργανισμούς. Βελτιστοποίηση allotments, τιμών και συνεργασιών για αύξηση εσόδων ξενοδοχείων.',
            ),
        ),
    );
}

/**
 * Returns current page services SEO metadata when applicable.
 *
 * @return array{title: string, description: string}|null
 */
function hotelier_current_services_seo_meta() {
    $slug = '';

    if ( is_page_template( 'page-templates/template-services.php' ) ) {
        $slug = 'services';
    } elseif ( is_page_template( 'page-templates/template-service-single.php' ) ) {
        $post = get_post();
        if ( $post instanceof WP_Post ) {
            $slug = (string) $post->post_name;
        }
    }

    if ( '' === $slug ) {
        return null;
    }

    $map = hotelier_services_seo_map();
    if ( ! isset( $map[ $slug ] ) ) {
        return null;
    }

    $lang = function_exists( 'hotelier_get_current_lang' ) ? hotelier_get_current_lang() : 'en';
    if ( 'el' !== $lang ) {
        $lang = 'en';
    }

    if ( ! isset( $map[ $slug ][ $lang ]['title'], $map[ $slug ][ $lang ]['description'] ) ) {
        return null;
    }

    return array(
        'title'       => $map[ $slug ][ $lang ]['title'],
        'description' => $map[ $slug ][ $lang ]['description'],
    );
}

/**
 * Outputs services page meta description for mapped pages.
 */
function hotelier_services_page_head() {
    $meta = hotelier_current_services_seo_meta();
    if ( ! is_array( $meta ) ) {
        return;
    }

    echo '<meta name="description" content="' . esc_attr( $meta['description'] ) . '">' . "\n";
}
add_action( 'wp_head', 'hotelier_services_page_head', 1 );

/**
 * Overrides title parts for mapped services pages.
 *
 * @param array<string, string> $title_parts Title parts from WordPress.
 * @return array<string, string>
 */
function hotelier_services_page_title_parts( $title_parts ) {
    $meta = hotelier_current_services_seo_meta();
    if ( ! is_array( $meta ) ) {
        return $title_parts;
    }

    $title_parts['title'] = $meta['title'];
    unset( $title_parts['site'], $title_parts['tagline'] );

    return $title_parts;
}
add_filter( 'document_title_parts', 'hotelier_services_page_title_parts', 22 );

/**
 * Portfolio page meta description by current language.
 */
function hotelier_portfolio_page_meta_description() {
    if ( function_exists( 'hotelier_get_current_lang' ) && 'el' === hotelier_get_current_lang() ) {
        return 'Δείτε το portfolio της 360 Hotelier Consulting και πώς βοηθάμε ξενοδοχεία στην Κύπρο να αυξήσουν έσοδα, απευθείας κρατήσεις και απόδοση καναλιών πώλησης.';
    }

    return 'Explore the portfolio of 360 Hotelier Consulting and discover how we help hotels in Cyprus improve revenue, optimize distribution and increase direct bookings.';
}

/**
 * Portfolio page SEO title by current language.
 */
function hotelier_portfolio_page_meta_title() {
    if ( function_exists( 'hotelier_get_current_lang' ) && 'el' === hotelier_get_current_lang() ) {
        return 'Portfolio Ξενοδοχειακών Συνεργασιών | 360 Hotelier Consulting Cyprus';
    }

    return 'Hotel Consulting Portfolio | 360 Hotelier Consulting Cyprus';
}

/**
 * About page meta description by current language.
 */
function hotelier_about_page_meta_description() {
    if ( function_exists( 'hotelier_get_current_lang' ) && 'el' === hotelier_get_current_lang() ) {
        return 'Η 360 Hotelier Consulting είναι εταιρεία συμβουλευτικών υπηρεσιών ξενοδοχείων στην Κύπρο με εξειδίκευση σε revenue management, online πωλήσεις και στρατηγική διανομής.';
    }

    return '360° Hotelier Consulting is a leading hotel consultant in Cyprus, specializing in revenue management, online sales, digital marketing and tour-operator contracting.';
}

/**
 * About page SEO title by current language.
 */
function hotelier_about_page_meta_title() {
    if ( function_exists( 'hotelier_get_current_lang' ) && 'el' === hotelier_get_current_lang() ) {
        return 'Συμβουλευτικές Υπηρεσίες Ξενοδοχείων στην Κύπρο | 360 Hotelier Consulting';
    }

    return 'Hotel Consultant Cyprus | 360 Hotelier Consulting';
}

/**
 * Outputs meta descriptions for about and portfolio page templates.
 */
function hotelier_about_portfolio_page_head() {
    if ( is_page_template( 'page-templates/template-portfolio.php' ) ) {
        echo '<meta name="description" content="' . esc_attr( hotelier_portfolio_page_meta_description() ) . '">' . "\n";
        return;
    }

    if ( is_page_template( 'page-templates/template-about.php' ) ) {
        echo '<meta name="description" content="' . esc_attr( hotelier_about_page_meta_description() ) . '">' . "\n";
    }
}
add_action( 'wp_head', 'hotelier_about_portfolio_page_head', 1 );

/**
 * Overrides browser title for about and portfolio page templates.
 *
 * @param array<string, string> $title_parts Title parts from WordPress.
 * @return array<string, string>
 */
function hotelier_about_portfolio_page_title_parts( $title_parts ) {
    if ( is_page_template( 'page-templates/template-portfolio.php' ) ) {
        $title_parts['title'] = hotelier_portfolio_page_meta_title();
        unset( $title_parts['site'], $title_parts['tagline'] );
        return $title_parts;
    }

    if ( is_page_template( 'page-templates/template-about.php' ) ) {
        $title_parts['title'] = hotelier_about_page_meta_title();
        unset( $title_parts['site'], $title_parts['tagline'] );
    }

    return $title_parts;
}
add_filter( 'document_title_parts', 'hotelier_about_portfolio_page_title_parts', 23 );

/**
 * SEO map for contact and legal pages.
 *
 * @return array<string, array<string, array<string, string>>>
 */
function hotelier_page_seo_map() {
    return array(
        'contact' => array(
            'en' => array(
                'title'       => 'Contact 360 Hotelier Consulting | Book Your Hotel Strategy Session',
                'description' => 'Contact 360 Hotelier Consulting to discuss revenue management, distribution strategy and digital growth for your hotel in Cyprus.',
            ),
            'el' => array(
                'title'       => 'Επικοινωνία με την 360 Hotelier Consulting | Κλείστε Στρατηγική Συνεδρία',
                'description' => 'Επικοινωνήστε με την 360 Hotelier Consulting για revenue management, στρατηγική διανομής και digital ανάπτυξη του ξενοδοχείου σας στην Κύπρο.',
            ),
        ),
        'privacy-policy' => array(
            'en' => array(
                'title'       => 'Privacy Policy | 360 Hotelier Consulting',
                'description' => 'Read the Privacy Policy of 360 Hotelier Consulting to understand how we collect, use and protect your personal data.',
            ),
            'el' => array(
                'title'       => 'Πολιτική Απορρήτου | 360 Hotelier Consulting',
                'description' => 'Διαβάστε την Πολιτική Απορρήτου της 360 Hotelier Consulting για το πώς συλλέγουμε, χρησιμοποιούμε και προστατεύουμε τα προσωπικά σας δεδομένα.',
            ),
        ),
        'cookie-policy' => array(
            'en' => array(
                'title'       => 'Cookie Policy | 360 Hotelier Consulting',
                'description' => 'Learn how 360 Hotelier Consulting uses cookies and similar technologies to improve site performance and user experience.',
            ),
            'el' => array(
                'title'       => 'Πολιτική Cookies | 360 Hotelier Consulting',
                'description' => 'Μάθετε πώς η 360 Hotelier Consulting χρησιμοποιεί cookies και παρόμοιες τεχνολογίες για βελτίωση απόδοσης και εμπειρίας χρήσης.',
            ),
        ),
        'terms' => array(
            'en' => array(
                'title'       => 'Terms & Conditions | 360 Hotelier Consulting',
                'description' => 'Review the Terms & Conditions of 360 Hotelier Consulting for the rules governing use of this website and its services.',
            ),
            'el' => array(
                'title'       => 'Όροι & Προϋποθέσεις | 360 Hotelier Consulting',
                'description' => 'Δείτε τους Όρους & Προϋποθέσεις της 360 Hotelier Consulting για τους κανόνες χρήσης της ιστοσελίδας και των υπηρεσιών της.',
            ),
        ),
    );
}

/**
 * Resolve SEO page key for contact + legal pages.
 */
function hotelier_current_page_seo_key() {
    if ( ! is_page() ) {
        return '';
    }

    if ( is_page_template( 'page-templates/template-contact.php' ) ) {
        return 'contact';
    }

    $post = get_post();
    if ( ! $post instanceof WP_Post ) {
        return '';
    }

    $slug = (string) $post->post_name;
    if ( in_array( $slug, array( 'privacy-policy', 'cookie-policy', 'terms' ), true ) ) {
        return $slug;
    }

    return '';
}

/**
 * Returns current page SEO metadata for mapped pages.
 *
 * @return array{title: string, description: string}|null
 */
function hotelier_current_page_seo_meta() {
    $key = hotelier_current_page_seo_key();
    if ( '' === $key ) {
        return null;
    }

    $map = hotelier_page_seo_map();
    if ( ! isset( $map[ $key ] ) ) {
        return null;
    }

    $lang = function_exists( 'hotelier_get_current_lang' ) ? hotelier_get_current_lang() : 'en';
    if ( 'el' !== $lang ) {
        $lang = 'en';
    }

    if ( ! isset( $map[ $key ][ $lang ]['title'], $map[ $key ][ $lang ]['description'] ) ) {
        return null;
    }

    return array(
        'title'       => $map[ $key ][ $lang ]['title'],
        'description' => $map[ $key ][ $lang ]['description'],
    );
}

/**
 * Output meta description for contact and legal pages.
 */
function hotelier_page_seo_meta_head() {
    $meta = hotelier_current_page_seo_meta();
    if ( ! is_array( $meta ) ) {
        return;
    }

    echo '<meta name="description" content="' . esc_attr( $meta['description'] ) . '">' . "\n";
}
add_action( 'wp_head', 'hotelier_page_seo_meta_head', 1 );

/**
 * Override title parts for contact and legal pages.
 *
 * @param array<string, string> $title_parts Title parts from WordPress.
 * @return array<string, string>
 */
function hotelier_page_seo_title_parts( $title_parts ) {
    $meta = hotelier_current_page_seo_meta();
    if ( ! is_array( $meta ) ) {
        return $title_parts;
    }

    $title_parts['title'] = $meta['title'];
    unset( $title_parts['site'], $title_parts['tagline'] );

    return $title_parts;
}
add_filter( 'document_title_parts', 'hotelier_page_seo_title_parts', 24 );

/**
 * Apply noindex directives to the style guide page.
 *
 * @param array<string, bool> $robots The robots directives.
 * @return array<string, bool>
 */
function hotelier_style_guide_noindex_robots( $robots ) {
    if ( is_page_template( 'page-templates/template-style-guide.php' ) ) {
        $robots['noindex']  = true;
        $robots['nofollow'] = true;
    }

    return $robots;
}
add_filter( 'wp_robots', 'hotelier_style_guide_noindex_robots' );
