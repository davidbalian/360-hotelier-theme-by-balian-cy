<?php
/**
 * Resolves document title and meta description from ACF with theme fallbacks.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front-end SEO resolution for managed theme pages.
 */
final class Hotelier_Seo_Meta_Resolver {

	/**
	 * WordPress page ID for the current view (front page or singular page).
	 */
	public static function effective_page_id_for_request(): int {
		if ( is_front_page() && 'page' === (string) get_option( 'show_on_front' ) ) {
			$front = (int) get_option( 'page_on_front' );
			return $front > 0 ? $front : 0;
		}

		if ( is_singular( 'page' ) ) {
			$id = (int) get_queried_object_id();
			return $id > 0 ? $id : 0;
		}

		return 0;
	}

	/**
	 * @return array{title: string, description: string}|null Null when this page has no theme-managed SEO.
	 */
	public static function resolve_for_request(): ?array {
		$page_id = self::effective_page_id_for_request();
		if ( $page_id <= 0 ) {
			return null;
		}

		$context = Hotelier_Seo_Context::for_page_id( $page_id );
		if ( null === $context ) {
			return null;
		}

		$lang = ( function_exists( 'hotelier_get_current_lang' ) && 'el' === hotelier_get_current_lang() ) ? 'el' : 'en';

		$fallback = Hotelier_Seo_Defaults::for_lang( $context, $lang );
		if ( null === $fallback ) {
			return null;
		}

		$title_field = ( 'el' === $lang ) ? Hotelier_Seo_Meta_Field::FIELD_TITLE_EL : Hotelier_Seo_Meta_Field::FIELD_TITLE_EN;
		$desc_field  = ( 'el' === $lang ) ? Hotelier_Seo_Meta_Field::FIELD_DESCRIPTION_EL : Hotelier_Seo_Meta_Field::FIELD_DESCRIPTION_EN;

		$title = self::read_acf_text( $page_id, $title_field );
		if ( '' === $title ) {
			$title = $fallback['title'];
		}

		$description = self::read_acf_text( $page_id, $desc_field );
		if ( '' === $description ) {
			$description = $fallback['description'];
		}

		return array(
			'title'       => $title,
			'description' => $description,
		);
	}

	private static function read_acf_text( int $post_id, string $field_name ): string {
		if ( ! function_exists( 'get_field' ) ) {
			return '';
		}

		$raw = get_field( $field_name, $post_id, false );
		if ( null === $raw || false === $raw ) {
			return '';
		}

		return trim( (string) $raw );
	}
}
