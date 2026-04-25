<?php
/**
 * Auto-created Greek navigation menus (primary + footer) and locale-based injection.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Builds / updates wp_nav_menu terms with Greek labels; swaps them in on /el/ requests.
 */
final class Hotelier_Greek_Nav_Sync {

	public const SYNC_VERSION = 2;

	private const MENU_PRIMARY_NAME = '360 Hotelier — Primary (Ελληνικά)';

	private const MENU_FOOTER_NAME = '360 Hotelier — Footer (Ελληνικά)';

	private const OPTION_PRIMARY_ID = 'hotelier_nav_menu_el_primary';

	private const OPTION_FOOTER_ID = 'hotelier_nav_menu_el_footer';

	private const OPTION_SYNC_VERSION = 'hotelier_greek_nav_sync_version';

	/**
	 * Greek labels keyed by page slug (or service child slug).
	 *
	 * @return array<string, string>
	 */
	private static function label_map(): array {
		return array(
			'home'                       => 'Αρχική',
			'about-us'                   => 'Σχετικά με εμάς',
			'services'                   => 'Υπηρεσίες',
			'portfolio'                  => 'Χαρτοφυλάκιο',
			'contact'                    => 'Επικοινωνία',
			'revenue-management'         => 'Διαχείριση εσόδων',
			'online-sales-distribution'  => 'Online πωλήσεις & διανομή',
			'digital-marketing'          => 'Ψηφιακό μάρκετινγκ',
			'tour-operator-contracting'  => 'Συμβάσεις tour operators',
		);
	}

	public static function register(): void {
		add_action( 'after_switch_theme', array( self::class, 'on_after_switch_theme' ), 20 );
		add_action( 'admin_init', array( self::class, 'maybe_sync_on_admin' ), 5 );
		add_filter( 'wp_nav_menu_args', array( self::class, 'filter_wp_nav_menu_args' ), 5 );
	}

	public static function on_after_switch_theme(): void {
		self::sync_all_menus();
	}

	public static function maybe_sync_on_admin(): void {
		if ( ! current_user_can( 'edit_theme_options' ) ) {
			return;
		}
		if ( (int) get_option( self::OPTION_SYNC_VERSION, 0 ) >= self::SYNC_VERSION ) {
			return;
		}
		self::sync_all_menus();
	}

	/**
	 * Use Greek menus on /el/ when they exist.
	 *
	 * @param array<string, mixed> $args wp_nav_menu args.
	 * @return array<string, mixed>
	 */
	public static function filter_wp_nav_menu_args( array $args ): array {
		if ( empty( $args['theme_location'] ) ) {
			return $args;
		}
		if ( ! function_exists( 'hotelier_get_current_lang' ) || Hotelier_Locale_Registry::GREEK_LANG !== hotelier_get_current_lang() ) {
			return $args;
		}
		$loc = (string) $args['theme_location'];
		if ( 'primary' === $loc ) {
			$id = (int) get_option( self::OPTION_PRIMARY_ID, 0 );
		} elseif ( 'footer' === $loc ) {
			$id = (int) get_option( self::OPTION_FOOTER_ID, 0 );
		} else {
			return $args;
		}
		if ( $id <= 0 ) {
			return $args;
		}
		$menu_obj = wp_get_nav_menu_object( $id );
		if ( ! $menu_obj ) {
			return $args;
		}
		$args['menu'] = $id;

		return $args;
	}

	public static function sync_all_menus(): void {
		$labels = self::label_map();
		$primary_id = self::sync_primary_menu( $labels );
		$footer_id  = self::sync_footer_menu( $labels );
		if ( $primary_id > 0 ) {
			update_option( self::OPTION_PRIMARY_ID, $primary_id );
		}
		if ( $footer_id > 0 ) {
			update_option( self::OPTION_FOOTER_ID, $footer_id );
		}
		update_option( self::OPTION_SYNC_VERSION, self::SYNC_VERSION );
	}

