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
		// WP 5.0+ uses determine_locale() for gettext / JIT loading; locale filter alone is not always enough.
		add_filter( 'determine_locale', array( self::class, 'filter_determine_locale' ), 99 );
		add_filter( 'locale', array( self::class, 'filter_locale' ), 99 );
		add_filter( 'language_attributes', array( self::class, 'filter_language_attributes' ), 20, 1 );
		add_action( 'wp', array( self::class, 'action_wp_reload_theme_textdomain' ), 0 );
	}

	/**
	 * Force theme (and script) translation loading to use el_GR on Greek URLs.
	 *
	 * @param string $locale Locale determined by WordPress.
	 */
	public static function filter_determine_locale( string $locale ): string {
		if ( is_admin() ) {
			return $locale;
		}

		if ( Hotelier_Locale_Detector::current_lang() === Hotelier_Locale_Registry::GREEK_LANG ) {
			return Hotelier_Locale_Registry::WP_LOCALE_GREEK;
		}

		return $locale;
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
	 * WP 6.7+ JIT text domains may resolve before the main query; reload after wp so el_GR.mo is used.
	 */
	public static function action_wp_reload_theme_textdomain(): void {
		if ( is_admin() ) {
			return;
		}

		if ( Hotelier_Locale_Detector::current_lang() !== Hotelier_Locale_Registry::GREEK_LANG ) {
			return;
		}

		$domain = '360-hotelier';
		$path   = get_template_directory() . '/languages';

		unload_textdomain( $domain, true );
		load_theme_textdomain( $domain, $path );
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
