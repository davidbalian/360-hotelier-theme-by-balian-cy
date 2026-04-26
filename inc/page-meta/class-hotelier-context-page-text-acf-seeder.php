<?php
/**
 * One-time seed of inner-page ACF text fields from schema + Greek defaults.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Runs once per seed version after ACF registers local fields.
 */
final class Hotelier_Context_Page_Text_Acf_Seeder {

	private const OPTION_KEY   = 'hotelier_context_page_text_acf_seed_version';
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

		foreach ( Hotelier_Context_Page_Text_Acf_Field::managed_contexts() as $context ) {
			foreach ( Hotelier_Context_Page_Text_Acf_Field::page_ids_for_context( $context ) as $page_id ) {
				if ( $page_id <= 0 ) {
					continue;
				}
				foreach ( Hotelier_Context_Page_Text_Acf_Field::text_schema_keys( $context ) as $schema_key ) {
					self::seed_if_empty(
						$page_id,
						Hotelier_Context_Page_Text_Acf_Field::field_name( $context, $schema_key, 'en' ),
						Hotelier_Context_Page_Text_Acf_Field::english_default_for_key( $context, $schema_key )
					);
					self::seed_if_empty(
						$page_id,
						Hotelier_Context_Page_Text_Acf_Field::field_name( $context, $schema_key, 'el' ),
						Hotelier_Context_Page_Text_Acf_Field::greek_default_for_key( $context, $schema_key )
					);
				}
			}
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
