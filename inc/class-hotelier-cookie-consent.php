<?php
/**
 * Cookie consent banner — script registration and configuration.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues cookie banner script and passes DOM / storage identifiers to JS.
 */
final class Hotelier_Cookie_Consent {

	public const BANNER_ID = 'hotelier-cookie-banner';

	public const STORAGE_KEY = 'hotelier_cookies_accepted';

	public static function register(): void {
		add_action( 'wp_enqueue_scripts', array( self::class, 'enqueue_script' ), 20 );
	}

	public static function enqueue_script(): void {
		wp_enqueue_script(
			'360-hotelier-cookie-consent',
			HOTELIER_THEME_URI . '/assets/js/cookie-consent.js',
			array(),
			HOTELIER_THEME_VERSION,
			true
		);

		wp_localize_script(
			'360-hotelier-cookie-consent',
			'hotelierCookieConsent',
			array(
				'bannerId'   => self::BANNER_ID,
				'storageKey' => self::STORAGE_KEY,
			)
		);
	}
}
