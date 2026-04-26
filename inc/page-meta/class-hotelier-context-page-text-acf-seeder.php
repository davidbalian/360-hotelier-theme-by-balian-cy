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
	private const SEED_VERSION = 4;

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

		self::migrate_legacy_404_site_content_into_acf();

		foreach ( Hotelier_Context_Page_Text_Acf_Field::managed_contexts() as $context ) {
			if ( 'service' === $context ) {
				self::seed_service_pages_text();
				continue;
			}
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

	/**
	 * Copies former Settings → Site content 404 strings into EN ACF when still empty.
	 */
	private static function migrate_legacy_404_site_content_into_acf(): void {
		if ( ! class_exists( 'Hotelier_Site_Content_Options' ) ) {
			return;
		}
		$raw = get_option( Hotelier_Site_Content_Options::OPTION_NAME, array() );
		if ( ! is_array( $raw ) ) {
			return;
		}
		$pairs = array(
			'error_title' => 'error_title',
			'error_text'  => 'error_text',
			'error_btn'   => 'error_btn',
		);
		foreach ( Hotelier_Context_Page_Text_Acf_Field::page_ids_for_context( 'error_404' ) as $page_id ) {
			if ( $page_id <= 0 ) {
				continue;
			}
			foreach ( $pairs as $option_key => $schema_key ) {
				if ( ! isset( $raw[ $option_key ] ) ) {
					continue;
				}
				$val = trim( (string) $raw[ $option_key ] );
				if ( '' === $val ) {
					continue;
				}
				self::seed_if_empty(
					$page_id,
					Hotelier_Context_Page_Text_Acf_Field::field_name( 'error_404', $schema_key, 'en' ),
					$val
				);
			}
		}
	}

	private static function seed_service_pages_text(): void {
		if ( ! class_exists( 'Hotelier_Service_Single_Defaults' ) ) {
			return;
		}
		foreach ( Hotelier_Context_Page_Text_Acf_Field::page_ids_for_context( 'service' ) as $page_id ) {
			if ( $page_id <= 0 ) {
				continue;
			}
			$slug = (string) get_post_field( 'post_name', $page_id, 'raw' );
			$en   = Hotelier_Service_Single_Defaults::seed_text_fields_en( $slug );
			$el   = Hotelier_Service_Single_Defaults::seed_text_fields_el( $slug );
			if ( ! is_array( $en ) || ! is_array( $el ) ) {
				continue;
			}
			foreach ( $en as $schema_key => $value ) {
				if ( ! Hotelier_Context_Page_Text_Acf_Field::is_managed_text_field( 'service', (string) $schema_key ) ) {
					continue;
				}
				self::seed_if_empty(
					$page_id,
					Hotelier_Context_Page_Text_Acf_Field::field_name( 'service', (string) $schema_key, 'en' ),
					(string) $value
				);
			}
			foreach ( $el as $schema_key => $value ) {
				if ( ! Hotelier_Context_Page_Text_Acf_Field::is_managed_text_field( 'service', (string) $schema_key ) ) {
					continue;
				}
				self::seed_if_empty(
					$page_id,
					Hotelier_Context_Page_Text_Acf_Field::field_name( 'service', (string) $schema_key, 'el' ),
					(string) $value
				);
			}
		}
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
