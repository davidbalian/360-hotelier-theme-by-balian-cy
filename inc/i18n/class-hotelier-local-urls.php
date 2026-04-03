<?php
/**
 * Language-aware internal URLs.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Builds localized paths and full URLs for the current or target language.
 */
final class Hotelier_Local_Urls {

	/**
	 * Home URL with optional extra path, respecting current language prefix.
	 *
	 * @param string $path Extra path without leading slash (e.g. about-us).
	 */
	public static function localized_home_url( string $path = '' ): string {
		$lang = Hotelier_Locale_Detector::current_lang();
		$trim = trim( $path, '/' );

		return home_url( user_trailingslashit( self::relative_path_for( $trim, $lang ) ) );
	}

	/**
	 * Same logical path as now, in another language.
	 */
	public static function lang_url( string $target_lang ): string {
		if ( ! Hotelier_Locale_Registry::is_supported_code( $target_lang ) ) {
			$target_lang = Hotelier_Locale_Registry::DEFAULT_LANG;
		}
		$logical = Hotelier_Locale_Detector::logical_path_without_lang_prefix();
		$trim    = trim( $logical, '/' );

		return home_url( user_trailingslashit( self::relative_path_for( $trim, $target_lang ) ) );
	}

	/**
	 * @param string $trimmed_logical Path without leading/trailing slashes; empty = front.
	 * @param string $lang            en | el.
	 */
	public static function relative_path_for( string $trimmed_logical, string $lang ): string {
		if ( Hotelier_Locale_Registry::DEFAULT_LANG === $lang ) {
			return '' === $trimmed_logical ? '/' : '/' . $trimmed_logical;
		}

		return '' === $trimmed_logical ? '/el' : '/el/' . $trimmed_logical;
	}

	/**
	 * If URL is internal to this site, apply current language prefix to its path.
	 */
	public static function localize_internal_url( string $url ): string {
		if ( '' === $url ) {
			return $url;
		}

		$parsed = wp_parse_url( $url );
		if ( ! is_array( $parsed ) ) {
			return $url;
		}

		$home_parsed = wp_parse_url( home_url( '/' ) );
		if ( ! isset( $parsed['host'], $home_parsed['host'] ) ) {
			return $url;
		}

		if ( strtolower( (string) $parsed['host'] ) !== strtolower( (string) $home_parsed['host'] ) ) {
			return $url;
		}

		$path = isset( $parsed['path'] ) ? (string) $parsed['path'] : '/';

		$home_path = isset( $home_parsed['path'] ) ? untrailingslashit( (string) $home_parsed['path'] ) : '';
		if ( '' !== $home_path && strpos( $path, $home_path ) === 0 ) {
			$path = substr( $path, strlen( $home_path ) );
			if ( '' === $path ) {
				$path = '/';
			} elseif ( '/' !== $path[0] ) {
				$path = '/' . $path;
			}
		}

		$trim = trim( $path, '/' );
		$seg  = '' === $trim ? array() : explode( '/', $trim );
		if ( isset( $seg[0] ) && Hotelier_Locale_Registry::GREEK_LANG === $seg[0] ) {
			array_shift( $seg );
		}
		$logical = '' === $seg ? '' : implode( '/', $seg );

		$lang    = Hotelier_Locale_Detector::current_lang();
		$new_rel = self::relative_path_for( $logical, $lang );

		$query = isset( $parsed['query'] ) ? '?' . $parsed['query'] : '';
		$frag  = isset( $parsed['fragment'] ) ? '#' . $parsed['fragment'] : '';

		return home_url( user_trailingslashit( $new_rel ) . $query . $frag );
	}
}
