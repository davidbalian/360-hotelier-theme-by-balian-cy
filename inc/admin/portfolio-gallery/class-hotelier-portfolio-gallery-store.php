<?php
/**
 * Read-only access layer for Portfolio gallery attachment IDs.
 *
 * Single responsibility: hide the data source (the free "ACF Photo Gallery
 * Field" plugin by Navneil Naicker) from the rest of the theme. The
 * front-end template only knows "give me the ordered list of attachment
 * IDs for this page".
 *
 * The plugin stores the picked attachments as a comma-separated string in
 * postmeta, where the meta_key is the literal ACF field name (no prefix).
 * We try the plugin's `acf_photo_gallery()` helper first and fall back to
 * reading the raw postmeta directly so the marquee still works even if
 * the plugin's helper is unavailable for any reason on a given request.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Reads the ordered list of gallery attachment IDs for a page.
 */
final class Hotelier_Portfolio_Gallery_Store {

	/**
	 * ACF field name (the "Field Name" slug set in the ACF field group editor).
	 * The plugin stores the value in postmeta under this exact key.
	 */
	public const FIELD_NAME = 'portfolio_gallery';

	/**
	 * @param int $post_id Page ID.
	 * @return int[] Ordered attachment IDs (deduped, all > 0).
	 */
	public static function get_attachment_ids( int $post_id ): array {
		if ( $post_id <= 0 ) {
			return array();
		}

		$ids = self::ids_via_plugin_helper( $post_id );
		if ( ! empty( $ids ) ) {
			return $ids;
		}

		return self::ids_via_raw_postmeta( $post_id );
	}

	/**
	 * Diagnostic snapshot for admin-only debugging in the section template.
	 *
	 * @return array{
	 *     plugin_active: bool,
	 *     raw_meta: mixed,
	 *     helper_count: int,
	 *     fallback_count: int
	 * }
	 */
	public static function debug_snapshot( int $post_id ): array {
		return array(
			'plugin_active'  => function_exists( 'acf_photo_gallery' ),
			'raw_meta'       => $post_id > 0 ? get_post_meta( $post_id, self::FIELD_NAME, true ) : null,
			'helper_count'   => count( self::ids_via_plugin_helper( $post_id ) ),
			'fallback_count' => count( self::ids_via_raw_postmeta( $post_id ) ),
		);
	}

	/**
	 * @return int[]
	 */
	private static function ids_via_plugin_helper( int $post_id ): array {
		if ( ! function_exists( 'acf_photo_gallery' ) ) {
			return array();
		}

		$images = acf_photo_gallery( self::FIELD_NAME, $post_id );
		if ( ! is_array( $images ) ) {
			return array();
		}

		$ids = array();
		foreach ( $images as $image ) {
			$id = is_array( $image ) && isset( $image['id'] ) ? (int) $image['id'] : 0;
			if ( $id > 0 ) {
				$ids[] = $id;
			}
		}
		return self::dedupe_ids( $ids );
	}

	/**
	 * @return int[]
	 */
	private static function ids_via_raw_postmeta( int $post_id ): array {
		$raw = get_post_meta( $post_id, self::FIELD_NAME, true );
		if ( ! is_string( $raw ) || $raw === '' ) {
			return array();
		}

		$parts = array_map( 'trim', explode( ',', $raw ) );
		$ids   = array();
		foreach ( $parts as $part ) {
			if ( $part === '' || ! ctype_digit( $part ) ) {
				continue;
			}
			$id = (int) $part;
			if ( $id > 0 ) {
				$ids[] = $id;
			}
		}
		return self::dedupe_ids( $ids );
	}

	/**
	 * @param int[] $ids
	 * @return int[]
	 */
	private static function dedupe_ids( array $ids ): array {
		$seen = array();
		$out  = array();
		foreach ( $ids as $id ) {
			if ( isset( $seen[ $id ] ) ) {
				continue;
			}
			$seen[ $id ] = true;
			$out[]       = $id;
		}
		return $out;
	}
}
