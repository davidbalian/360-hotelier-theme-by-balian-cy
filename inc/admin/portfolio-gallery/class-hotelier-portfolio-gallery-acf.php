<?php
/**
 * ACF field group registration for the Portfolio gallery.
 *
 * Single responsibility: declare the gallery field that drives the
 * portfolio marquee. Registered in PHP (not the ACF UI) so the field is
 * version-controlled and self-bootstrapping the moment ACF is active.
 *
 * Uses the free "ACF Photo Gallery Field" plugin by Navneil Naicker
 * (field type slug: `acf_photo_gallery`). Compatible with ACF free 4/5/6.
 * When neither ACF nor the gallery plugin is loaded, this class no-ops
 * cleanly and the front-end section simply renders nothing.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the Portfolio gallery ACF field group.
 */
final class Hotelier_Portfolio_Gallery_Acf {

	public const FIELD_GROUP_KEY = 'group_hotelier_portfolio_gallery';
	public const FIELD_KEY       = 'field_hotelier_portfolio_gallery_images';
	public const FIELD_NAME      = 'portfolio_gallery_images';
	public const TEMPLATE_SLUG   = 'page-templates/template-portfolio.php';

	public static function register(): void {
		add_action( 'acf/init', array( self::class, 'register_field_group' ) );
	}

	public static function register_field_group(): void {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		acf_add_local_field_group(
			array(
				'key'                   => self::FIELD_GROUP_KEY,
				'title'                 => __( 'Portfolio Gallery (shared between EN & GR)', '360-hotelier' ),
				'description'           => __( 'Images for the marquee gallery below the partner cards on the Portfolio page.', '360-hotelier' ),
				'fields'                => array(
					array(
						'key'          => self::FIELD_KEY,
						'label'        => __( 'Gallery images', '360-hotelier' ),
						'name'         => self::FIELD_NAME,
						'type'         => 'acf_photo_gallery',
						'instructions' => __( 'Pick the images that appear in the marquee below the partner cards. The first half of your selection appears in the top row, the second half in the bottom row. Drag thumbnails to reorder. Shared between English and Greek versions of the page.', '360-hotelier' ),
						'required'     => 0,
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'page_template',
							'operator' => '==',
							'value'    => self::TEMPLATE_SLUG,
						),
					),
				),
				'menu_order'            => 0,
				'position'              => 'normal',
				'style'                 => 'default',
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen'        => array(),
				'active'                => true,
				'show_in_rest'          => 0,
			)
		);
	}
}
