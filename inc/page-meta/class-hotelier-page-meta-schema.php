<?php
/**
 * Page content schema: contexts and field definitions.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Schema registry for hardcoded page content.
 */
final class Hotelier_Page_Meta_Schema {

	/**
	 * @return array<string, array<string, mixed>>
	 */
	public static function baseline_contexts(): array {
		$dir = __DIR__ . '/schema/';
		return array(
			'home'      => require $dir . 'schema-home.php',
			'about'     => require $dir . 'schema-about.php',
			'services'  => require $dir . 'schema-services.php',
			'service'   => require $dir . 'schema-service.php',
			'portfolio' => require $dir . 'schema-portfolio.php',
			'contact'   => require $dir . 'schema-contact.php',
			'founder'   => require $dir . 'schema-founder.php',
		);
	}

	/**
	 * @return array<string, array<string, mixed>>
	 */
	public static function all_contexts(): array {
		static $cache = null;
		if ( null !== $cache ) {
			return $cache;
		}
		$cache = self::baseline_contexts();
		return $cache;
	}

	/**
	 * @return array<string, mixed>|null
	 */
	public static function fields_for_context( string $context ): ?array {
		$all = self::all_contexts();
		return isset( $all[ $context ] ) ? $all[ $context ] : null;
	}

	/**
	 * ACF tab label for a portfolio hotel slot (e.g. hotel_1): schema default name or "Hotel N".
	 */
	public static function portfolio_hotel_tab_label( string $tab_id ): string {
		if ( ! preg_match( '/^hotel_(\d+)$/', $tab_id, $m ) ) {
			return $tab_id;
		}
		$n      = (int) $m[1];
		$fields = self::fields_for_context( 'portfolio' );
		$key    = 'hotel_' . $n . '_name';
		if ( $fields && isset( $fields[ $key ]['default'] ) ) {
			$name = trim( (string) $fields[ $key ]['default'] );
			if ( $name !== '' ) {
				return $name;
			}
		}
		return sprintf(
			/* translators: %d: hotel slot number */
			__( 'Hotel %d', '360-hotelier' ),
			$n
		);
	}
}
