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
