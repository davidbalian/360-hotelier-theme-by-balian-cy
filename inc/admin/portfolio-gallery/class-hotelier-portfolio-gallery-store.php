<?php
/**
 * Read-only access layer for Portfolio gallery attachment IDs.
 *
 * Single responsibility: hide the data source (the free "ACF Photo Gallery
 * Field" plugin by Navneil Naicker) from the rest of the theme. The
 * front-end template only knows "give me the ordered list of attachment
 * IDs for this page".
 *
 * If the plugin is not active or the field is empty, returns an empty
 * array (the marquee section then renders nothing — safe default).
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
		if ( $post_id <= 0 || ! function_exists( 'acf_photo_gallery' ) ) {
			return array();
		}

		$images = acf_photo_gallery( Hotelier_Portfolio_Gallery_Acf::FIELD_NAME, $post_id );
		if ( ! is_array( $images ) ) {
			return array();
		}

		$seen = array();
		$ids  = array();
		foreach ( $images as $image ) {
			$id = is_array( $image ) && isset( $image['id'] ) ? (int) $image['id'] : 0;
			if ( $id <= 0 || isset( $seen[ $id ] ) ) {
				continue;
			}
			$seen[ $id ] = true;
			$ids[]       = $id;
		}

		return $ids;
	}
}
