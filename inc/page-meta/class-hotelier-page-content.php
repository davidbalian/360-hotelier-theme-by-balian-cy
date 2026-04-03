<?php
/**
 * Resolve page content from post meta with schema defaults.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front-end and admin helpers for contextual page fields.
 */
final class Hotelier_Page_Content {

	/** @var array<string, mixed>|null */
	private static $service_admin_merged = null;

	/** @var int */
	private static $service_admin_merged_post_id = 0;

	public static function front_page_id(): int {
		return (int) get_option( 'page_on_front' );
	}

	public static function get_text( int $post_id, string $context, string $field ): string {
		$fields = Hotelier_Page_Meta_Schema::fields_for_context( $context );
		if ( ! $fields || ! isset( $fields[ $field ] ) ) {
			return '';
		}
		$def = $fields[ $field ];
		$default = isset( $def['default'] ) ? (string) $def['default'] : '';
		$raw     = get_post_meta( $post_id, Hotelier_Page_Meta_Schema::meta_key( $context, $field ), true );
		if ( is_string( $raw ) && $raw !== '' ) {
			return $raw;
		}
		return $default;
	}

	public static function get_select( int $post_id, string $context, string $field ): string {
		$fields = Hotelier_Page_Meta_Schema::fields_for_context( $context );
		if ( ! $fields || ! isset( $fields[ $field ] ) ) {
			return '';
		}
		$def     = $fields[ $field ];
		$default = isset( $def['default'] ) ? (string) $def['default'] : '';
		$options = isset( $def['options'] ) && is_array( $def['options'] ) ? $def['options'] : array();
		$raw     = get_post_meta( $post_id, Hotelier_Page_Meta_Schema::meta_key( $context, $field ), true );
		$val     = is_string( $raw ) ? $raw : '';
		if ( $val !== '' && ( $options === array() || isset( $options[ $val ] ) ) ) {
			return $val;
		}
		return $default;
	}

	/**
	 * Attachment URL if ID set and valid; else default_url from schema.
	 */
	public static function get_image_url( int $post_id, string $context, string $field ): string {
		$fields = Hotelier_Page_Meta_Schema::fields_for_context( $context );
		if ( ! $fields || ! isset( $fields[ $field ] ) ) {
			return '';
		}
		$def         = $fields[ $field ];
		$default_url = isset( $def['default_url'] ) ? (string) $def['default_url'] : '';

		$id = (int) get_post_meta( $post_id, Hotelier_Page_Meta_Schema::meta_key( $context, $field ), true );
		if ( $id > 0 ) {
			$url = wp_get_attachment_image_url( $id, 'full' );
			if ( is_string( $url ) && $url !== '' ) {
				return $url;
			}
		}
		return $default_url;
	}

	public static function get_attachment_id( int $post_id, string $context, string $field ): int {
		$id = (int) get_post_meta( $post_id, Hotelier_Page_Meta_Schema::meta_key( $context, $field ), true );
		return $id > 0 ? $id : 0;
	}

	/**
	 * Value to show in the meta box text/textarea (saved meta, else schema default, else service PHP fallback).
	 */
	public static function get_admin_input_text( int $post_id, string $context, string $field ): string {
		$fields = Hotelier_Page_Meta_Schema::fields_for_context( $context );
		if ( ! $fields || ! isset( $fields[ $field ] ) ) {
			return '';
		}
		$def  = $fields[ $field ];
		$type = isset( $def['type'] ) ? $def['type'] : 'text';
		if ( 'image' === $type || 'select' === $type ) {
			return '';
		}
		$raw = get_post_meta( $post_id, Hotelier_Page_Meta_Schema::meta_key( $context, $field ), true );
		if ( is_string( $raw ) && $raw !== '' ) {
			return $raw;
		}
		$schema_default = isset( $def['default'] ) ? (string) $def['default'] : '';
		if ( $schema_default !== '' ) {
			return $schema_default;
		}
		if ( 'service' === $context ) {
			return self::service_admin_fallback_text( $post_id, $field );
		}
		return '';
	}

	/**
	 * Effective select value for admin (matches front-end get_select).
	 */
	public static function get_admin_select_value( int $post_id, string $context, string $field ): string {
		return self::get_select( $post_id, $context, $field );
	}

	/**
	 * Thumbnail URL for meta box preview, or default_url when no attachment saved.
	 */
	public static function get_admin_image_preview_url( int $post_id, string $context, string $field ): string {
		$fields = Hotelier_Page_Meta_Schema::fields_for_context( $context );
		if ( ! $fields || ! isset( $fields[ $field ] ) ) {
			return '';
		}
		$def         = $fields[ $field ];
		$default_url = isset( $def['default_url'] ) ? (string) $def['default_url'] : '';
		$id          = (int) get_post_meta( $post_id, Hotelier_Page_Meta_Schema::meta_key( $context, $field ), true );
		if ( $id > 0 ) {
			$thumb = wp_get_attachment_image_url( $id, 'thumbnail' );
			if ( is_string( $thumb ) && $thumb !== '' ) {
				return $thumb;
			}
			$full = wp_get_attachment_image_url( $id, 'full' );
			if ( is_string( $full ) && $full !== '' ) {
				return $full;
			}
		}
		return $default_url;
	}

	/**
	 * @param string $field Schema field key.
	 */
	private static function service_admin_fallback_text( int $post_id, string $field ): string {
		if ( self::$service_admin_merged_post_id !== $post_id ) {
			self::$service_admin_merged_post_id = $post_id;
			$slug = get_post_field( 'post_name', $post_id );
			if ( ! is_string( $slug ) ) {
				$slug = '';
			}
			self::$service_admin_merged = hotelier_get_service_page_content( $post_id, $slug );
		}
		$c = self::$service_admin_merged;
		if ( ! is_array( $c ) ) {
			return '';
		}
		$map = array(
			'hero_title'         => 'title',
			'hero_subtitle'      => 'hero_subtitle',
			'intro'              => 'intro',
			'overview_heading'   => 'overview_heading',
			'deliver_heading'    => 'deliver_heading',
			'cta_feat_title'     => 'cta_title',
			'cta_feat_text'      => 'cta_text',
			'cta_feat_primary'   => 'cta_primary',
			'cta_feat_secondary' => 'cta_secondary',
		);
		if ( isset( $map[ $field ] ) ) {
			$k = $map[ $field ];
			return isset( $c[ $k ] ) ? (string) $c[ $k ] : '';
		}
		if ( preg_match( '/^deliver_([1-5])$/', $field, $m ) ) {
			$i = (int) $m[1] - 1;
			return isset( $c['deliverables'][ $i ] ) ? (string) $c['deliverables'][ $i ] : '';
		}
		return '';
	}

	/**
	 * Inline SVG markup from attachment file, or from default uploads path if SVG.
	 *
	 * @param string $fallback_relative Path relative to WP_CONTENT_DIR (e.g. uploads/2026/03/file.svg).
	 */
	public static function get_svg_inline( int $attachment_id, string $fallback_relative ): string {
		if ( $attachment_id > 0 ) {
			$path = get_attached_file( $attachment_id );
			if ( is_string( $path ) && is_readable( $path ) && substr( strtolower( $path ), -4 ) === '.svg' ) {
				$svg = file_get_contents( $path );
				return is_string( $svg ) ? $svg : '';
			}
		}
		$full = trailingslashit( WP_CONTENT_DIR ) . ltrim( $fallback_relative, '/' );
		if ( is_readable( $full ) ) {
			$svg = file_get_contents( $full );
			return is_string( $svg ) ? $svg : '';
		}
		return '';
	}
}
