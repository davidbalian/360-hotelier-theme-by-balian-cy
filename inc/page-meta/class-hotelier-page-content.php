<?php
/**
 * Resolve page content from hardcoded schema defaults.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front-end helpers for contextual page fields.
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

		if ( 'home' === $context && class_exists( 'Hotelier_Home_Text_Acf_Field' )
			&& Hotelier_Home_Text_Acf_Field::is_text_schema_field( $field ) ) {
			$from_acf = Hotelier_Home_Text_Acf_Field::get_acf_value_for_request( $field );
			if ( '' !== $from_acf ) {
				return $from_acf;
			}
		}

		$default = isset( $fields[ $field ]['default'] ) ? (string) $fields[ $field ]['default'] : '';

		if ( function_exists( 'hotelier_get_current_lang' )
			&& 'el' === hotelier_get_current_lang()
			&& class_exists( 'Hotelier_El_Page_Defaults' ) ) {
			$el = Hotelier_El_Page_Defaults::get( $context, $field );
			if ( is_string( $el ) && $el !== '' ) {
				return $el;
			}
		}

		return $default;
	}

	public static function get_select( int $post_id, string $context, string $field ): string {
		$fields = Hotelier_Page_Meta_Schema::fields_for_context( $context );
		if ( ! $fields || ! isset( $fields[ $field ] ) ) {
			return '';
		}
		return isset( $fields[ $field ]['default'] ) ? (string) $fields[ $field ]['default'] : '';
	}

	/**
	 * Returns the image URL for a schema field.
	 *
	 * For `hero_bg` and `cta_feat_img`, ACF (post meta) is read first; only if
	 * unset does the theme use the hardcoded `default_url` from the schema. All
	 * other image fields remain schema-only.
	 */
	public static function get_image_url( int $post_id, string $context, string $field ): string {
		if ( 'hero_bg' === $field && $post_id > 0 && class_exists( 'Hotelier_Hero_Image_Field' ) ) {
			$from_acf = Hotelier_Hero_Image_Field::url_for_post( $post_id );
			if ( is_string( $from_acf ) && $from_acf !== '' ) {
				return $from_acf;
			}
		}

		if ( 'cta_feat_img' === $field && $post_id > 0 && class_exists( 'Hotelier_Cta_Feat_Image_Field' ) ) {
			$from_acf = Hotelier_Cta_Feat_Image_Field::url_for_post( $post_id );
			if ( is_string( $from_acf ) && $from_acf !== '' ) {
				return $from_acf;
			}
		}

		$fields = Hotelier_Page_Meta_Schema::fields_for_context( $context );
		if ( ! $fields || ! isset( $fields[ $field ] ) ) {
			return '';
		}
		return isset( $fields[ $field ]['default_url'] ) ? (string) $fields[ $field ]['default_url'] : '';
	}

	public static function get_attachment_id( int $post_id, string $context, string $field ): int {
		return 0;
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
