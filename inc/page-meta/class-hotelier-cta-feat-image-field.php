<?php
/**
 * ACF-backed bottom CTA band image for hotelier pages.
 *
 * Mirrors {@see Hotelier_Hero_Image_Field} for the full-bleed CTA section:
 * same EN/EL post ID, and on service sub-pages the All Services page image
 * is inherited when set.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Bottom CTA image field registration and URL resolution.
 */
final class Hotelier_Cta_Feat_Image_Field {

	public const FIELD_NAME = 'hotelier_cta_feat_image';

	private const FIELD_KEY = 'field_hotelier_cta_feat_image';

	/**
	 * @var string[]
	 */
	private const ALT_META_KEYS = array( 'cta_feat_img' );

	private const SERVICE_CHILD_CONTEXT = 'service';

	private const SERVICES_PARENT_SLUG = 'services';

	/** @var int|null */
	private static $services_page_id_cache = null;

	public static function register(): void {
		add_action( 'acf/init', array( self::class, 'register_field_group' ) );
	}

	public static function register_field_group(): void {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		acf_add_local_field_group(
			array(
				'key'                   => 'group_hotelier_cta_feat_image',
				'title'                 => __( 'Bottom CTA — image', '360-hotelier' ),
				'fields'                => array(
					array(
						'key'           => 'field_hotelier_cta_feat_image',
						'label'         => __( 'Bottom CTA — image', '360-hotelier' ),
						'name'          => self::FIELD_NAME,
						'type'          => 'image',
						'return_format' => 'id',
						'preview_size'  => 'medium',
						'library'       => 'all',
						'mime_types'    => 'jpg,jpeg,png,webp,avif',
					),
				),
				'location'              => Hotelier_Acf_Image_Location_Rules::build(),
				'position'              => 'normal',
				'menu_order'            => 1000,
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'active'                => true,
			)
		);
	}

	/**
	 * @param int    $page_id Page ID.
	 * @param string $context Schema context: home, about, services, service, etc.
	 */
	public static function resolve_url( int $page_id, string $context ): string {
		if ( self::SERVICE_CHILD_CONTEXT === $context ) {
			$services_id = self::services_page_id();
			if ( $services_id > 0 ) {
				$services_url = self::url_for_post( $services_id );
				if ( $services_url !== '' ) {
					return $services_url;
				}
			}
		}

		return Hotelier_Page_Content::get_image_url( $page_id, $context, 'cta_feat_img' );
	}

	/**
	 * @param int $page_id Post ID.
	 */
	public static function url_for_post( int $page_id ): string {
		if ( $page_id <= 0 ) {
			return '';
		}

		$raw = self::get_acf_stored_value( $page_id );
		if ( null === $raw || false === $raw || '' === $raw ) {
			return '';
		}

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
			$url = wp_get_attachment_url( $attachment_id );
		}

		return is_string( $url ) && $url !== '' ? $url : '';
	}

	/**
	 * @return mixed
	 */
	private static function get_acf_stored_value( int $page_id ) {
		$all_keys = array_values( array_unique( array_merge( array( self::FIELD_NAME ), self::ALT_META_KEYS ) ) );

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

		if ( function_exists( 'acf_get_field' ) && function_exists( 'acf_get_value' ) ) {
			$field = acf_get_field( self::FIELD_KEY );
			if ( is_array( $field ) && $field !== array() ) {
				$v = acf_get_value( $page_id, $field );
				if ( self::is_nonempty_acf_value( $v ) ) {
					return $v;
				}
			}
		}

		foreach ( $all_keys as $k ) {
			$raw = maybe_unserialize( get_post_meta( $page_id, $k, true ) );
			if ( self::is_nonempty_acf_value( $raw ) ) {
				return $raw;
			}
		}

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
}
