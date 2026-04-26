<?php
/**
 * Plain-text answers for FAQ JSON-LD from FAQ block structures.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Flattens {@see Hotelier_Faq_Content} block arrays into a single string.
 */
final class Hotelier_Faq_Schema_Text {

	/**
	 * @param array<int, array<string, mixed>> $blocks
	 */
	public static function from_blocks( array $blocks ): string {
		$parts = array();
		foreach ( $blocks as $block ) {
			if ( isset( $block['p'] ) ) {
				$parts[] = wp_strip_all_tags( (string) $block['p'] );
			}
			if ( isset( $block['ul'] ) && is_array( $block['ul'] ) ) {
				foreach ( $block['ul'] as $li ) {
					$parts[] = wp_strip_all_tags( (string) $li );
				}
			}
		}
		$joined = implode( "\n", array_filter( $parts, 'strlen' ) );

		return trim( preg_replace( '/\s+/u', ' ', $joined ) );
	}
}
