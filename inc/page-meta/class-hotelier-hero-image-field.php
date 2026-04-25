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

	/**
	 * Optional meta key fallbacks (e.g. hand-built ACF using schema field name "hero_bg").
	 *
	 * @var string[]
	 */
	private const ALT_META_KEYS = array( 'hero_bg', 'hero_image' );

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
	 * Emit an HTML comment with hero resolution diagnostics (view source in the browser).
	 *
	 * Shown when: `HOTELIER_HERO_DEBUG` is true in `wp-config.php`, or the current user
	 * is logged in and can `manage_options` (avoids leaking meta in view source to guests).
	 *
	 * @param int    $page_id   Page (post) ID the hero is for.
	 * @param string $context   Schema context, e.g. `home` or `about` (use '' if unknown).
	 * @param string $final_url The URL actually used for the background image.
	 */
	public static function print_hero_debug_html_comment( int $page_id, string $context, string $final_url ): void {
		if ( ! self::is_hero_debug_enabled() ) {
			return;
		}

		$meta_keys = array_values( array_unique( array_merge( array( self::FIELD_NAME ), self::ALT_META_KEYS ) ) );
		$pm        = array();
		foreach ( $meta_keys as $k ) {
			$pm[ $k ] = maybe_unserialize( get_post_meta( $page_id, $k, true ) );
		}

		$get_field_raw = null;
		if ( function_exists( 'get_field' ) ) {
			$get_field_raw = get_field( self::FIELD_NAME, $page_id, false );
		}

		$payload = array(
			'what'                 => '360-hotelier-hero',
			'page_id'              => $page_id,
			'context'              => $context,
			'queried_object_id'   => (int) get_queried_object_id(),
			'is_front_page'        => (bool) is_front_page(),
			'page_template'        => is_singular( 'page' ) ? (string) get_page_template_slug() : '',
			'final_hero_url'      => $final_url,
			'acf_url_only'        => self::url_for_post( $page_id ),
			'get_field_raw'        => $get_field_raw,
			'post_meta_hero_keys'  => $pm,
			'all_services_page_id' => self::services_page_id(),
			'acf_get_field'        => function_exists( 'get_field' ) ? 1 : 0,
			'WP_DEBUG'             => ( defined( 'WP_DEBUG' ) && WP_DEBUG ),
		);
		if ( defined( 'HOTELIER_HERO_DEBUG' ) ) {
			$payload['HOTELIER_HERO_DEBUG'] = (bool) constant( 'HOTELIER_HERO_DEBUG' );
		}

		if ( $context !== '' && $page_id > 0 ) {
			$payload['resolve_url_full'] = self::resolve_url( $page_id, $context );
		}

		$json = wp_json_encode( $payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_SUBSTITUTE );
		if ( ! is_string( $json ) ) {
			$json = '{}';
		}
		$json = str_replace( '--', "\xe2\x80\x93\xe2\x80\x93", $json );
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- gated debug: JSON of attachment/meta IDs for admins or HOTELIER_HERO_DEBUG only.
		echo "\n<!-- 360-hotelier-hero-debug " . $json . " -->\n";
	}

	/**
	 * @return bool
	 */
	private static function is_hero_debug_enabled(): bool {
		if ( defined( 'HOTELIER_HERO_DEBUG' ) && constant( 'HOTELIER_HERO_DEBUG' ) ) {
			return true;
		}
		return is_user_logged_in() && current_user_can( 'manage_options' );
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
		// Sub-service pages: inherit the All Services page hero, then fall back to schema in get_image_url().
		if ( self::SERVICE_CHILD_CONTEXT === $context ) {
			$services_id = self::services_page_id();
			if ( $services_id > 0 ) {
				$services_url = self::url_for_post( $services_id );
				if ( $services_url !== '' ) {
					return $services_url;
				}
			}
		}

		// ACF (post meta) first, then hardcoded theme default from schema.
		return Hotelier_Page_Content::get_image_url( $page_id, $context, 'hero_bg' );
	}

	/**
	 * Public: URL for this page's hero from ACF / post meta only (no theme schema fallback).
	 *
	 * @param int $page_id Post ID.
	 */
	public static function url_for_post( int $page_id ): string {
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
		} elseif ( is_object( $raw ) && isset( $raw->ID ) ) {
			$attachment_id = (int) $raw->ID;
		} elseif ( is_object( $raw ) && isset( $raw->id ) ) {
			$attachment_id = (int) $raw->id;
		} elseif ( is_object( $raw ) && isset( $raw->url ) && is_string( $raw->url ) ) {
			return $raw->url;
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
	 * Raw value from ACF / post meta (ID, array, or URL), using every reliable read path.
	 *
	 * @return mixed Null or empty string if nothing is stored.
	 */
	private static function get_acf_hero_stored_value( int $page_id ) {
		$all_keys = array_values( array_unique( array_merge( array( self::FIELD_NAME ), self::ALT_META_KEYS ) ) );

		// 1) Bulk load: often succeeds when get_field() or get_post_meta() is filtered.
		if ( function_exists( 'get_fields' ) ) {
			foreach ( array( false, true ) as $format_value ) {
				$all = get_fields( $page_id, $format_value );
				if ( ! is_array( $all ) ) {
					continue;
				}
				foreach ( $all_keys as $k ) {
					if ( ! isset( $all[ $k ] ) ) {
						continue;
					}
					if ( self::is_nonempty_acf_value( $all[ $k ] ) ) {
						return $all[ $k ];
					}
				}
			}
		}

		// 2) get_field( name, id ) first — avoids ACF 5/6 / arg-order quirks with 3+ args.
		if ( function_exists( 'get_field' ) ) {
			foreach ( array( self::FIELD_NAME, self::FIELD_KEY ) as $selector ) {
				$v = get_field( $selector, $page_id );
				if ( self::is_nonempty_acf_value( $v ) ) {
					return $v;
				}
			}
			foreach ( array( self::FIELD_NAME, self::FIELD_KEY ) as $selector ) {
				$v = get_field( $selector, $page_id, false );
				if ( self::is_nonempty_acf_value( $v ) ) {
					return $v;
				}
				$v = get_field( $selector, $page_id, true );
				if ( self::is_nonempty_acf_value( $v ) ) {
					return $v;
				}
			}
		}

		// 3) Low-level ACF (field definition + value pipeline).
		if ( function_exists( 'acf_get_field' ) && function_exists( 'acf_get_value' ) ) {
			$field = acf_get_field( self::FIELD_KEY );
			if ( is_array( $field ) && $field !== array() ) {
				$v = acf_get_value( $page_id, $field );
				if ( self::is_nonempty_acf_value( $v ) ) {
					return $v;
				}
			}
		}

		// 4) WordPress post meta (ACF or manual).
		foreach ( $all_keys as $k ) {
			$raw = maybe_unserialize( get_post_meta( $page_id, $k, true ) );
			if ( self::is_nonempty_acf_value( $raw ) ) {
				return $raw;
			}
		}

		// 5) Unfiltered DB read (bypasses get_post_metadata filters).
		global $wpdb;
		if ( $wpdb instanceof \wpdb ) {
			foreach ( $all_keys as $k ) {
				$raw = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM {$wpdb->postmeta} WHERE post_id = %d AND meta_key = %s LIMIT 1", $page_id, $k ) );
				if ( null === $raw || ! is_string( $raw ) || '' === $raw ) {
					continue;
				}
				$raw = maybe_unserialize( $raw );
				if ( self::is_nonempty_acf_value( $raw ) ) {
					return $raw;
				}
			}
		}

		return null;
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
