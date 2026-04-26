<?php
/**
 * Copies selected static files from the theme directory to the site web root (ABSPATH).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Syncs sitemap.xml, sitemap.xsl (browser styling), llms.txt, and Search Console HTML verification to the web root.
 */
final class Hotelier_Root_Public_Files_Sync {

	private const OPTION_VERSION_KEY = 'hotelier_root_public_files_ver';

	/**
	 * Basenames only; must exist in the theme root.
	 *
	 * @var string[]
	 */
	private static array $files = array(
		'sitemap.xml',
		'sitemap.xsl',
		'llms.txt',
		'google4b0a92ea0098601d.html',
	);

	public static function register(): void {
		add_action( 'after_switch_theme', array( self::class, 'sync' ) );
		add_action( 'admin_init', array( self::class, 'maybe_sync_on_version_change' ), 5 );
		add_action( 'upgrader_process_complete', array( self::class, 'on_upgrader_complete' ), 10, 2 );
	}

	/**
	 * Re-copy when HOTELIER_THEME_VERSION changes (e.g. manual theme deploy).
	 */
	public static function maybe_sync_on_version_change(): void {
		if ( get_option( self::OPTION_VERSION_KEY, '' ) === HOTELIER_THEME_VERSION ) {
			return;
		}
		self::sync();
	}

	/**
	 * After dashboard theme update for this template.
	 *
	 * @param WP_Upgrader $upgrader Upgrader instance.
	 * @param array       $options  Hook extra (type, action, themes, etc.).
	 */
	public static function on_upgrader_complete( $upgrader, array $options ): void {
		if ( ! isset( $options['action'], $options['type'] ) || 'update' !== $options['action'] || 'theme' !== $options['type'] ) {
			return;
		}
		$themes = isset( $options['themes'] ) ? (array) $options['themes'] : array();
		if ( ! in_array( get_template(), $themes, true ) ) {
			return;
		}
		self::sync();
	}

	/**
	 * Copy theme root static files to ABSPATH if readable and destination is writable.
	 */
	public static function sync(): void {
		$all_ok = true;

		foreach ( self::$files as $basename ) {
			$src = HOTELIER_THEME_DIR . '/' . $basename;
			$dst = ABSPATH . $basename;

			if ( ! is_readable( $src ) ) {
				$all_ok = false;
				continue;
			}

			if ( file_exists( $dst ) && ! wp_is_writable( $dst ) ) {
				$all_ok = false;
				continue;
			}

			if ( ! file_exists( $dst ) && ! wp_is_writable( ABSPATH ) ) {
				$all_ok = false;
				continue;
			}

			if ( ! @copy( $src, $dst ) ) {
				$all_ok = false;
			}
		}

		if ( $all_ok ) {
			update_option( self::OPTION_VERSION_KEY, HOTELIER_THEME_VERSION );
		}
	}
}
