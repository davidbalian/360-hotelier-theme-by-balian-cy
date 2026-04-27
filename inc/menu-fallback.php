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
 * Markup for the primary nav dropdown chevron (inline SVG, currentColor).
 *
 * @return string
 */
function hotelier_get_nav_submenu_chevron_markup() {
    return '<span class="nav-submenu-chevron" aria-hidden="true"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"/></svg></span>';
}

/**
 * Append chevron to top-level primary menu items that have submenus.
 *
 * @param string   $title Menu item title.
 * @param WP_Post  $item  Menu item.
 * @param stdClass $args  Menu args.
 * @param int      $depth Depth.
 * @return string
 */
function hotelier_nav_menu_parent_chevron_title( $title, $item, $args, $depth ) {
    if ( 0 !== (int) $depth ) {
        return $title;
    }
    if ( ! is_object( $args ) || empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
        return $title;
    }
    if ( ! in_array( 'menu-item-has-children', (array) $item->classes, true ) ) {
        return $title;
    }

    return $title . hotelier_get_nav_submenu_chevron_markup();
}

add_filter( 'nav_menu_item_title', 'hotelier_nav_menu_parent_chevron_title', 10, 4 );

/**
 * Service single-page slugs (children of the Services page in default theme setup).
 *
 * @return string[]
 */
function hotelier_get_service_child_slugs() {
    return array(
        'revenue-management',
        'online-sales-distribution',
        'digital-marketing',
        'tour-operator-contracting',
    );
}

/**
 * Resolve the front-end URL for a page by slug (supports child pages under Services).
 *
 * @param string $slug Page post_name (e.g. about, revenue-management).
 * @return string
 */
function hotelier_get_page_url_by_slug( $slug ) {
    $candidates = array( $slug );

    if ( in_array( $slug, hotelier_get_service_child_slugs(), true ) ) {
        array_unshift( $candidates, 'services/' . $slug );
    }
    if ( in_array( $slug, array( 'founder', 'portfolio' ), true ) ) {
        array_unshift( $candidates, 'about/' . $slug );
    }

    foreach ( $candidates as $path ) {
        $page = get_page_by_path( $path, OBJECT, 'page' );
        if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
            $url = get_permalink( $page );
            return function_exists( 'hotelier_localize_internal_url' ) ? hotelier_localize_internal_url( $url ) : $url;
        }
    }

    if ( in_array( $slug, hotelier_get_service_child_slugs(), true ) ) {
        $url = home_url( user_trailingslashit( 'services/' . $slug ) );
    } elseif ( in_array( $slug, array( 'founder', 'portfolio' ), true ) ) {
        $url = home_url( user_trailingslashit( 'about/' . $slug ) );
    } else {
        $url = home_url( user_trailingslashit( $slug ) );
    }

    return function_exists( 'hotelier_localize_internal_url' ) ? hotelier_localize_internal_url( $url ) : $url;
}

/**
 * URLs for footer legal links (Settings → Privacy page when set, else theme pages).
 *
 * @return array{privacy: string, cookie: string, terms: string}
 */
function hotelier_get_footer_legal_urls() {
    $privacy = '';
    if ( function_exists( 'get_privacy_policy_url' ) ) {
        $privacy = get_privacy_policy_url();
    }
    if ( ! is_string( $privacy ) || '' === $privacy ) {
        $privacy = hotelier_get_page_url_by_slug( 'privacy-policy' );
    } elseif ( function_exists( 'hotelier_localize_internal_url' ) ) {
        $privacy = hotelier_localize_internal_url( $privacy );
    }

    return array(
        'privacy' => $privacy,
        'cookie'  => hotelier_get_page_url_by_slug( 'cookie-policy' ),
        'terms'   => hotelier_get_page_url_by_slug( 'terms' ),
    );
}

/**
 * Service sub-pages for the primary nav submenu (aligned with theme default pages).
 *
 * @return array<int, array{url: string, label: string}>
 */
function hotelier_get_service_submenu_items() {
    $slugs = hotelier_get_service_child_slugs();

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
 * Label for the Services submenu “view all” link (explicit Greek on /el/; .mo may be absent on some deploys).
 *
 * @return string Plain text.
 */
function hotelier_nav_all_services_label(): string {
    if ( function_exists( 'hotelier_get_current_lang' ) && 'el' === hotelier_get_current_lang() ) {
        return 'Όλες οι υπηρεσίες';
    }

    return __( 'All Services', '360-hotelier' );
}

/**
 * Default primary/footer navigation items (tree: optional `children` per item).
 *
 * @return array<int, array{url: string, label: string, children?: array<int, array{url: string, label: string}>}>
 */
function hotelier_get_default_nav_items() {
    return array(
        array(
            'url'   => function_exists( 'hotelier_get_localized_home_url' ) ? hotelier_get_localized_home_url() : home_url( '/' ),
            'label' => __( 'Home', '360-hotelier' ),
        ),
        array(
            'url'   => hotelier_get_page_url_by_slug( 'about' ),
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
    $link_inner = esc_html( $item['label'] );
    if ( $has_children ) {
        $link_inner .= hotelier_get_nav_submenu_chevron_markup();
    }
    printf(
        '<a href="%s">%s</a>',
        esc_url( $item['url'] ),
        $link_inner
    );

    if ( $has_children ) {
        echo '<div class="nav-submenu-clip">';
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
        echo '<li class="menu-item menu-item-all-services">';
        printf(
            '<a href="%s">%s</a>',
            esc_url( $item['url'] ),
            esc_html( hotelier_nav_all_services_label() )
        );
        echo '</li>';
        echo '</ul>';
        echo '</div>';
    }

    echo '</li>';
}

/**
 * Fallback callback for wp_nav_menu when no menu is assigned.
 *
 * @param array $args Nav menu arguments.
 */
function hotelier_default_nav_fallback( $args ) {
    $items = hotelier_get_default_nav_items();
    // wp_nav_menu passes $args as object; support array for direct calls.
    $menu_class = '';
    $menu_id    = 'primary-menu';
    $depth      = 0;
    if ( is_object( $args ) ) {
        $menu_class = isset( $args->menu_class ) ? (string) $args->menu_class : '';
        $menu_id    = isset( $args->menu_id ) ? (string) $args->menu_id : 'primary-menu';
        $depth      = isset( $args->depth ) ? (int) $args->depth : 0;
    } elseif ( is_array( $args ) ) {
        $menu_class = isset( $args['menu_class'] ) ? (string) $args['menu_class'] : '';
        $menu_id    = isset( $args['menu_id'] ) ? (string) $args['menu_id'] : 'primary-menu';
        $depth      = isset( $args['depth'] ) ? (int) $args['depth'] : 0;
    }
    if ( '' === $menu_class ) {
        $menu_class = 'nav-menu';
    }
    $flatten = ( 1 === $depth );

    echo '<ul id="' . esc_attr( $menu_id ) . '" class="' . esc_attr( $menu_class ) . '">';
    foreach ( $items as $item ) {
        hotelier_render_default_nav_item( $item, $flatten );
    }
    echo '</ul>';
}
