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
    add_editor_style( 'assets/css/editor-style.css' );
}
add_action( 'after_setup_theme', 'hotelier_theme_setup' );

/**
 * Create default pages on theme activation.
 */
function hotelier_create_default_pages() {
    if ( get_option( 'hotelier_pages_created' ) ) {
        return;
    }

    $pages = array(
        array(
            'title'    => 'Home',
            'slug'     => 'home',
            'template' => 'default',
            'front'    => true,
        ),
        array(
            'title'    => 'About Us',
            'slug'     => 'about-us',
            'template' => 'page-templates/template-about.php',
        ),
        array(
            'title'    => 'Services',
            'slug'     => 'services',
            'template' => 'page-templates/template-services.php',
        ),
        array(
            'title'    => 'Revenue Management',
            'slug'     => 'revenue-management',
            'template' => 'page-templates/template-service-single.php',
            'parent'   => 'services',
        ),
        array(
            'title'    => 'Online Sales & Distribution',
            'slug'     => 'online-sales-distribution',
            'template' => 'page-templates/template-service-single.php',
            'parent'   => 'services',
        ),
        array(
            'title'    => 'Digital Marketing',
            'slug'     => 'digital-marketing',
            'template' => 'page-templates/template-service-single.php',
            'parent'   => 'services',
        ),
        array(
            'title'    => 'Tour Operator Contracting',
            'slug'     => 'tour-operator-contracting',
            'template' => 'page-templates/template-service-single.php',
            'parent'   => 'services',
        ),
        array(
            'title'    => 'Portfolio',
            'slug'     => 'portfolio',
            'template' => 'page-templates/template-portfolio.php',
        ),
        array(
            'title'    => 'Contact',
            'slug'     => 'contact',
            'template' => 'page-templates/template-contact.php',
        ),
        array(
            'title'    => 'Founder',
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

        $page = get_page_by_path( $page_data['slug'] );
        if ( ! $page ) {
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
    }

    update_option( 'hotelier_pages_created', true );
}
add_action( 'after_switch_theme', 'hotelier_create_default_pages' );