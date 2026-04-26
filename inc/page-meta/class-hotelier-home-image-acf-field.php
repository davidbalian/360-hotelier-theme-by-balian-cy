<?php
/**
 * ACF local field group: homepage images (static front page), excluding hero + bottom CTA bands.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers image pickers derived from {@see schema-home.php} (image type only).
 */
final class Hotelier_Home_Image_Acf_Field {

	private const GROUP_KEY = 'group_hotelier_home_images';

	/** Schema keys handled elsewhere via dedicated ACF fields. */
	private const EXCLUDED_SCHEMA_KEYS = array( 'hero_bg', 'cta_feat_img' );

	public static function register(): void {
		add_action( 'acf/init', array( self::class, 'register_field_group' ) );
	}

	/**
	 * Post meta / ACF field name.
	 */
	public static function field_name( string $schema_key ): string {
		return 'hotelier_home_' . $schema_key;
	}

	/**
	 * Ordered schema keys (type image) managed by this group.
	 *
	 * @return string[]
	 */
	public static function image_schema_keys(): array {
		$fields = Hotelier_Page_Meta_Schema::fields_for_context( 'home' );
		if ( ! $fields ) {
			return array();
		}
		$keys = array();
		foreach ( $fields as $key => $def ) {
			$k = (string) $key;
			if ( in_array( $k, self::EXCLUDED_SCHEMA_KEYS, true ) ) {
				continue;
			}
			$type = isset( $def['type'] ) ? (string) $def['type'] : '';
			if ( 'image' === $type ) {
				$keys[] = $k;
			}
		}
		return $keys;
	}

	public static function is_managed_image_field( string $field ): bool {
		return in_array( $field, self::image_schema_keys(), true );
	}

	/**
	 * Public URL for a homepage image from ACF on the static front page, or ''.
	 */
	public static function resolve_url( string $schema_key ): string {
		if ( ! self::is_managed_image_field( $schema_key ) || ! function_exists( 'get_field' ) ) {
			return '';
		}
		$page_id = Hotelier_Page_Content::front_page_id();
		if ( $page_id <= 0 ) {
			return '';
		}
		$raw = get_field( self::field_name( $schema_key ), $page_id, false );
		return self::url_from_acf_raw( $raw );
	}

	/**
	 * Attachment ID from ACF (0 if unset/invalid).
	 */
	public static function attachment_id_for_field( string $schema_key ): int {
		if ( ! self::is_managed_image_field( $schema_key ) || ! function_exists( 'get_field' ) ) {
			return 0;
		}
		$page_id = Hotelier_Page_Content::front_page_id();
		if ( $page_id <= 0 ) {
			return 0;
		}
		$raw = get_field( self::field_name( $schema_key ), $page_id, false );
		return self::attachment_id_from_acf_raw( $raw );
	}

	/**
	 * @param mixed $raw Value from get_field(..., false).
	 */
	private static function url_from_acf_raw( $raw ): string {
		$id = self::attachment_id_from_acf_raw( $raw );
		if ( $id > 0 ) {
			if ( function_exists( 'wp_attachment_is_image' ) && wp_attachment_is_image( $id ) ) {
				$url = wp_get_attachment_image_url( $id, 'full' );
			} else {
				$url = wp_get_attachment_url( $id );
			}
			return is_string( $url ) && $url !== '' ? $url : '';
		}
		if ( is_string( $raw ) && self::string_looks_like_url( $raw ) ) {
			return $raw;
		}
		return '';
	}

	/**
	 * @param mixed $raw Value from get_field(..., false).
	 */
	private static function attachment_id_from_acf_raw( $raw ): int {
		if ( is_numeric( $raw ) ) {
			return (int) $raw > 0 ? (int) $raw : 0;
		}
		if ( is_array( $raw ) ) {
			if ( ! empty( $raw['ID'] ) ) {
				return (int) $raw['ID'];
			}
			if ( ! empty( $raw['id'] ) ) {
				return (int) $raw['id'];
			}
		}
		if ( is_object( $raw ) && isset( $raw->ID ) ) {
			return (int) $raw->ID;
		}
		if ( is_object( $raw ) && isset( $raw->id ) ) {
			return (int) $raw->id;
		}
		return 0;
	}

