<?php
/**
 * hreflang, canonical, and front-end canonical URL helper.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * SEO tags for path-prefix locales.
 */
final class Hotelier_Locale_Seo {

	public static function register(): void {
		add_action( 'wp_head', array( self::class, 'output_hreflang_and_canonical' ), 2 );
	}

	public static function output_hreflang_and_canonical(): void {
		if ( is_admin() ) {
			return;
		}

		$logical = Hotelier_Locale_Detector::logical_path_without_lang_prefix();
		$trim    = trim( $logical, '/' );

		$url_en = home_url( user_trailingslashit( Hotelier_Local_Urls::relative_path_for( $trim, Hotelier_Locale_Registry::DEFAULT_LANG ) ) );
		$url_el = home_url( user_trailingslashit( Hotelier_Local_Urls::relative_path_for( $trim, Hotelier_Locale_Registry::GREEK_LANG ) ) );

		echo '<link rel="alternate" hreflang="en" href="' . esc_url( $url_en ) . '" />' . "\n";
		echo '<link rel="alternate" hreflang="el" href="' . esc_url( $url_el ) . '" />' . "\n";
		echo '<link rel="alternate" hreflang="x-default" href="' . esc_url( $url_en ) . '" />' . "\n";

		$current = self::current_canonical_url();
		if ( '' !== $current ) {
			echo '<link rel="canonical" href="' . esc_url( $current ) . '" />' . "\n";
		}
	}

	public static function current_canonical_url(): string {
		$logical = Hotelier_Locale_Detector::logical_path_without_lang_prefix();
		$trim    = trim( $logical, '/' );
		$lang    = Hotelier_Locale_Detector::current_lang();
		$base    = home_url( user_trailingslashit( Hotelier_Local_Urls::relative_path_for( $trim, $lang ) ) );

		$uri   = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
		$query = wp_parse_url( $uri, PHP_URL_QUERY );
		$q     = is_string( $query ) && '' !== $query ? '?' . $query : '';

		return $base . $q;
	}
}
