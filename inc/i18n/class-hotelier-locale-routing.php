<?php
/**
 * Rewrites, main-query fix for /el/, canonical guard.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers rewrite rules and query behavior for path-prefix locales.
 */
final class Hotelier_Locale_Routing {

	public static function register(): void {
		add_filter( 'query_vars', array( self::class, 'filter_query_vars' ) );
		add_action( 'init', array( self::class, 'action_init_rewrites' ), 1 );
		add_action( 'pre_get_posts', array( self::class, 'action_pre_get_posts' ) );
		add_filter( 'redirect_canonical', array( self::class, 'filter_redirect_canonical' ), 10, 2 );
		add_action( 'after_switch_theme', array( self::class, 'action_flush_rewrites' ) );
		add_action( 'init', array( self::class, 'maybe_flush_on_version' ), 999 );
	}

	/**
	 * @param string[] $vars Query vars.
	 * @return string[]
	 */
	public static function filter_query_vars( array $vars ): array {
		$vars[] = Hotelier_Locale_Registry::QUERY_VAR;

		return $vars;
	}

	public static function action_init_rewrites(): void {
		$qv = Hotelier_Locale_Registry::QUERY_VAR;
		add_rewrite_rule( '^el/?$', 'index.php?' . $qv . '=el', 'top' );
		add_rewrite_rule( '^el/(.+)/?$', 'index.php?' . $qv . '=el&pagename=$matches[1]', 'top' );
	}

	/**
	 * Greek front URL is only query var el — force static front page.
	 *
	 * @param WP_Query $query Main query.
	 */
	public static function action_pre_get_posts( WP_Query $query ): void {
		if ( is_admin() || ! $query->is_main_query() ) {
			return;
		}

		$current_lang = (string) get_query_var( Hotelier_Locale_Registry::QUERY_VAR );
		if ( $current_lang !== Hotelier_Locale_Registry::GREEK_LANG ) {
			return;
		}

		$pagename = (string) get_query_var( 'pagename' );
		$page_id  = (int) get_query_var( 'page_id' );
		$name     = (string) get_query_var( 'name' );

		// Fallback: if /el/founder/ is requested but slug mapping is broken,
		// route to whichever page is assigned the Founder template.
		if ( 'founder' === trim( $pagename, '/' ) && $page_id <= 0 ) {
			$founder_page_id = self::founder_page_id_from_template();
			if ( $founder_page_id > 0 ) {
				$query->set( 'page_id', $founder_page_id );
				$query->set( 'pagename', '' );
				$query->set( 'name', '' );
				$query->is_home       = false;
				$query->is_page       = true;
				$query->is_singular   = true;
				$query->is_front_page = false;
				return;
			}
		}

		if ( '' !== $pagename || $page_id > 0 || '' !== $name ) {
			return;
		}

		$front = (int) get_option( 'page_on_front' );
		if ( $front <= 0 ) {
			return;
		}

		$query->set( 'page_id', $front );
		$query->set( 'pagename', '' );
		$query->set( 'name', '' );
		$query->is_home       = false;
		$query->is_page       = true;
		$query->is_singular   = true;
		$query->is_front_page = true;
	}

	private static function founder_page_id_from_template(): int {
		$ids = get_posts(
			array(
				'post_type'      => 'page',
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'fields'         => 'ids',
				'meta_key'       => '_wp_page_template',
				'meta_value'     => 'page-templates/template-founder.php',
			)
		);

		return ! empty( $ids[0] ) ? (int) $ids[0] : 0;
	}

	/**
	 * @param string|false $redirect_url Redirect target.
	 * @param string       $requested    Requested URL.
	 * @return string|false
	 */
	public static function filter_redirect_canonical( $redirect_url, $requested ) {
		$path = wp_parse_url( (string) $requested, PHP_URL_PATH );
		if ( ! is_string( $path ) ) {
			return $redirect_url;
		}

		$home_path = wp_parse_url( home_url( '/' ), PHP_URL_PATH );
		$rel       = $path;
		if ( is_string( $home_path ) && '' !== $home_path && '/' !== $home_path ) {
			$home_un = untrailingslashit( $home_path );
			if ( strpos( $path, $home_un ) === 0 ) {
				$rel = substr( $path, strlen( $home_un ) );
				if ( '' === $rel ) {
					$rel = '/';
				} elseif ( '/' !== $rel[0] ) {
					$rel = '/' . $rel;
				}
			}
		}

		$first = Hotelier_Locale_Detector::first_path_segment( $rel );
		if ( Hotelier_Locale_Registry::GREEK_LANG === $first ) {
			return false;
		}

		return $redirect_url;
	}

	public static function action_flush_rewrites(): void {
		self::action_init_rewrites();
		flush_rewrite_rules( false );
		update_option( 'hotelier_i18n_rewrite_version', Hotelier_Locale_Registry::REWRITE_VERSION );
	}

	public static function maybe_flush_on_version(): void {
		$v = get_option( 'hotelier_i18n_rewrite_version', '' );
		if ( Hotelier_Locale_Registry::REWRITE_VERSION === (string) $v ) {
			return;
		}
		self::action_init_rewrites();
		flush_rewrite_rules( false );
		update_option( 'hotelier_i18n_rewrite_version', Hotelier_Locale_Registry::REWRITE_VERSION );
	}
}
