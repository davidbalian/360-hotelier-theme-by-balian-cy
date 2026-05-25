<?php
/**
 * One-time force migration of portfolio page ACF content from schema defaults.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Overwrites portfolio text, hotel images, and SEO fields on deploy.
 */
final class Hotelier_Portfolio_Content_Migrator {

	private const OPTION_KEY     = 'hotelier_portfolio_content_migrate_version';
	private const MIGRATE_VERSION  = 3;
	private const CONTEXT          = 'portfolio';

	/** @var string[] */
	private const INTRO_TEXT_KEYS = array( 'intro_h2', 'intro_p1', 'intro_p2', 'intro_p3' );

	/** @var string[] */
	private const HOTEL_TEXT_KEYS = array( 'name', 'location', 'url', 'alt', 'variant', 'tagline' );

	/** @var string[] */
	private const HOTEL_IMAGE_SUFFIXES = array( 'logo', 'photo' );

	public static function register(): void {
		add_action( 'acf/init', array( self::class, 'maybe_migrate' ), 25 );
	}

	public static function maybe_migrate(): void {
		if ( ! function_exists( 'update_field' ) ) {
			return;
		}

		if ( (int) get_option( self::OPTION_KEY, 0 ) >= self::MIGRATE_VERSION ) {
			return;
		}

		if ( ! defined( 'HOTELIER_PORTFOLIO_HOTEL_COUNT' ) ) {
			Hotelier_Page_Meta_Schema::fields_for_context( self::CONTEXT );
		}

		foreach ( Hotelier_Context_Page_Text_Acf_Field::page_ids_for_context( self::CONTEXT ) as $page_id ) {
			if ( $page_id <= 0 ) {
				continue;
			}
			self::migrate_page( $page_id );
		}

		update_option( self::OPTION_KEY, self::MIGRATE_VERSION, true );
	}

	private static function migrate_page( int $page_id ): void {
		self::migrate_intro_text( $page_id );
		self::migrate_hotel_text( $page_id );
		self::clear_hotel_images( $page_id );
		self::migrate_hotel_images( $page_id );
		self::migrate_seo( $page_id );
	}

	private static function migrate_intro_text( int $page_id ): void {
		foreach ( self::INTRO_TEXT_KEYS as $schema_key ) {
			self::force_text( $page_id, $schema_key, 'en', Hotelier_Context_Page_Text_Acf_Field::english_default_for_key( self::CONTEXT, $schema_key ) );
			self::force_text( $page_id, $schema_key, 'el', Hotelier_Context_Page_Text_Acf_Field::greek_default_for_key( self::CONTEXT, $schema_key ) );
		}
	}

	private static function migrate_hotel_text( int $page_id ): void {
		for ( $i = 1; $i <= HOTELIER_PORTFOLIO_HOTEL_COUNT; $i++ ) {
			foreach ( self::HOTEL_TEXT_KEYS as $suffix ) {
				$schema_key = 'hotel_' . $i . '_' . $suffix;
				self::force_text( $page_id, $schema_key, 'en', Hotelier_Context_Page_Text_Acf_Field::english_default_for_key( self::CONTEXT, $schema_key ) );
				self::force_text( $page_id, $schema_key, 'el', Hotelier_Context_Page_Text_Acf_Field::greek_default_for_key( self::CONTEXT, $schema_key ) );
			}
		}
	}

	private static function clear_hotel_images( int $page_id ): void {
		for ( $i = 1; $i <= HOTELIER_PORTFOLIO_HOTEL_COUNT; $i++ ) {
			foreach ( self::HOTEL_IMAGE_SUFFIXES as $suffix ) {
				$field_name = Hotelier_Context_Page_Image_Acf_Field::field_name( self::CONTEXT, 'hotel_' . $i . '_' . $suffix );
				if ( function_exists( 'delete_field' ) ) {
					delete_field( $field_name, $page_id );
				}
			}
		}

		self::delete_orphaned_hotel_image_meta( $page_id );
	}

	private static function delete_orphaned_hotel_image_meta( int $page_id ): void {
		global $wpdb;
		if ( ! isset( $wpdb ) || $page_id <= 0 ) {
			return;
		}

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$wpdb->query(
			$wpdb->prepare(
				"DELETE FROM {$wpdb->postmeta}
				WHERE post_id = %d
				AND meta_key REGEXP %s",
				$page_id,
				'^hotelier_portfolio_hotel_(1[1-9]|[2-9][0-9]+)_(logo|photo)$'
			)
		);
	}

	private static function migrate_hotel_images( int $page_id ): void {
		$fields = Hotelier_Page_Meta_Schema::fields_for_context( self::CONTEXT );
		if ( ! $fields ) {
			return;
		}

		for ( $i = 1; $i <= HOTELIER_PORTFOLIO_HOTEL_COUNT; $i++ ) {
			foreach ( self::HOTEL_IMAGE_SUFFIXES as $suffix ) {
				$schema_key = 'hotel_' . $i . '_' . $suffix;
				if ( ! isset( $fields[ $schema_key ]['default_url'] ) ) {
					continue;
				}
				$url = trim( (string) $fields[ $schema_key ]['default_url'] );
				if ( '' === $url ) {
					continue;
				}

				$attachment_id = Hotelier_Attachment_Lookup::id_from_url( $url );
				if ( $attachment_id <= 0 ) {
					continue;
				}

				update_field(
					Hotelier_Context_Page_Image_Acf_Field::field_name( self::CONTEXT, $schema_key ),
					$attachment_id,
					$page_id
				);
			}
		}
	}

	private static function migrate_seo( int $page_id ): void {
		$pair = Hotelier_Seo_Defaults::bilingual_pair( self::CONTEXT );
		if ( ! is_array( $pair ) ) {
			return;
		}

		update_field( Hotelier_Seo_Meta_Field::FIELD_TITLE_EN, $pair['en']['title'], $page_id );
		update_field( Hotelier_Seo_Meta_Field::FIELD_DESCRIPTION_EN, $pair['en']['description'], $page_id );
		update_field( Hotelier_Seo_Meta_Field::FIELD_TITLE_EL, $pair['el']['title'], $page_id );
		update_field( Hotelier_Seo_Meta_Field::FIELD_DESCRIPTION_EL, $pair['el']['description'], $page_id );
	}

	private static function force_text( int $page_id, string $schema_key, string $lang, string $value ): void {
		if ( ! Hotelier_Context_Page_Text_Acf_Field::is_managed_text_field( self::CONTEXT, $schema_key ) ) {
			return;
		}

		update_field(
			Hotelier_Context_Page_Text_Acf_Field::field_name( self::CONTEXT, $schema_key, $lang ),
			$value,
			$page_id
		);
	}
}
