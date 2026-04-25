<?php
/**
 * ACF local field group: per-page SEO title and meta description (EN + EL).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers the SEO field group on all pages.
 */
final class Hotelier_Seo_Meta_Field {

	public const FIELD_TITLE_EN       = 'hotelier_seo_title_en';
	public const FIELD_DESCRIPTION_EN = 'hotelier_seo_description_en';
	public const FIELD_TITLE_EL       = 'hotelier_seo_title_el';
	public const FIELD_DESCRIPTION_EL = 'hotelier_seo_description_el';

	private const GROUP_KEY = 'group_hotelier_seo_meta';

	public static function register(): void {
		add_action( 'acf/init', array( self::class, 'register_field_group' ) );
	}

	public static function register_field_group(): void {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		acf_add_local_field_group(
			array(
				'key'                   => self::GROUP_KEY,
				'title'                 => __( 'SEO — document title & meta description', '360-hotelier' ),
				'fields'                => array(
					array(
						'key'   => 'field_hotelier_seo_title_en',
						'label' => __( 'Meta title (English)', '360-hotelier' ),
						'name'  => self::FIELD_TITLE_EN,
						'type'  => 'text',
					),
					array(
						'key'          => 'field_hotelier_seo_description_en',
						'label'        => __( 'Meta description (English)', '360-hotelier' ),
						'name'         => self::FIELD_DESCRIPTION_EN,
						'type'         => 'textarea',
						'rows'         => 3,
						'new_lines'    => '',
						'instructions' => __( 'Shown in search results for English URLs. Leave empty to use the theme default for this page.', '360-hotelier' ),
					),
					array(
						'key'   => 'field_hotelier_seo_title_el',
						'label' => __( 'Meta title (Greek)', '360-hotelier' ),
						'name'  => self::FIELD_TITLE_EL,
						'type'  => 'text',
					),
					array(
						'key'          => 'field_hotelier_seo_description_el',
						'label'        => __( 'Meta description (Greek)', '360-hotelier' ),
						'name'         => self::FIELD_DESCRIPTION_EL,
						'type'         => 'textarea',
						'rows'         => 3,
						'new_lines'    => '',
						'instructions' => __( 'Shown for Greek (/el/) URLs. Same WordPress page as English; edit both languages here.', '360-hotelier' ),
					),
				),
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'page',
						),
					),
				),
				'position'              => 'normal',
				'menu_order'            => 5,
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'active'                => true,
			)
		);
	}
}
