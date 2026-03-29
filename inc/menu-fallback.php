<?php
/**
 * Default navigation menu fallback.
 *
 * Outputs default nav links when no menu is assigned to primary/footer location.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Resolve the front-end URL for a top-level page by slug.
 *
 * @param string $slug Page post_name (e.g. about-us).
 * @return string
 */
function hotelier_get_page_url_by_slug( $slug ) {
    $page = get_page_by_path( $slug, OBJECT, 'page' );
    if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
        return get_permalink( $page );
    }

    return home_url( user_trailingslashit( $slug ) );
}

/**
 * Default primary/footer navigation items.
 *
 * @return array Array of [url, label] pairs.
 */
function hotelier_get_default_nav_items() {
    return array(
        array(
            'url'   => home_url( '/' ),
            'label' => __( 'Home', '360-hotelier' ),
        ),
        array(
            'url'   => hotelier_get_page_url_by_slug( 'about-us' ),
            'label' => __( 'About Us', '360-hotelier' ),
        ),
        array(
            'url'   => hotelier_get_page_url_by_slug( 'services' ),
            'label' => __( 'Services', '360-hotelier' ),
        ),
        array(
            'url'   => hotelier_get_page_url_by_slug( 'portfolio' ),
            'label' => __( 'Portfolio', '360-hotelier' ),
        ),
        array(
            'url'   => hotelier_get_page_url_by_slug( 'contact' ),
            'label' => __( 'Contact', '360-hotelier' ),
        ),
    );
}

/**
 * Fallback callback for wp_nav_menu when no menu is assigned.
 *
 * @param array $args Nav menu arguments.
 */
function hotelier_default_nav_fallback( $args ) {
    $items = hotelier_get_default_nav_items();
    $menu_class = isset( $args['menu_class'] ) ? $args['menu_class'] : 'nav-menu';
    $menu_id    = isset( $args['menu_id'] ) ? $args['menu_id'] : 'primary-menu';

    echo '<ul id="' . esc_attr( $menu_id ) . '" class="' . esc_attr( $menu_class ) . '">';
    foreach ( $items as $item ) {
        printf(
            '<li><a href="%s">%s</a></li>',
            esc_url( $item['url'] ),
            esc_html( $item['label'] )
        );
    }
    echo '</ul>';
}
