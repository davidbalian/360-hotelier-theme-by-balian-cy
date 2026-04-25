<?php
/**
 * One-time seed of ACF SEO fields from theme defaults (only fills empty values).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Runs once per theme seed version after ACF registers local fields.
 */
final class Hotelier_Seo_Meta_Seeder {

	private const OPTION_KEY   = 'hotelier_seo_meta_seed_version';
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

		$ids = self::collect_managed_page_ids();
		foreach ( $ids as $page_id ) {
			self::seed_page( (int) $page_id );
		}

		update_option( self::OPTION_KEY, self::SEED_VERSION, true );
	}

	/**
	 * @return int[]
	 */
	private static function collect_managed_page_ids(): array {
		$ids = array();

		if ( 'page' === (string) get_option( 'show_on_front' ) ) {
			$front = (int) get_option( 'page_on_front' );
			if ( $front > 0 ) {
				$ids[] = $front;
			}
		}

		$templates = array(
			'page-templates/template-founder.php',
			'page-templates/template-about.php',
			'page-templates/template-portfolio.php',
			'page-templates/template-contact.php',
			'page-templates/template-services.php',
			'page-templates/template-service-single.php',
		);

		foreach ( $templates as $tpl ) {
			$found = get_posts(
				array(
					'post_type'      => 'page',
					'post_status'    => 'any',
					'posts_per_page' => -1,
					'fields'         => 'ids',
					'meta_key'       => '_wp_page_template',
					'meta_value'     => $tpl,
				)
			);
			foreach ( $found as $pid ) {
				$ids[] = (int) $pid;
			}
		}

		foreach ( array( 'privacy-policy', 'cookie-policy', 'terms' ) as $slug ) {
			$legal = get_posts(
				array(
					'post_type'      => 'page',
					'name'           => $slug,
					'post_status'    => 'any',
					'posts_per_page' => 1,
					'fields'         => 'ids',
				)
			);
			if ( ! empty( $legal[0] ) ) {
				$ids[] = (int) $legal[0];
			}
		}

		$ids = array_values( array_unique( array_filter( array_map( 'intval', $ids ) ) ) );

		return array_values(
			array_filter(
				$ids,
				static function ( int $id ): bool {
					return null !== Hotelier_Seo_Context::for_page_id( $id );
				}
			)
		);
	}

	private static function seed_page( int $page_id ): void {
		$context = Hotelier_Seo_Context::for_page_id( $page_id );
		if ( null === $context ) {
			return;
		}

		$pair = Hotelier_Seo_Defaults::bilingual_pair( $context );
		if ( null === $pair ) {
			return;
		}

		self::seed_if_empty( $page_id, Hotelier_Seo_Meta_Field::FIELD_TITLE_EN, $pair['en']['title'] );
		self::seed_if_empty( $page_id, Hotelier_Seo_Meta_Field::FIELD_DESCRIPTION_EN, $pair['en']['description'] );
		self::seed_if_empty( $page_id, Hotelier_Seo_Meta_Field::FIELD_TITLE_EL, $pair['el']['title'] );
		self::seed_if_empty( $page_id, Hotelier_Seo_Meta_Field::FIELD_DESCRIPTION_EL, $pair['el']['description'] );
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
