<?php
/**
 * Persistence layer for the Portfolio gallery attachment IDs.
 *
 * Single responsibility: read/write the ordered list of WP attachment IDs
 * that compose the portfolio marquee gallery. Stored as a comma-separated
 * string in postmeta for portability and predictable ordering.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Read / write portfolio gallery attachment IDs against a single page record.
 */
final class Hotelier_Portfolio_Gallery_Store {

	/**
	 * Postmeta key. Underscore prefix hides it from WP's generic custom-fields box.
	 */
	public const META_KEY = '_hotelier_portfolio_gallery_ids';

	/**
	 * Returns the ordered, validated list of attachment IDs for a page.
	 *
	 * @param int $post_id Page ID.
	 * @return int[] Ordered attachment IDs (deduped, all > 0).
	 */
	public static function get_attachment_ids( int $post_id ): array {
		if ( $post_id <= 0 ) {
			return array();
		}

		$raw = get_post_meta( $post_id, self::META_KEY, true );
		if ( ! is_string( $raw ) || $raw === '' ) {
			return array();
		}

		return self::parse_csv( $raw );
	}

	/**
	 * Persist the ordered list of attachment IDs for a page.
	 *
	 * @param int   $post_id Page ID.
	 * @param int[] $ids     Ordered attachment IDs.
	 */
	public static function save_attachment_ids( int $post_id, array $ids ): void {
		if ( $post_id <= 0 ) {
			return;
		}

		$clean = self::sanitize_ids( $ids );

		if ( empty( $clean ) ) {
			delete_post_meta( $post_id, self::META_KEY );
			return;
		}

		update_post_meta( $post_id, self::META_KEY, implode( ',', $clean ) );
	}

	/**
	 * Convert a CSV string of IDs into a clean ordered int array.
	 *
	 * @return int[]
	 */
	public static function parse_csv( string $csv ): array {
		$parts = array_map( 'trim', explode( ',', $csv ) );
		$ids   = array();
		foreach ( $parts as $part ) {
			if ( $part === '' || ! ctype_digit( $part ) ) {
				continue;
			}
			$ids[] = (int) $part;
		}
		return self::sanitize_ids( $ids );
	}

	/**
	 * Strip non-positive IDs and duplicates while preserving order.
	 *
	 * @param int[] $ids
	 * @return int[]
	 */
	private static function sanitize_ids( array $ids ): array {
		$seen = array();
		$out  = array();
		foreach ( $ids as $id ) {
			$id = (int) $id;
			if ( $id <= 0 || isset( $seen[ $id ] ) ) {
				continue;
			}
			$seen[ $id ] = true;
			$out[]       = $id;
		}
		return $out;
	}
}
