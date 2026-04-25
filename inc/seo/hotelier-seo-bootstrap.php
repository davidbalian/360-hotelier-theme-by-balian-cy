<?php
/**
 * Document title and meta description output for theme-managed pages.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers wp_head and document_title_parts hooks for SEO meta.
 */
final class Hotelier_Seo_Bootstrap {

	public static function register(): void {
		add_filter( 'document_title_parts', array( self::class, 'filter_document_title_parts' ), 25 );
		add_action( 'wp_head', array( self::class, 'output_meta_description' ), 1 );
	}

	/**
	 * @param array<string, string> $title_parts Title parts from WordPress.
	 * @return array<string, string>
	 */
	public static function filter_document_title_parts( $title_parts ): array {
		$meta = Hotelier_Seo_Meta_Resolver::resolve_for_request();
		if ( ! is_array( $meta ) || '' === $meta['title'] ) {
			return $title_parts;
		}

		$title_parts['title'] = $meta['title'];
		unset( $title_parts['site'], $title_parts['tagline'] );

		return $title_parts;
	}

	public static function output_meta_description(): void {
		if ( is_admin() ) {
			return;
		}

		$meta = Hotelier_Seo_Meta_Resolver::resolve_for_request();
		if ( ! is_array( $meta ) || '' === $meta['description'] ) {
			return;
		}

		echo '<meta name="description" content="' . esc_attr( $meta['description'] ) . '">' . "\n";
	}
}
