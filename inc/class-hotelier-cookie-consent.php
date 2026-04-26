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

	/** @deprecated Retained for migration in cookie-consent.js only. */
	public const STORAGE_KEY = 'hotelier_cookies_accepted';

	/** localStorage: `analytics` | `essential` — banner hidden when set. */
	public const CHOICE_STORAGE_KEY = 'hotelier_cookie_banner_choice';

	/** HTTP cookie read by PHP to enqueue gtag only after Accept. */
	public const ANALYTICS_CONSENT_COOKIE_NAME = 'hotelier_ga_consent';

	public const ANALYTICS_CONSENT_COOKIE_VALUE = '1';

	public static function register(): void {
		add_action( 'wp_enqueue_scripts', array( self::class, 'enqueue_script' ), 20 );
	}

	/**
	 * Whether the visitor has opted in to analytics (server-visible cookie).
	 */
	public static function has_analytics_consent(): bool {
		if ( empty( $_COOKIE[ self::ANALYTICS_CONSENT_COOKIE_NAME ] ) ) {
			return false;
		}

		$raw = sanitize_text_field( wp_unslash( $_COOKIE[ self::ANALYTICS_CONSENT_COOKIE_NAME ] ) );

		return self::ANALYTICS_CONSENT_COOKIE_VALUE === $raw;
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
				'bannerId'              => self::BANNER_ID,
				'choiceStorageKey'      => self::CHOICE_STORAGE_KEY,
				'legacyStorageKey'      => self::STORAGE_KEY,
				'analyticsCookieName'   => self::ANALYTICS_CONSENT_COOKIE_NAME,
				'analyticsCookieValue'  => self::ANALYTICS_CONSENT_COOKIE_VALUE,
				'analyticsCookieMaxAge' => YEAR_IN_SECONDS,
				'measurementId'         => Hotelier_Google_Analytics::measurement_id(),
			)
		);
	}
}
