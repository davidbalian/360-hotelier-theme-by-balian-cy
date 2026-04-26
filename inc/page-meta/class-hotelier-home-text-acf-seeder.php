<?php
/**
 * One-time seed of homepage ACF text fields from schema + Greek defaults.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Runs once per seed version after ACF registers local fields.
 */
final class Hotelier_Home_Text_Acf_Seeder {

	private const OPTION_KEY   = 'hotelier_home_text_acf_seed_version';
	private const SEED_VERSION = 1;

	public static function register(): void {
		add_action( 'acf/init', array( self::class, 'maybe_seed' ), 20 );
	}

	public static function maybe_seed(): void {
		if ( ! function_exists( 'update_field' ) ) {
			return;
		}

		if ( (int) get_option( self::OPTION_KEY, 0 ) >= self::SEED_VERSION ) {
			return;
		}

		$page_id = Hotelier_Page_Content::front_page_id();
		if ( $page_id <= 0 ) {
			return;
		}

		foreach ( Hotelier_Home_Text_Acf_Field::text_schema_keys() as $schema_key ) {
			self::seed_if_empty( $page_id, Hotelier_Home_Text_Acf_Field::field_name( $schema_key, 'en' ), Hotelier_Home_Text_Acf_Field::english_default_for_key( $schema_key ) );
			self::seed_if_empty( $page_id, Hotelier_Home_Text_Acf_Field::field_name( $schema_key, 'el' ), Hotelier_Home_Text_Acf_Field::greek_default_for_key( $schema_key ) );
		}

		update_option( self::OPTION_KEY, self::SEED_VERSION, true );
	}

	private static function seed_if_empty( int $page_id, string $field_name, string $value ): void {
		if ( '' === trim( $value ) ) {
			return;
		}

		$current = '';
		if ( function_exists( 'get_field' ) ) {
			$raw = get_field( $field_name, $page_id, false );
			if ( null !== $raw && false !== $raw ) {
				$current = trim( (string) $raw );
			}
		}

		if ( '' !== $current ) {
			return;
		}

		update_field( $field_name, $value, $page_id );
	}
}
