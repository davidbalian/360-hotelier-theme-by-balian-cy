<?php
/**
 * Bilingual EN / EL support — URL-prefix language detection, locale switching,
 * and URL helpers for the /el/ prefix approach.
 *
 * Runs very early (required at the top of functions.php before init / parse_request).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
 * 1. Detect /el/ prefix in the request URI and strip it so WordPress
 *    resolves the correct page from the remaining path.
 *    This runs at file-include time, before WordPress parses the request.
 */
$hotelier_request_uri  = isset( $_SERVER['REQUEST_URI'] ) ? (string) $_SERVER['REQUEST_URI'] : '/';
$hotelier_request_path = (string) parse_url( $hotelier_request_uri, PHP_URL_PATH );

if ( preg_match( '#^/el(/.*)?$#', $hotelier_request_path, $hotelier_lang_m ) ) {
	define( 'HOTELIER_LANG_EL', true );
	// Rewrite REQUEST_URI so WordPress sees the real path (e.g. /about-us/).
	$hotelier_clean_path = isset( $hotelier_lang_m[1] ) && $hotelier_lang_m[1] !== '' ? $hotelier_lang_m[1] : '/';
	$hotelier_qs         = ! empty( $_SERVER['QUERY_STRING'] ) ? '?' . $_SERVER['QUERY_STRING'] : '';
	$_SERVER['REQUEST_URI'] = $hotelier_clean_path . $hotelier_qs;
}

/**
 * Returns the active front-end language: 'en' or 'el'.
 * Detection is based on the /el/ URL prefix (set at include time above).
 */
function hotelier_get_lang(): string {
	return defined( 'HOTELIER_LANG_EL' ) && HOTELIER_LANG_EL ? 'el' : 'en';
}

/**
 * Filter WordPress locale so .mo translations load for the active language.
 */
add_filter( 'locale', function ( string $locale ): string {
	return hotelier_get_lang() === 'el' ? 'el' : $locale;
} );

/**
 * Prepend /el/ to an internal URL when the active language is Greek.
 * Safe to call multiple times — will not double-prefix.
 */
function hotelier_localize_url( string $url ): string {
	if ( hotelier_get_lang() !== 'el' ) {
		return $url;
	}
	// Use the raw option to avoid triggering our own home_url filter.
	$home = trailingslashit( get_option( 'home' ) );
	if ( strpos( $url, $home ) === 0 && strpos( $url, $home . 'el/' ) !== 0 ) {
		return $home . 'el/' . substr( $url, strlen( $home ) );
	}
	return $url;
}

/**
 * Build the URL for switching to a specific language from the current page.
 *
 * @param string $target_lang 'en' or 'el'.
 */
function hotelier_lang_switcher_url( string $target_lang ): string {
	// Reconstruct the real request path (before our /el/ stripping).
	$home_path = rtrim( (string) parse_url( get_option( 'home' ), PHP_URL_PATH ), '/' );
	$req_path  = isset( $_SERVER['REQUEST_URI'] ) ? (string) parse_url( (string) $_SERVER['REQUEST_URI'], PHP_URL_PATH ) : '/';

	// The current clean path (without /el/ — since we already stripped it).
	$clean_path = $req_path;

	$base = trailingslashit( get_option( 'home' ) );
	if ( 'el' === $target_lang ) {
		return $base . 'el' . $clean_path;
	}
	return $base . ltrim( $clean_path, '/' );
}

/*
 * -----------------------------------------------------------------------
 * URL filters — ensure all internal links include /el/ when in Greek mode.
 * -----------------------------------------------------------------------
 */

// Page permalinks (covers get_permalink() for pages).
add_filter( 'page_link', function ( $url ) {
	return is_admin() ? $url : hotelier_localize_url( $url );
}, 20 );

// home_url() — ensures logo link, home references, etc.
add_filter( 'home_url', function ( $url ) {
	return is_admin() ? $url : hotelier_localize_url( $url );
}, 20 );

// Nav menu item URLs.
add_filter( 'wp_get_nav_menu_items', function ( $items ) {
	if ( is_admin() || hotelier_get_lang() !== 'el' ) {
		return $items;
	}
	foreach ( $items as $item ) {
		$item->url = hotelier_localize_url( $item->url );
	}
	return $items;
} );

// WordPress canonical redirects (trailing-slash fixes, etc.) — preserve /el/ prefix.
add_filter( 'redirect_canonical', function ( $redirect_url ) {
	return hotelier_localize_url( $redirect_url );
}, 20 );
