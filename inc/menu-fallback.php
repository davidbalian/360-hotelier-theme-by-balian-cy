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
 * Service sub-pages for the primary nav submenu (aligned with theme default pages).
 *
 * @return array<int, array{url: string, label: string}>
 */
function hotelier_get_service_submenu_items() {
    $slugs = array(
        'revenue-management',
        'online-sales-distribution',
        'digital-marketing',
        'tour-operator-contracting',
    );

    $items = array();
    foreach ( $slugs as $slug ) {
        $content = hotelier_get_service_content( $slug );
        $label   = ( is_array( $content ) && isset( $content['title'] ) ) ? $content['title'] : $slug;
        $items[] = array(
            'url'   => hotelier_get_page_url_by_slug( $slug ),
            'label' => $label,
        );
    }

    return $items;
}

/**
 * Default primary/footer navigation items (tree: optional `children` per item).
 *
 * @return array<int, array{url: string, label: string, children?: array<int, array{url: string, label: string}>}>
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
            'url'      => hotelier_get_page_url_by_slug( 'services' ),
            'label'    => __( 'Services', '360-hotelier' ),
            'children' => hotelier_get_service_submenu_items(),
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
 * Output one fallback nav item and optional submenu.
 *
 * @param array  $item    Item with url, label, optional children.
 * @param bool   $flatten When true, do not output child lists (footer depth 1).
 */
function hotelier_render_default_nav_item( $item, $flatten ) {
    $children     = isset( $item['children'] ) && is_array( $item['children'] ) ? $item['children'] : array();
    $has_children = ! $flatten && ! empty( $children );

    $li_classes = 'menu-item';
    if ( $has_children ) {
        $li_classes .= ' menu-item-has-children';
    }

    echo '<li class="' . esc_attr( $li_classes ) . '">';
    printf(
        '<a href="%s">%s</a>',
        esc_url( $item['url'] ),
        esc_html( $item['label'] )
    );

    if ( $has_children ) {
        echo '<ul class="sub-menu">';
        foreach ( $children as $child ) {
            echo '<li class="menu-item">';
            printf(
                '<a href="%s">%s</a>',
                esc_url( $child['url'] ),
                esc_html( $child['label'] )
            );
            echo '</li>';
        }
        echo '</ul>';
    }

    echo '</li>';
}

/**
 * Fallback callback for wp_nav_menu when no menu is assigned.
 *
 * @param array $args Nav menu arguments.
 */
function hotelier_default_nav_fallback( $args ) {
    $items      = hotelier_get_default_nav_items();
    $menu_class = isset( $args['menu_class'] ) ? $args['menu_class'] : 'nav-menu';
    $menu_id    = isset( $args['menu_id'] ) ? $args['menu_id'] : 'primary-menu';
    $depth      = isset( $args['depth'] ) ? (int) $args['depth'] : 0;
    $flatten    = ( 1 === $depth );

    echo '<ul id="' . esc_attr( $menu_id ) . '" class="' . esc_attr( $menu_class ) . '">';
    foreach ( $items as $item ) {
        hotelier_render_default_nav_item( $item, $flatten );
    }
    echo '</ul>';
}
