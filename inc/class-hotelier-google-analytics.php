<?php
/**
 * Google Analytics (gtag.js) — single enqueue for all public templates.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers gtag on the front end via wp_enqueue_script (no per-template duplication).
 */
final class Hotelier_Google_Analytics {

	private const MEASUREMENT_ID = 'G-L5R0FDMHZE';

	private const SCRIPT_HANDLE = 'hotelier-google-gtag';

	public static function register(): void {
		add_action( 'wp_enqueue_scripts', array( self::class, 'enqueue' ), 5 );
	}

	public static function enqueue(): void {
		if ( is_admin() ) {
			return;
		}

		$url = 'https://www.googletagmanager.com/gtag/js?id=' . rawurlencode( self::MEASUREMENT_ID );

		wp_enqueue_script(
			self::SCRIPT_HANDLE,
			$url,
			array(),
			null,
			false
		);

		wp_script_add_data( self::SCRIPT_HANDLE, 'strategy', 'async' );

		$inline = sprintf(
			"window.dataLayer = window.dataLayer || [];\nfunction gtag(){dataLayer.push(arguments);}\ngtag('js', new Date());\ngtag('config', '%s');",
			esc_js( self::MEASUREMENT_ID )
		);

		wp_add_inline_script( self::SCRIPT_HANDLE, $inline, 'after' );
	}
}
