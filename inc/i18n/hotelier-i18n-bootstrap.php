<?php
/**
 * Path-prefix locale bootstrap (English default, Greek /el/).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/class-hotelier-locale-registry.php';
require_once __DIR__ . '/class-hotelier-locale-detector.php';
require_once __DIR__ . '/class-hotelier-local-urls.php';
require_once __DIR__ . '/class-hotelier-locale-routing.php';
require_once __DIR__ . '/class-hotelier-locale-wordpress.php';
require_once __DIR__ . '/class-hotelier-locale-seo.php';
require_once __DIR__ . '/class-hotelier-lang-switcher-menu.php';
require_once __DIR__ . '/class-hotelier-greek-nav-sync.php';
require_once HOTELIER_THEME_DIR . '/inc/translations/el/class-hotelier-el-page-defaults.php';

/**
 * Active short language code for the request (en | el).
 */
function hotelier_get_current_lang(): string {
	return Hotelier_Locale_Detector::current_lang();
}

/**
 * Home URL with optional path segment, using current language prefix.
 */
function hotelier_get_localized_home_url( string $path = '' ): string {
	return Hotelier_Local_Urls::localized_home_url( $path );
}

/**
 * Same path as current request in another language.
 */
function hotelier_lang_url( string $target_lang ): string {
	return Hotelier_Local_Urls::lang_url( $target_lang );
}

/**
 * Prefix internal absolute URL for current language.
 */
function hotelier_localize_internal_url( string $url ): string {
	return Hotelier_Local_Urls::localize_internal_url( $url );
}

/**
 * Registers all path-prefix locale hooks.
 */
function hotelier_register_path_locale(): void {
	Hotelier_Locale_Routing::register();
	Hotelier_Locale_WordPress::register();
	Hotelier_Locale_Seo::register();
	Hotelier_Lang_Switcher_Menu::register();
}

/**
 * Custom logo markup with home URL including current language prefix.
 */
function hotelier_output_custom_logo_link(): void {
	$logo_id = (int) get_theme_mod( 'custom_logo' );
	if ( $logo_id <= 0 ) {
		return;
	}

	printf(
		'<a href="%1$s" class="custom-logo-link" rel="home" itemprop="url">%2$s</a>',
		esc_url( hotelier_get_localized_home_url() ),
		wp_get_attachment_image(
			$logo_id,
			'full',
			false,
			array(
				'class'    => 'custom-logo',
				'itemprop' => 'logo',
			)
		)
	);
}

/**
 * Greek site-content strings when option values still match built-in English defaults.
 *
 * @param array<string, mixed> $content Merged defaults + stored options.
 * @return array<string, mixed>
 */
function hotelier_filter_site_content_el( array $content ): array {
	if ( ! function_exists( 'hotelier_get_current_lang' ) || 'el' !== hotelier_get_current_lang() ) {
		return $content;
	}

	$file = HOTELIER_THEME_DIR . '/inc/translations/el/site-content-overrides.php';
	if ( ! is_readable( $file ) ) {
		return $content;
	}

	$overrides = require $file;
	if ( ! is_array( $overrides ) ) {
		return $content;
	}

	$defaults = Hotelier_Site_Content_Options::builtin_defaults();
	foreach ( $overrides as $key => $greek ) {
		if ( ! isset( $content[ $key ], $defaults[ $key ] ) ) {
			continue;
		}
		if ( (string) $content[ $key ] === (string) $defaults[ $key ] ) {
			$content[ $key ] = $greek;
		}
	}

	return $content;
}

add_filter( 'hotelier_site_content', 'hotelier_filter_site_content_el', 10, 1 );

hotelier_register_path_locale();
