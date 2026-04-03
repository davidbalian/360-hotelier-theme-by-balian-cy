<?php
/**
 * Supported path-prefix locales (single source of truth).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registry for path-prefix language codes.
 */
final class Hotelier_Locale_Registry {

	public const DEFAULT_LANG = 'en';

	public const GREEK_LANG = 'el';

	public const WP_LOCALE_GREEK = 'el_GR';

	public const QUERY_VAR = 'hotelier_lang';

	public const REWRITE_VERSION = '1';

	/**
	 * @return string[]
	 */
	public static function supported_codes(): array {
		return array( self::DEFAULT_LANG, self::GREEK_LANG );
	}

	public static function is_supported_code( string $code ): bool {
		return in_array( $code, self::supported_codes(), true );
	}

	/**
	 * Languages that use a URL prefix (not default).
	 *
	 * @return string[]
	 */
	public static function prefixed_codes(): array {
		return array( self::GREEK_LANG );
	}

	public static function uses_path_prefix( string $code ): bool {
		return self::DEFAULT_LANG !== $code && self::is_supported_code( $code );
	}

	/**
	 * Leading path segment without slashes, e.g. "el", or empty for default.
	 */
	public static function path_prefix_segment( string $code ): string {
		return self::uses_path_prefix( $code ) ? $code : '';
	}

	public static function html_lang_attribute( string $code ): string {
		return self::GREEK_LANG === $code ? 'el' : 'en';
	}

	public static function wordpress_locale_for( string $code ): string {
		return self::GREEK_LANG === $code ? self::WP_LOCALE_GREEK : 'en_US';
	}
}
