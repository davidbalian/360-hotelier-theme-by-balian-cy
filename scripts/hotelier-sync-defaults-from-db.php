#!/usr/bin/env php
<?php
/**
 * Regenerates inc/hotelier-db-defaults.sync.php from the current database.
 *
 * Usage (WordPress root, this theme active):
 *   php wp-content/themes/<theme-slug>/scripts/hotelier-sync-defaults-from-db.php
 *
 * Or in WP admin: Settings → Site content → “Download JSON export” (no server file write).
 *
 * Options:
 *   --dry-run              Print target path and counts only.
 *   --force                Allow write when WP_DEBUG is false (avoid accidental production writes).
 *   --skip-attachment-ids  Set footer_logo_id to 0 in generated site_content (portable across installs).
 *   --service-post-id=ID   Page ID to use for the "service" context when multiple service pages exist.
 *   --theme-dir=PATH       Theme root to walk upward from when locating wp-load.php (default: this theme directory).
 *
 * @package 360-hotelier
 */

/**
 * @param list<string> $args
 * @return array<string, mixed>
 */
function hotelier_sync_parse_cli_opts( array $args ): array {
	$out = array();
	foreach ( $args as $a ) {
		if ( '--dry-run' === $a ) {
			$out['dry-run'] = true;
			continue;
		}
		if ( '--force' === $a ) {
			$out['force'] = true;
			continue;
		}
		if ( '--skip-attachment-ids' === $a ) {
			$out['skip-attachment-ids'] = true;
			continue;
		}
		if ( preg_match( '/^--service-post-id=(\d+)$/', $a, $m ) ) {
			$out['service-post-id'] = (int) $m[1];
			continue;
		}
		if ( preg_match( '/^--theme-dir=(.+)$/', $a, $m ) ) {
			$out['theme-dir'] = $m[1];
			continue;
		}
	}
	return $out;
}

/**
 * @return string|null Absolute path to wp-load.php
 */
function hotelier_sync_find_wp_load( string $start_dir ): ?string {
	$dir = $start_dir;
	for ( $i = 0; $i < 12; $i++ ) {
		$candidate = $dir . '/wp-load.php';
		if ( is_readable( $candidate ) ) {
			return $candidate;
		}
		$parent = dirname( $dir );
		if ( $parent === $dir ) {
			break;
		}
		$dir = $parent;
	}
	return null;
}

if ( defined( 'ABSPATH' ) ) {
	return;
}

$theme_dir = dirname( __DIR__ );

$args = isset( $argv ) && is_array( $argv ) ? array_slice( $argv, 1 ) : array();
$opts = hotelier_sync_parse_cli_opts( $args );
if ( isset( $opts['theme-dir'] ) && is_string( $opts['theme-dir'] ) && $opts['theme-dir'] !== '' ) {
	$theme_dir = rtrim( $opts['theme-dir'], '/' );
}

$wp_load = hotelier_sync_find_wp_load( $theme_dir );
if ( ! is_string( $wp_load ) ) {
	fwrite( STDERR, "Could not find wp-load.php. Run from inside a WordPress install (theme under wp-content/themes).\n" );
	exit( 1 );
}

require_once $wp_load;

if ( ! class_exists( 'Hotelier_Site_Content_Options', false ) || ! class_exists( 'Hotelier_Page_Meta_Schema', false ) ) {
	fwrite( STDERR, "360 Hotelier theme classes not loaded. Activate this theme and run again.\n" );
	exit( 1 );
}

if ( defined( 'HOTELIER_THEME_DIR' ) && is_string( HOTELIER_THEME_DIR ) && HOTELIER_THEME_DIR !== '' ) {
	$theme_dir = HOTELIER_THEME_DIR;
}

$will_write = empty( $opts['dry-run'] );
if ( $will_write && ! ( defined( 'WP_DEBUG' ) && WP_DEBUG ) && empty( $opts['force'] ) ) {
	fwrite( STDERR, "Refusing to write: set WP_DEBUG true in wp-config.php, use --dry-run, or pass --force.\n" );
	exit( 1 );
}

require_once __DIR__ . '/class-hotelier-defaults-sync-runner.php';

$service_id = null;
if ( ! empty( $opts['service-post-id'] ) ) {
	$service_id = absint( $opts['service-post-id'] );
	if ( $service_id <= 0 ) {
		$service_id = null;
	}
}

$runner = new Hotelier_Defaults_Sync_Runner(
	$theme_dir,
	! empty( $opts['dry-run'] ),
	! empty( $opts['skip-attachment-ids'] ),
	$service_id
);
exit( $runner->run() );
