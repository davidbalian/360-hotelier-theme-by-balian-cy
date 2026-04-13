<?php
/**
 * Primary menu: internal URL prefixing for locale-aware links.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Nav menu filters for locale-aware internal links.
 */
final class Hotelier_Lang_Switcher_Menu {

	public static function register(): void {
		add_filter( 'wp_nav_menu_objects', array( self::class, 'filter_nav_menu_objects' ), 10, 2 );
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
}
