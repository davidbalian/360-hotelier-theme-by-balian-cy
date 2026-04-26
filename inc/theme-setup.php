<?php
/**
 * Theme Setup Functions
 *
 * @package 360-hotelier
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Set up theme defaults and register support for various WordPress features.
 */
function hotelier_theme_setup() {
    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title.
    add_theme_support( 'title-tag' );

    // Enable support for Post Thumbnails on posts and pages.
    add_theme_support( 'post-thumbnails' );

    // Front-page service cards (~696px CSS max; 840px covers ~1.2× for sharpness on large phones).
    add_image_size( 'hotelier-service-card', 840, 473, true );

    // Register navigation menus.
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', '360-hotelier' ),
        'footer'  => __( 'Footer Menu', '360-hotelier' ),
    ) );

    // Switch default core markup for search form, comment form, and comments to output valid HTML5.
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // Add theme support for selective refresh for widgets.
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Add support for custom logo.
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-width'  => true,
        'flex-height' => true,
    ) );

    // Add support for editor styles.
    add_theme_support( 'editor-styles' );
    add_editor_style( array( 'style.css', 'assets/css/editor-style.css' ) );

    // Add support for site icon (favicon).
    add_theme_support( 'site-icon' );

    load_theme_textdomain( '360-hotelier', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'hotelier_theme_setup' );

/**
 * Output default favicon when no site icon is set in Customizer.
 */
function hotelier_favicon() {
    if ( ! has_site_icon() ) {
        echo '<link rel="icon" href="' . esc_url( content_url( '/uploads/2026/04/360-HOTELIER_Favicon.jpg' ) ) . '" type="image/jpeg">' . "\n";
    }
}
add_action( 'wp_head', 'hotelier_favicon', 1 );

/**
 * Create default pages on theme activation.
 */
function hotelier_create_default_pages() {
    if ( get_option( 'hotelier_pages_created' ) ) {
        return;
    }

    $pages = array(
        array(
            'title'    => __( 'Home', '360-hotelier' ),
            'slug'     => 'home',
            'template' => 'default',
            'front'    => true,
        ),
        array(
            'title'    => __( 'About Us', '360-hotelier' ),
            'slug'     => 'about',
            'template' => 'page-templates/template-about.php',
        ),
        array(
            'title'    => __( 'Services', '360-hotelier' ),
            'slug'     => 'services',
            'template' => 'page-templates/template-services.php',
        ),
        array(
            'title'    => __( 'Revenue Management', '360-hotelier' ),
            'slug'     => 'revenue-management',
            'template' => 'page-templates/template-service-single.php',
            'parent'   => 'services',
        ),
        array(
            'title'    => __( 'Online Sales & Distribution', '360-hotelier' ),
            'slug'     => 'online-sales-distribution',
            'template' => 'page-templates/template-service-single.php',
            'parent'   => 'services',
        ),
        array(
            'title'    => __( 'Digital Marketing', '360-hotelier' ),
            'slug'     => 'digital-marketing',
            'template' => 'page-templates/template-service-single.php',
            'parent'   => 'services',
        ),
        array(
            'title'    => __( 'Tour Operator Contracting', '360-hotelier' ),
            'slug'     => 'tour-operator-contracting',
            'template' => 'page-templates/template-service-single.php',
            'parent'   => 'services',
        ),
        array(
            'title'    => __( 'Portfolio', '360-hotelier' ),
            'slug'     => 'portfolio',
            'template' => 'page-templates/template-portfolio.php',
        ),
        array(
            'title'    => __( 'Contact', '360-hotelier' ),
            'slug'     => 'contact',
            'template' => 'page-templates/template-contact.php',
        ),
        array(
            'title'    => __( 'Founder', '360-hotelier' ),
            'slug'     => 'founder',
            'template' => 'page-templates/template-founder.php',
        ),
    );

    $parent_ids = array();

    foreach ( $pages as $page_data ) {
        $parent_id = 0;
        if ( ! empty( $page_data['parent'] ) && isset( $parent_ids[ $page_data['parent'] ] ) ) {
            $parent_id = $parent_ids[ $page_data['parent'] ];
        }

        $lookup_path = $page_data['slug'];
        if ( ! empty( $page_data['parent'] ) ) {
            $lookup_path = $page_data['parent'] . '/' . $page_data['slug'];
        }

        $page = get_page_by_path( $lookup_path, OBJECT, 'page' );
        if ( $page instanceof WP_Post ) {
            $parent_ids[ $page_data['slug'] ] = (int) $page->ID;
            continue;
        }

        $page_id = wp_insert_post( array(
            'post_title'   => $page_data['title'],
            'post_name'    => $page_data['slug'],
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_parent'  => $parent_id,
            'post_content' => '',
        ) );
        if ( $page_id && ! is_wp_error( $page_id ) ) {
            if ( ! empty( $page_data['template'] ) && 'default' !== $page_data['template'] ) {
                update_post_meta( $page_id, '_wp_page_template', $page_data['template'] );
            }
            $parent_ids[ $page_data['slug'] ] = $page_id;
            if ( ! empty( $page_data['front'] ) ) {
                update_option( 'show_on_front', 'page' );
                update_option( 'page_on_front', $page_id );
            }
        }
    }

    update_option( 'hotelier_pages_created', true );
}
add_action( 'after_switch_theme', 'hotelier_create_default_pages' );

/**
 * Create footer legal pages once if missing (covers sites that activated the theme before those pages existed).
 */
function hotelier_ensure_legal_pages_exist() {
    if ( get_option( 'hotelier_legal_pages_ensured_v1' ) ) {
        return;
    }

    $legal_pages = array(
        'privacy-policy' => __( 'Privacy Policy', '360-hotelier' ),
        'cookie-policy'  => __( 'Cookie Policy', '360-hotelier' ),
        'terms'          => __( 'Terms & Conditions', '360-hotelier' ),
    );

    foreach ( $legal_pages as $slug => $title ) {
        if ( get_page_by_path( $slug, OBJECT, 'page' ) ) {
            continue;
        }
        wp_insert_post(
            array(
                'post_title'  => $title,
                'post_name'   => $slug,
                'post_status' => 'publish',
                'post_type'   => 'page',
            )
        );
    }

    update_option( 'hotelier_legal_pages_ensured_v1', 1 );
}
add_action( 'after_setup_theme', 'hotelier_ensure_legal_pages_exist', 11 );

/**
 * Migrates About page slug from /about-us to /about on existing installs.
 */
function hotelier_migrate_about_slug() {
    if ( get_option( 'hotelier_about_slug_migrated_v1' ) ) {
        return;
    }

    $about = get_page_by_path( 'about', OBJECT, 'page' );
    if ( $about instanceof WP_Post ) {
        update_option( 'hotelier_about_slug_migrated_v1', 1 );
        return;
    }

    $legacy_about = get_page_by_path( 'about-us', OBJECT, 'page' );
    if ( ! $legacy_about instanceof WP_Post ) {
        update_option( 'hotelier_about_slug_migrated_v1', 1 );
        return;
    }

    wp_update_post(
        array(
            'ID'        => (int) $legacy_about->ID,
            'post_name' => 'about',
        )
    );

    update_option( 'hotelier_about_slug_migrated_v1', 1 );
}
add_action( 'after_setup_theme', 'hotelier_migrate_about_slug', 12 );