	private static function string_looks_like_url( string $s ): bool {
		return 0 === strpos( $s, 'http://' ) || 0 === strpos( $s, 'https://' ) || 0 === strpos( $s, '/' );
	}

	public static function register_field_group(): void {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		$acf_fields = array();
		$last_tab   = '';

		foreach ( self::image_schema_keys() as $schema_key ) {
			$tab = self::tab_id_for_schema_key( $schema_key );
			if ( $tab !== $last_tab ) {
				$acf_fields[] = self::make_tab_field( $tab );
				$last_tab     = $tab;
			}

			$row          = Hotelier_Page_Meta_Schema::fields_for_context( 'home' );
			$label        = isset( $row[ $schema_key ]['label'] ) ? (string) $row[ $schema_key ]['label'] : $schema_key;
			$acf_fields[] = self::make_image_field( $schema_key, $label );
		}

		acf_add_local_field_group(
			array(
				'key'                   => self::GROUP_KEY,
				'title'                 => __( 'Homepage — images', '360-hotelier' ),
				'fields'                => $acf_fields,
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'page',
						),
						array(
							'param'    => 'page_type',
							'operator' => '==',
							'value'    => 'front_page',
						),
					),
				),
				'position'              => 'normal',
				'menu_order'            => 26,
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'active'                => true,
			)
		);
	}

	private static function tab_id_for_schema_key( string $key ): string {
		if ( 0 === strpos( $key, 'svc_' ) ) {
			return 'svc_cards';
		}
		if ( 0 === strpos( $key, 'why_' ) ) {
			return 'why';
		}
		if ( 0 === strpos( $key, 'results_' ) ) {
			return 'results';
		}
		if ( 0 === strpos( $key, 'approach_' ) ) {
			return 'approach';
		}
		if ( 0 === strpos( $key, 'feat_' ) ) {
			return 'feat';
		}
		if ( 0 === strpos( $key, 'founder_' ) ) {
			return 'founder';
		}
		if ( 0 === strpos( $key, 'contact_band_' ) ) {
			return 'contact_band';
		}
		return 'misc';
	}

	/**
	 * @return array<string, mixed>
	 */
	private static function make_tab_field( string $tab_id ): array {
		$labels = array(
			'svc_cards'    => __( 'Service cards', '360-hotelier' ),
			'why'          => __( 'Why choose us', '360-hotelier' ),
			'results'      => __( 'Results ticker', '360-hotelier' ),
			'approach'     => __( 'How we work', '360-hotelier' ),
			'feat'         => __( 'Featured banner', '360-hotelier' ),
			'founder'      => __( 'Founder', '360-hotelier' ),
			'contact_band' => __( 'Contact band', '360-hotelier' ),
			'misc'         => __( 'Other', '360-hotelier' ),
		);
		$label = isset( $labels[ $tab_id ] ) ? $labels[ $tab_id ] : $tab_id;

		return array(
			'key'       => 'field_hot_home_img_tab_' . $tab_id,
			'label'     => $label,
			'name'      => '_hotelier_home_img_tab_' . $tab_id,
			'type'      => 'tab',
			'placement' => 'top',
			'endpoint'  => 0,
		);
	}

	/**
	 * @return array<string, mixed>
	 */
	private static function make_image_field( string $schema_key, string $label ): array {
		$mimes = 'jpg,jpeg,png,webp,avif';
		if ( 'results_pendeli_svg' === $schema_key ) {
			$mimes .= ',svg';
		}

		return array(
			'key'           => 'field_hot_home_img_' . $schema_key,
			'label'         => $label,
			'name'          => self::field_name( $schema_key ),
			'type'          => 'image',
			'return_format' => 'id',
			'preview_size'  => 'medium',
			'library'       => 'all',
			'mime_types'    => $mimes,
		);
	}
}
