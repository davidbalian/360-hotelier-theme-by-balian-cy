<?php
/**
 * WordPress locale and html lang for path-prefix Greek.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hooks locale and language_attributes for front-end Greek.
 */
final class Hotelier_Locale_WordPress {

	public static function register(): void {
		add_filter( 'locale', array( self::class, 'filter_locale' ), 20 );
		add_filter( 'language_attributes', array( self::class, 'filter_language_attributes' ), 20, 1 );
	}

	public static function filter_locale( string $locale ): string {
		if ( is_admin() ) {
			return $locale;
		}

		if ( Hotelier_Locale_Detector::current_lang() === Hotelier_Locale_Registry::GREEK_LANG ) {
			return Hotelier_Locale_Registry::WP_LOCALE_GREEK;
		}

		return $locale;
	}

	/**
	 * @param string $output Space-prefixed attributes.
	 */
	public static function filter_language_attributes( string $output ): string {
		if ( is_admin() ) {
			return $output;
		}

		$lang = Hotelier_Locale_Registry::html_lang_attribute( Hotelier_Locale_Detector::current_lang() );
		if ( preg_match( '/\blang="[^"]*"/', $output ) ) {
			$replaced = preg_replace( '/\blang="[^"]*"/', 'lang="' . esc_attr( $lang ) . '"', $output, 1 );
			return is_string( $replaced ) ? $replaced : $output;
		}

		return ' lang="' . esc_attr( $lang ) . '"' . $output;
	}
}
