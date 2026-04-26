<?php
/**
 * Responsive markup for front-page service overview card images.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Outputs {@see wp_get_attachment_image} when the field resolves to an attachment;
 * otherwise a plain {@see img} using the schema URL (no srcset until images are in the media library).
 */
final class Hotelier_Front_Service_Card_Image {

	public const IMAGE_SIZE = 'hotelier-service-card';

	private const IMG_SIZES = '(max-width: 768px) calc(100vw - 64px), 696px';

	/**
	 * @param int    $page_id    Queried object ID (static front page).
	 * @param string $context    Page meta context (e.g. home).
	 * @param int    $card_index 1-based card index.
	 */
	public static function render( int $page_id, string $context, int $card_index ): void {
		$field = 'svc_' . $card_index . '_img';
		$alt   = Hotelier_Page_Content::get_text( $page_id, $context, 'svc_' . $card_index . '_alt' );

		$attachment_id = Hotelier_Page_Content::get_attachment_id( $page_id, $context, $field );
		if ( $attachment_id > 0 ) {
			echo wp_get_attachment_image(
				$attachment_id,
				self::IMAGE_SIZE,
				false,
				array(
					'alt'      => $alt,
					'loading'  => 'lazy',
					'decoding' => 'async',
					'sizes'    => self::IMG_SIZES,
				)
			);
			return;
		}

		$src = Hotelier_Page_Content::get_image_url( $page_id, $context, $field );
		if ( '' === $src ) {
			return;
		}

		printf(
			'<img src="%1$s" alt="%2$s" width="840" height="473" loading="lazy" decoding="async" sizes="%3$s" />',
			esc_url( $src ),
			esc_attr( $alt ),
			esc_attr( self::IMG_SIZES )
		);
	}
}
