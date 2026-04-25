<?php
/**
 * ACF-backed hero background image field for hotelier pages.
 *
 * Single responsibility: register one ACF Local Field Group that adds a
 * "Hero background image" picker to every page that has a hero section,
 * and resolve the final hero image URL with two extra rules:
 *
 *   1. The English page (e.g. /about-us/) and the Greek page (/el/about-us/)
 *      share the same WordPress post ID, so an image saved once is used
 *      automatically for both languages — no extra sync needed.
 *
 *   2. On individual service sub-pages (template-service-single.php), the
 *      hero image is inherited from the All Services page so the image
 *      saved there appears on every service hero.
 *
 * If ACF is not installed the field group simply isn't registered, but the
 * resolver still falls back to schema defaults so the front-end never breaks.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the hero image picker and resolves the URL for any page hero.
 */
final class Hotelier_Hero_Image_Field {

	/** ACF field name (also the postmeta key written by ACF). */
	public const FIELD_NAME = 'hotelier_hero_image';

	/** ACF field key (selector fallback if the name key collides in the DB). */
	private const FIELD_KEY = 'field_hotelier_hero_image';

	/** Schema context that should always read from the All Services page. */
	private const SERVICE_CHILD_CONTEXT = 'service';

	/** Slug of the All Services page (parent of every service sub-page). */
	private const SERVICES_PARENT_SLUG = 'services';

	/**
	 * Page templates that should expose the hero image picker.
	 *
	 * Service sub-pages are intentionally excluded because they inherit
	 * the hero image from the All Services page.
	 */
	private const PAGE_TEMPLATES = array(
		'page-templates/template-about.php',
		'page-templates/template-services.php',
		'page-templates/template-portfolio.php',
		'page-templates/template-contact.php',
		'page-templates/template-founder.php',
	);

	/** @var int|null Cached All Services page ID. */
	private static $services_page_id_cache = null;

	public static function register(): void {
		add_action( 'acf/init', array( self::class, 'register_field_group' ) );
	}

	/**
	 * Register the ACF Local Field Group.
	 *
	 * Runs on `acf/init`. No-op when ACF isn't active.
	 */
	public static function register_field_group(): void {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		acf_add_local_field_group(
			array(
				'key'                   => 'group_hotelier_hero_image',
				'title'                 => __( 'Hero background image', '360-hotelier' ),
				'fields'                => array(
					array(
						'key'           => 'field_hotelier_hero_image',
						'label'         => __( 'Hero background image', '360-hotelier' ),
						'name'          => self::FIELD_NAME,
						'type'          => 'image',
						'return_format' => 'id',
						'preview_size'  => 'medium',
						'library'       => 'all',
						'mime_types'    => 'jpg,jpeg,png,webp,avif',
						'instructions'  => __( 'Used as the background image for this page\'s hero section. The same image is shown on both the English and Greek versions of this page. On the All Services page, the image is also reused as the hero on every individual service sub-page.', '360-hotelier' ),
					),
				),
				'location'              => self::build_location_rules(),
				'position'              => 'normal',
				'menu_order'            => 999,
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'active'                => true,
			)
		);
	}

	/**
	 * Resolve the hero background image URL for any page context.
	 *
	 * @param int    $page_id Current page ID.
	 * @param string $context Schema context: home | about | services | service | portfolio | contact | founder.
	 */
	public static function resolve_url( int $page_id, string $context ): string {
		if ( self::SERVICE_CHILD_CONTEXT === $context ) {
			$services_id = self::services_page_id();
			if ( $services_id > 0 ) {
				$services_url = self::saved_url_for_page( $services_id );
				if ( $services_url !== '' ) {
					return $services_url;
				}
			}
			return self::schema_default_url( $page_id, $context );
		}

		$own_url = self::saved_url_for_page( $page_id );
		if ( $own_url !== '' ) {
			return $own_url;
		}

		return self::schema_default_url( $page_id, $context );
	}

