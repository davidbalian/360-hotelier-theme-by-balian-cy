<?php
/**
 * One-time seed of homepage ACF image fields from schema default_url (attachment ID lookup).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Runs once per seed version after ACF registers local fields.
 */
final class Hotelier_Home_Image_Acf_Seeder {

	private const OPTION_KEY   = 'hotelier_home_image_acf_seed_version';
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

		$fields = Hotelier_Page_Meta_Schema::fields_for_context( 'home' );
		if ( ! $fields ) {
			return;
		}

		foreach ( Hotelier_Home_Image_Acf_Field::image_schema_keys() as $schema_key ) {
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
			self::seed_if_empty( $page_id, Hotelier_Home_Image_Acf_Field::field_name( $schema_key ), $attachment_id );
		}

		update_option( self::OPTION_KEY, self::SEED_VERSION, true );
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
