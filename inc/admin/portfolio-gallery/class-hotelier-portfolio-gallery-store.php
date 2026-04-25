<?php
/**
 * Read-only access layer for Portfolio gallery attachment IDs.
 *
 * Single responsibility: hide the data source (currently ACF Pro Gallery
 * field) from the rest of the theme. The front-end template only knows
 * "give me the ordered list of attachment IDs for this page".
 *
 * If ACF is not active or the field is empty, returns an empty array
 * (the marquee section then renders nothing — safe default).
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
	 * @param int $post_id Page ID.
	 * @return int[] Ordered attachment IDs (deduped, all > 0).
	 */
	public static function get_attachment_ids( int $post_id ): array {
		if ( $post_id <= 0 || ! function_exists( 'get_field' ) ) {
			return array();
		}

		$value = get_field( Hotelier_Portfolio_Gallery_Acf::FIELD_NAME, $post_id );
		if ( ! is_array( $value ) ) {
			return array();
		}

		$seen = array();
		$ids  = array();
		foreach ( $value as $entry ) {
			$id = is_array( $entry ) && isset( $entry['ID'] )
				? (int) $entry['ID']
				: (int) $entry;

			if ( $id <= 0 || isset( $seen[ $id ] ) ) {
				continue;
			}
			$seen[ $id ] = true;
			$ids[]       = $id;
		}

		return $ids;
	}
}
