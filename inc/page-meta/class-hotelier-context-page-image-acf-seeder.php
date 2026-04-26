<?php
/**
 * One-time seed of inner-page ACF image fields from schema default_url.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Runs once per seed version after ACF registers local fields.
 */
final class Hotelier_Context_Page_Image_Acf_Seeder {

	private const OPTION_KEY   = 'hotelier_context_page_image_acf_seed_version';
	private const SEED_VERSION = 3;

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
			$fields = Hotelier_Page_Meta_Schema::fields_for_context( $context );
			if ( ! $fields ) {
				continue;
			}

			foreach ( Hotelier_Context_Page_Text_Acf_Field::page_ids_for_context( $context ) as $page_id ) {
				if ( $page_id <= 0 ) {
					continue;
				}
				foreach ( Hotelier_Context_Page_Image_Acf_Field::image_schema_keys( $context ) as $schema_key ) {
					if ( ! isset( $fields[ $schema_key ]['default_url'] ) ) {
						continue;
					}
					$url = trim( (string) $fields[ $schema_key ]['default_url'] );
					if ( '' === $url ) {
						continue;
					}
					$attachment_id = attachment_url_to_postid( $url );
					if ( $attachment_id <= 0 ) {
						continue;
					}
					self::seed_if_empty( $page_id, Hotelier_Context_Page_Image_Acf_Field::field_name( $context, $schema_key ), $attachment_id );
				}
			}
		}

		self::seed_service_overview_images();

		update_option( self::OPTION_KEY, self::SEED_VERSION, true );
	}

	private static function seed_service_overview_images(): void {
		if ( ! class_exists( 'Hotelier_Service_Single_Defaults' ) ) {
			return;
		}
		foreach ( Hotelier_Context_Page_Text_Acf_Field::page_ids_for_context( 'service' ) as $page_id ) {
			if ( $page_id <= 0 ) {
				continue;
			}
			$slug = (string) get_post_field( 'post_name', $page_id, 'raw' );
			$url  = Hotelier_Service_Single_Defaults::default_overview_image_url( $slug );
			if ( '' === $url ) {
				continue;
			}
			$attachment_id = attachment_url_to_postid( $url );
			if ( $attachment_id <= 0 ) {
				continue;
			}
			self::seed_if_empty( $page_id, Hotelier_Context_Page_Image_Acf_Field::field_name( 'service', 'overview_img' ), $attachment_id );
		}
	}

	/**
	 * @param int $value Attachment ID.
	 */
	private static function seed_if_empty( int $page_id, string $field_name, int $value ): void {
		if ( $value <= 0 ) {
			return;
		}

		$has_value = false;
		if ( function_exists( 'get_field' ) ) {
			$raw = get_field( $field_name, $page_id, false );
			if ( null !== $raw && false !== $raw && '' !== $raw && '0' !== (string) $raw ) {
				$has_value = true;
			}
		}

		if ( $has_value ) {
			return;
		}

		update_field( $field_name, $value, $page_id );
	}
}