	/**
	 * Read the ACF-saved image URL for a page.
	 *
	 * Uses ACF's `get_field()` first: `get_post_meta` alone is unreliable for image fields
	 * (ACF may format, filter, or store values the plain meta read will miss).
	 * Supports return format id, array, and url.
	 */
	private static function saved_url_for_page( int $page_id ): string {
		if ( $page_id <= 0 ) {
			return '';
		}

		$raw = self::get_acf_hero_stored_value( $page_id );
		if ( null === $raw || false === $raw || '' === $raw ) {
			return '';
		}

		// Return format: URL (string).
		if ( is_string( $raw ) && self::string_looks_like_url( $raw ) ) {
			return $raw;
		}

		$attachment_id = 0;
		if ( is_numeric( $raw ) ) {
			$attachment_id = (int) $raw;
		} elseif ( is_array( $raw ) ) {
			if ( ! empty( $raw['ID'] ) ) {
				$attachment_id = (int) $raw['ID'];
			} elseif ( ! empty( $raw['id'] ) ) {
				$attachment_id = (int) $raw['id'];
			} elseif ( ! empty( $raw['url'] ) && is_string( $raw['url'] ) ) {
				return $raw['url'];
			}
		}

		if ( $attachment_id <= 0 ) {
			return '';
		}

		if ( function_exists( 'wp_attachment_is_image' ) && wp_attachment_is_image( $attachment_id ) ) {
			$url = wp_get_attachment_image_url( $attachment_id, 'full' );
		} else {
			// SVG or other file types: fall back to direct file URL.
			$url = wp_get_attachment_url( $attachment_id );
		}

		return is_string( $url ) && $url !== '' ? $url : '';
	}

	/**
	 * Raw / formatted value for this field, whichever ACF exposes.
	 */
	private static function get_acf_hero_stored_value( int $page_id ) {
		if ( function_exists( 'get_field' ) ) {
			$unformatted = self::get_field_hero_unformatted( $page_id );
			if ( self::is_nonempty_acf_value( $unformatted ) ) {
				return $unformatted;
			}
			$formatted = self::get_field_hero_formatted( $page_id );
			if ( self::is_nonempty_acf_value( $formatted ) ) {
				return $formatted;
			}
		}

		// get_post_meta fallback (e.g. ACF not loaded); value may be serialized.
		return maybe_unserialize( get_post_meta( $page_id, self::FIELD_NAME, true ) );
	}

	/**
	 * @return mixed
	 */
	private static function get_field_hero_unformatted( int $page_id ) {
		$by_name = get_field( self::FIELD_NAME, $page_id, false );
		if ( self::is_nonempty_acf_value( $by_name ) ) {
			return $by_name;
		}

		return get_field( self::FIELD_KEY, $page_id, false );
	}

	/**
	 * @return mixed
	 */
	private static function get_field_hero_formatted( int $page_id ) {
		$by_name = get_field( self::FIELD_NAME, $page_id, true );
		if ( self::is_nonempty_acf_value( $by_name ) ) {
			return $by_name;
		}

		return get_field( self::FIELD_KEY, $page_id, true );
	}

	/**
	 * @param mixed $val Value from get_field.
	 */
	private static function is_nonempty_acf_value( $val ): bool {
		if ( null === $val || false === $val || '' === $val ) {
			return false;
		}
		if ( is_array( $val ) && array() === $val ) {
			return false;
		}
		if ( 0 === $val || '0' === $val ) {
			return false;
		}

		return true;
	}

	/**
	 * @param string $s String to test.
	 */
	private static function string_looks_like_url( string $s ): bool {
		$s = ltrim( $s );
		if ( '' === $s ) {
			return false;
		}
		if ( 0 === strpos( $s, 'http://' ) || 0 === strpos( $s, 'https://' ) || 0 === strpos( $s, '//' ) ) {
			return true;
		}
		if ( 0 === strpos( $s, '/' ) && ! ctype_digit( $s ) ) {
			return true;
		}

		return false;
	}

	private static function schema_default_url( int $page_id, string $context ): string {
		return Hotelier_Page_Content::get_image_url( $page_id, $context, 'hero_bg' );
	}

	private static function services_page_id(): int {
		if ( null !== self::$services_page_id_cache ) {
			return self::$services_page_id_cache;
		}

		$page                         = get_page_by_path( self::SERVICES_PARENT_SLUG, OBJECT, 'page' );
		self::$services_page_id_cache = $page instanceof WP_Post ? (int) $page->ID : 0;

		return self::$services_page_id_cache;
	}

	/**
	 * Build the ACF location rules: each page template gets its own OR group,
	 * and the static front page is added as one final OR group.
	 *
	 * @return array<int, array<int, array<string, string>>>
	 */
	private static function build_location_rules(): array {
		$rules = array();

		foreach ( self::PAGE_TEMPLATES as $template ) {
			$rules[] = array(
				array(
					'param'    => 'page_template',
					'operator' => '==',
					'value'    => $template,
				),
			);
		}

		$rules[] = array(
			array(
				'param'    => 'page_type',
				'operator' => '==',
				'value'    => 'front_page',
			),
		);

		return $rules;
	}
}
