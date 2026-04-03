<?php
/**
 * Resolves current path-prefix language for the request.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Detects active locale from query vars or REQUEST_URI.
 */
final class Hotelier_Locale_Detector {

	/** @var string|null */
	private static $cached_lang = null;

	public static function reset_cache(): void {
		self::$cached_lang = null;
	}

	/**
	 * Active short code: en | el.
	 */
	public static function current_lang(): string {
		if ( null !== self::$cached_lang ) {
			return self::$cached_lang;
		}

		$from_qv = get_query_var( Hotelier_Locale_Registry::QUERY_VAR );
		if ( Hotelier_Locale_Registry::GREEK_LANG === $from_qv ) {
			self::$cached_lang = Hotelier_Locale_Registry::GREEK_LANG;
			return self::$cached_lang;
		}

		$path  = self::path_relative_to_home();
		$first = self::first_path_segment( $path );
		if ( Hotelier_Locale_Registry::GREEK_LANG === $first ) {
			self::$cached_lang = Hotelier_Locale_Registry::GREEK_LANG;
			return self::$cached_lang;
		}

		self::$cached_lang = Hotelier_Locale_Registry::DEFAULT_LANG;
		return self::$cached_lang;
	}

	/**
	 * Path after home URL path, leading slash, no trailing slash normalization.
	 * Example: /el/about-us/ → /el/about-us/ then first segment el.
	 */
	public static function path_relative_to_home(): string {
		$uri = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : '/';
		$path = wp_parse_url( $uri, PHP_URL_PATH );
		if ( ! is_string( $path ) || '' === $path ) {
			$path = '/';
		}

		$home = wp_parse_url( home_url( '/' ), PHP_URL_PATH );
		if ( is_string( $home ) && '' !== $home && '/' !== $home ) {
			$home_un = untrailingslashit( $home );
			if ( strpos( $path, $home_un ) === 0 ) {
				$path = substr( $path, strlen( $home_un ) );
				if ( '' === $path ) {
					$path = '/';
				} elseif ( '/' !== $path[0] ) {
					$path = '/' . $path;
				}
			}
		}

		return $path;
	}

	public static function logical_path_without_lang_prefix(): string {
		$path = self::path_relative_to_home();
		$path = '/' . trim( $path, '/' );
		if ( '/' === $path ) {
			return '/';
		}

		$parts = explode( '/', trim( $path, '/' ) );
		if ( array() === $parts ) {
			return '/';
		}

		if ( isset( $parts[0] ) && Hotelier_Locale_Registry::GREEK_LANG === $parts[0] ) {
			array_shift( $parts );
		}

		if ( array() === $parts ) {
			return '/';
		}

		return '/' . implode( '/', $parts );
	}

	/**
	 * @param string $path Path starting with /.
	 */
	public static function first_path_segment( string $path ): string {
		$t = trim( $path, '/' );
		if ( '' === $t ) {
			return '';
		}
		$parts = explode( '/', $t );

		return isset( $parts[0] ) ? $parts[0] : '';
	}

	public static function request_starts_with_lang_prefix(): bool {
		$first = self::first_path_segment( self::path_relative_to_home() );

		return Hotelier_Locale_Registry::GREEK_LANG === $first;
	}
}