	/**
	 * @param array<string, string> $labels label_map().
	 */
	private static function sync_primary_menu( array $labels ): int {
		$menu_id = self::get_or_create_menu( self::MENU_PRIMARY_NAME );
		if ( $menu_id <= 0 ) {
			return 0;
		}
		self::delete_all_menu_items( $menu_id );

		$front_id = (int) get_option( 'page_on_front' );
		if ( $front_id > 0 ) {
			self::add_page_item( $menu_id, $front_id, $labels['home'], 0 );
		} else {
			self::add_custom_item( $menu_id, $labels['home'], home_url( '/' ), 0 );
		}

		$about = get_page_by_path( 'about', OBJECT, 'page' );
		if ( $about instanceof WP_Post ) {
			self::add_page_item( $menu_id, (int) $about->ID, $labels['about-us'], 0 );
		}

		$services = get_page_by_path( 'services', OBJECT, 'page' );
		$parent_mid = 0;
		if ( $services instanceof WP_Post ) {
			$parent_mid = self::add_page_item( $menu_id, (int) $services->ID, $labels['services'], 0 );
		}

		if ( $parent_mid > 0 ) {
			foreach ( hotelier_get_service_child_slugs() as $child_slug ) {
				$path = 'services/' . $child_slug;
				$child = get_page_by_path( $path, OBJECT, 'page' );
				if ( ! $child instanceof WP_Post ) {
					continue;
				}
				$title = isset( $labels[ $child_slug ] ) ? $labels[ $child_slug ] : $child_slug;
				self::add_page_item( $menu_id, (int) $child->ID, $title, $parent_mid );
			}
		}

		$portfolio = get_page_by_path( 'portfolio', OBJECT, 'page' );
		if ( $portfolio instanceof WP_Post ) {
			self::add_page_item( $menu_id, (int) $portfolio->ID, $labels['portfolio'], 0 );
		}

		$contact = get_page_by_path( 'contact', OBJECT, 'page' );
		if ( $contact instanceof WP_Post ) {
			self::add_page_item( $menu_id, (int) $contact->ID, $labels['contact'], 0 );
		}

		return $menu_id;
	}

	/**
	 * @param array<string, string> $labels label_map().
	 */
	private static function sync_footer_menu( array $labels ): int {
		$menu_id = self::get_or_create_menu( self::MENU_FOOTER_NAME );
		if ( $menu_id <= 0 ) {
			return 0;
		}
		self::delete_all_menu_items( $menu_id );

		$front_id = (int) get_option( 'page_on_front' );
		if ( $front_id > 0 ) {
			self::add_page_item( $menu_id, $front_id, $labels['home'], 0 );
		} else {
			self::add_custom_item( $menu_id, $labels['home'], home_url( '/' ), 0 );
		}

		$about = get_page_by_path( 'about', OBJECT, 'page' );
		if ( $about instanceof WP_Post ) {
			self::add_page_item( $menu_id, (int) $about->ID, $labels['about-us'], 0 );
		}

		$services = get_page_by_path( 'services', OBJECT, 'page' );
		if ( $services instanceof WP_Post ) {
			self::add_page_item( $menu_id, (int) $services->ID, $labels['services'], 0 );
		}

		$portfolio = get_page_by_path( 'portfolio', OBJECT, 'page' );
		if ( $portfolio instanceof WP_Post ) {
			self::add_page_item( $menu_id, (int) $portfolio->ID, $labels['portfolio'], 0 );
		}

		$contact = get_page_by_path( 'contact', OBJECT, 'page' );
		if ( $contact instanceof WP_Post ) {
			self::add_page_item( $menu_id, (int) $contact->ID, $labels['contact'], 0 );
		}

		return $menu_id;
	}

	private static function get_or_create_menu( string $name ): int {
		$menus = wp_get_nav_menus();
		if ( is_array( $menus ) ) {
			foreach ( $menus as $term ) {
				if ( isset( $term->name ) && $name === $term->name ) {
					return (int) $term->term_id;
				}
			}
		}
		$created = wp_create_nav_menu( $name );
		if ( is_wp_error( $created ) ) {
			return 0;
		}
		return (int) $created;
	}

	private static function delete_all_menu_items( int $menu_id ): void {
		$items = wp_get_nav_menu_items( $menu_id, array( 'post_status' => 'any' ) );
		if ( ! is_array( $items ) ) {
			return;
		}
		foreach ( array_reverse( $items ) as $item ) {
			if ( isset( $item->ID ) ) {
				wp_delete_post( (int) $item->ID, true );
			}
		}
	}

	private static function add_page_item( int $menu_id, int $page_id, string $title, int $parent_db_id ): int {
		$args = array(
			'menu-item-title'     => $title,
			'menu-item-object'    => 'page',
			'menu-item-object-id' => $page_id,
			'menu-item-type'      => 'post_type',
			'menu-item-status'    => 'publish',
		);
		if ( $parent_db_id > 0 ) {
			$args['menu-item-parent-id'] = $parent_db_id;
		}
		$mid = wp_update_nav_menu_item( $menu_id, 0, $args );
		return is_wp_error( $mid ) ? 0 : (int) $mid;
	}

	private static function add_custom_item( int $menu_id, string $title, string $url, int $parent_db_id ): int {
		$args = array(
			'menu-item-title'  => $title,
			'menu-item-url'    => esc_url_raw( $url ),
			'menu-item-type'   => 'custom',
			'menu-item-status' => 'publish',
		);
		if ( $parent_db_id > 0 ) {
			$args['menu-item-parent-id'] = $parent_db_id;
		}
		$mid = wp_update_nav_menu_item( $menu_id, 0, $args );
		return is_wp_error( $mid ) ? 0 : (int) $mid;
	}
}

Hotelier_Greek_Nav_Sync::register();
