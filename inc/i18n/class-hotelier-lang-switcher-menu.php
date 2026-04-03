<?php
/**
 * Primary menu: internal URL prefixing and language switcher markup.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Nav menu filters for locale-aware links and switcher item.
 */
final class Hotelier_Lang_Switcher_Menu {

	public static function register(): void {
		add_filter( 'wp_nav_menu_objects', array( self::class, 'filter_nav_menu_objects' ), 10, 2 );
		add_filter( 'wp_nav_menu_items', array( self::class, 'filter_nav_menu_items' ), 10, 2 );
	}

	/**
	 * @param WP_Post[] $items Menu items.
	 * @param object    $args  Menu args.
	 * @return WP_Post[]
	 */
	public static function filter_nav_menu_objects( array $items, $args ): array {
		if ( ! is_object( $args ) || empty( $args->theme_location ) ) {
			return $items;
		}
		if ( ! in_array( $args->theme_location, array( 'primary', 'footer' ), true ) ) {
			return $items;
		}

		$home_host = wp_parse_url( home_url( '/' ), PHP_URL_HOST );
		if ( ! is_string( $home_host ) ) {
			return $items;
		}

		foreach ( $items as $item ) {
			if ( ! isset( $item->url ) || ! is_string( $item->url ) || '' === $item->url ) {
				continue;
			}
			$h = wp_parse_url( $item->url, PHP_URL_HOST );
			if ( ! is_string( $h ) || strtolower( $h ) !== strtolower( $home_host ) ) {
				continue;
			}
			$item->url = Hotelier_Local_Urls::localize_internal_url( $item->url );
		}

		return $items;
	}

	/**
	 * @param string $items HTML.
	 * @param object $args  Menu args.
	 */
	public static function filter_nav_menu_items( string $items, $args ): string {
		if ( ! is_object( $args ) || empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
			return $items;
		}

		$current = Hotelier_Locale_Detector::current_lang();
		$label   = Hotelier_Locale_Registry::GREEK_LANG === $current
			? esc_html__( 'Ελληνικά', '360-hotelier' )
			: esc_html__( 'English', '360-hotelier' );

		$url_en = esc_url( Hotelier_Local_Urls::lang_url( Hotelier_Locale_Registry::DEFAULT_LANG ) );
		$url_el = esc_url( Hotelier_Local_Urls::lang_url( Hotelier_Locale_Registry::GREEK_LANG ) );

		$parent_href = esc_url( Hotelier_Local_Urls::lang_url( $current ) );

		$li_en_classes = 'menu-item menu-item-lang-en' . ( Hotelier_Locale_Registry::DEFAULT_LANG === $current ? ' current-menu-item' : '' );
		$li_el_classes = 'menu-item menu-item-lang-el' . ( Hotelier_Locale_Registry::GREEK_LANG === $current ? ' current-menu-item' : '' );

		$aria_en = Hotelier_Locale_Registry::DEFAULT_LANG === $current ? ' aria-current="page"' : '';
		$aria_el = Hotelier_Locale_Registry::GREEK_LANG === $current ? ' aria-current="page"' : '';

		$chevron = hotelier_get_nav_submenu_chevron_markup();

		$block  = '<li class="menu-item menu-item-has-children nav-lang-switcher">';
		$block .= '<a href="' . $parent_href . '" class="nav-lang-switcher__toggle">' . $label . $chevron . '</a>';
		$block .= '<div class="nav-submenu-clip">';
		$block .= '<ul class="sub-menu">';
		$block .= '<li class="' . esc_attr( $li_en_classes ) . '"><a href="' . $url_en . '"' . $aria_en . '>' . esc_html__( 'English', '360-hotelier' ) . '</a></li>';
		$block .= '<li class="' . esc_attr( $li_el_classes ) . '"><a href="' . $url_el . '"' . $aria_el . '>' . esc_html__( 'Ελληνικά', '360-hotelier' ) . '</a></li>';
		$block .= '</ul></div></li>';

		return $items . $block;
	}
}
