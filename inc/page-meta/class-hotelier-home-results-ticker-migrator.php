<?php
/**
 * One-time force migration of homepage results ticker logos to match portfolio order.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Overwrites front-page results_tick_* image and alt fields from home schema defaults.
 */
final class Hotelier_Home_Results_Ticker_Migrator {

	private const OPTION_KEY    = 'hotelier_home_results_ticker_migrate_version';
	private const MIGRATE_VERSION = 1;

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

		if ( ! defined( 'HOTELIER_HOME_RESULTS_TICKER_COUNT' ) ) {
			Hotelier_Page_Meta_Schema::fields_for_context( 'home' );
		}

		$page_id = Hotelier_Page_Content::front_page_id();
		if ( $page_id <= 0 ) {
			return;
		}

		self::migrate_page( $page_id );

		update_option( self::OPTION_KEY, self::MIGRATE_VERSION, true );
	}

	private static function migrate_page( int $page_id ): void {
		$fields = Hotelier_Page_Meta_Schema::fields_for_context( 'home' );
		if ( ! $fields ) {
			return;
		}

		for ( $i = 1; $i <= HOTELIER_HOME_RESULTS_TICKER_COUNT; $i++ ) {
			$image_key = 'results_tick_' . $i;
			$alt_key   = 'results_tick_' . $i . '_alt';

			if ( isset( $fields[ $image_key ]['default_url'] ) ) {
				$url = trim( (string) $fields[ $image_key ]['default_url'] );
				if ( '' !== $url ) {
					$attachment_id = attachment_url_to_postid( $url );
					if ( $attachment_id > 0 ) {
						update_field(
							Hotelier_Home_Image_Acf_Field::field_name( $image_key ),
							$attachment_id,
							$page_id
						);
					}
				}
			}

			self::force_alt( $page_id, $alt_key, 'en', Hotelier_Home_Text_Acf_Field::english_default_for_key( $alt_key ) );
			self::force_alt( $page_id, $alt_key, 'el', Hotelier_Home_Text_Acf_Field::greek_default_for_key( $alt_key ) );
		}
	}

	private static function force_alt( int $page_id, string $schema_key, string $lang, string $value ): void {
		if ( ! Hotelier_Home_Text_Acf_Field::is_text_schema_field( $schema_key ) ) {
			return;
		}

		update_field(
			Hotelier_Home_Text_Acf_Field::field_name( $schema_key, $lang ),
			$value,
			$page_id
		);
	}
}
