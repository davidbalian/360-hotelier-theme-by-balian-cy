<?php
/**
 * ACF local field groups: body images for inner pages (About, Founder, Portfolio,
 * Services, Service single; Contact has none beyond hero + CTA). Excludes hero + bottom CTA images.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers image pickers from schema for inner page contexts.
 */
final class Hotelier_Context_Page_Image_Acf_Field {

	/** @var string[] */
	private const CONTEXTS = array( 'error_404', 'about', 'founder', 'portfolio', 'contact', 'services', 'service' );

	/** Schema keys handled via {@see Hotelier_Hero_Image_Field} and {@see Hotelier_Cta_Feat_Image_Field}. */
	private const EXCLUDED_SCHEMA_KEYS = array( 'hero_bg', 'cta_feat_img' );

	/**
	 * @var array<string, string> context => page template path
	 */
	private const CONTEXT_TEMPLATE = array(
		'error_404' => 'page-templates/template-404-content.php',
		'about'     => 'page-templates/template-about.php',
		'founder'   => 'page-templates/template-founder.php',
		'portfolio' => 'page-templates/template-portfolio.php',
		'contact'   => 'page-templates/template-contact.php',
		'services'  => 'page-templates/template-services.php',
		'service'   => 'page-templates/template-service-single.php',
	);

	public static function register(): void {
		add_action( 'acf/init', array( self::class, 'register_field_groups' ) );
		add_filter( 'acf/load_value', array( self::class, 'load_image_value' ), 10, 3 );
	}

	public static function field_name( string $context, string $schema_key ): string {
		return 'hotelier_' . $context . '_' . $schema_key;
	}

	/**
	 * When a managed inner-page image field has no stored meta, fall back to the
	 * attachment matching its schema default_url (or per-slug overview default for service singles).
	 *
	 * @param mixed                $value   Stored value.
	 * @param int|string           $post_id Post ID.
	 * @param array<string, mixed> $field   ACF field array.
	 * @return mixed
	 */
	public static function load_image_value( $value, $post_id, $field ) {
		if ( ! is_array( $field ) || empty( $field['name'] ) ) {
			return $value;
		}

		$name = (string) $field['name'];
		if ( ! preg_match( '/^hotelier_(error_404|about|founder|portfolio|contact|services|service)_(.+)$/', $name, $m ) ) {
			return $value;
		}

		$context    = (string) $m[1];
		$schema_key = (string) $m[2];

		if ( ! self::is_managed_image( $context, $schema_key ) ) {
			return $value;
		}

		$pid = (int) $post_id;
		if ( $pid > 0 && metadata_exists( 'post', $pid, $name ) ) {
			return $value;
		}

		$default_id = self::default_attachment_id_for_field( $context, $schema_key, $pid );
		if ( $default_id > 0 ) {
			return $default_id;
		}

		return $value;
	}

	/**
	 * Attachment ID for a context + schema key (resolved from default_url, or per-slug for service overview), or 0.
	 */
	private static function default_attachment_id_for_field( string $context, string $schema_key, int $post_id ): int {
		if ( 'service' === $context && 'overview_img' === $schema_key ) {
			if ( $post_id <= 0 || ! class_exists( 'Hotelier_Service_Single_Defaults' ) ) {
				return 0;
			}
			$slug = (string) get_post_field( 'post_name', $post_id, 'raw' );
			if ( '' === $slug ) {
				return 0;
			}
			$url = Hotelier_Service_Single_Defaults::default_overview_image_url( $slug );
			if ( '' === $url ) {
				return 0;
			}
			$id = (int) attachment_url_to_postid( $url );
			return $id > 0 ? $id : 0;
		}

		$fields = Hotelier_Page_Meta_Schema::fields_for_context( $context );
		if ( ! $fields || ! isset( $fields[ $schema_key ]['default_url'] ) ) {
			return 0;
		}

		$url = trim( (string) $fields[ $schema_key ]['default_url'] );
		if ( '' === $url ) {
			return 0;
		}

		$id = (int) attachment_url_to_postid( $url );
		return $id > 0 ? $id : 0;
	}

	/**
	 * @return string[]
	 */
	public static function image_schema_keys( string $context ): array {
		$fields = Hotelier_Page_Meta_Schema::fields_for_context( $context );
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

	public static function is_managed_image( string $context, string $field ): bool {
		if ( ! in_array( $context, self::CONTEXTS, true ) ) {
			return false;
		}
		return in_array( $field, self::image_schema_keys( $context ), true );
	}

	public static function url_for_post( int $post_id, string $context, string $schema_key ): string {
		if ( $post_id <= 0 || ! self::is_managed_image( $context, $schema_key ) || ! function_exists( 'get_field' ) ) {
			return '';
		}
		$raw = get_field( self::field_name( $context, $schema_key ), $post_id, false );
		return self::url_from_acf_raw( $raw );
	}

	public static function attachment_id_for_post( int $post_id, string $context, string $schema_key ): int {
		if ( $post_id <= 0 || ! self::is_managed_image( $context, $schema_key ) || ! function_exists( 'get_field' ) ) {
			return 0;
		}
		$raw = get_field( self::field_name( $context, $schema_key ), $post_id, false );
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

	public static function register_field_groups(): void {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		foreach ( self::CONTEXTS as $context ) {
			self::register_one_context_group( $context );
		}
	}

	private static function register_one_context_group( string $context ): void {
		$template = self::CONTEXT_TEMPLATE[ $context ];
		$keys     = self::image_schema_keys( $context );
		if ( $keys === array() ) {
			return;
		}

		$acf_fields = array();
		$last_tab   = '';
		$row        = Hotelier_Page_Meta_Schema::fields_for_context( $context );

		foreach ( $keys as $schema_key ) {
			$tab = self::tab_id( $context, $schema_key );
			if ( $tab !== $last_tab ) {
				$acf_fields[] = self::make_tab_field( $context, $tab );
				$last_tab     = $tab;
			}

			$label        = isset( $row[ $schema_key ]['label'] ) ? (string) $row[ $schema_key ]['label'] : $schema_key;
			$acf_fields[] = self::make_image_field( $context, $schema_key, $label );
		}

		$titles = array(
			'error_404' => __( '404 page — images', '360-hotelier' ),
			'about'     => __( 'About page — images', '360-hotelier' ),
			'founder'   => __( 'Founder page — images', '360-hotelier' ),
			'portfolio' => __( 'Portfolio page — images', '360-hotelier' ),
			'contact'   => __( 'Contact page — images', '360-hotelier' ),
			'services'  => __( 'Services page — images', '360-hotelier' ),
			'service'   => __( 'Service page — images', '360-hotelier' ),
		);

		acf_add_local_field_group(
			array(
				'key'                   => 'group_hotelier_ctx_' . $context . '_images',
				'title'                 => $titles[ $context ],
				'fields'                => $acf_fields,
				'location'              => array(
					array(
						array(
							'param'    => 'post_type',
							'operator' => '==',
							'value'    => 'page',
						),
						array(
							'param'    => 'page_template',
							'operator' => '==',
							'value'    => $template,
						),
					),
				),
				'position'              => 'normal',
				'menu_order'            => 28,
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'active'                => true,
			)
		);
	}

	private static function tab_id( string $context, string $key ): string {
		switch ( $context ) {
			case 'error_404':
				return 'hero';

			case 'about':
				if ( 0 === strpos( $key, 'intro_' ) ) {
					return 'intro';
				}
				if ( 0 === strpos( $key, 'what_' ) ) {
					return 'what';
				}
				return 'misc';

			case 'founder':
				if ( 0 === strpos( $key, 'bio_' ) ) {
					return 'bio';
				}
				if ( 0 === strpos( $key, 'tl_' ) ) {
					return 'tl';
				}
				return 'misc';

			case 'portfolio':
				if ( 0 === strpos( $key, 'intro_' ) ) {
					return 'intro';
				}
				if ( 0 === strpos( $key, 'pendeli_' ) ) {
					return 'pendeli';
				}
				if ( preg_match( '/^hotel_(\d+)_/', $key, $m ) ) {
					return 'hotel_' . $m[1];
				}
				return 'misc';

			case 'services':
				if ( preg_match( '/^row_(\d+)_img$/', $key, $m ) ) {
					return 'row_' . $m[1];
				}
				return 'misc';

			case 'service':
				if ( 0 === strpos( $key, 'overview_' ) ) {
					return 'overview';
				}
				return 'misc';
		}

		return 'misc';
	}

	/**
	 * @return array<string, mixed>
	 */
	private static function make_tab_field( string $context, string $tab_id ): array {
		$label = self::tab_label( $context, $tab_id );

		return array(
			'key'       => 'field_hot_ctx_' . $context . '_img_tab_' . $tab_id,
			'label'     => $label,
			'name'      => '_hotelier_ctx_' . $context . '_img_tab_' . $tab_id,
			'type'      => 'tab',
			'placement' => 'top',
			'endpoint'  => 0,
			'wrapper'   => array( 'width' => '100' ),
		);
	}

	private static function tab_label( string $context, string $tab_id ): string {
		if ( 'portfolio' === $context && preg_match( '/^hotel_\d+$/', $tab_id ) ) {
			return Hotelier_Page_Meta_Schema::portfolio_hotel_tab_label( $tab_id );
		}
		if ( 'services' === $context && preg_match( '/^row_(\d+)$/', $tab_id, $m ) ) {
			return sprintf(
				/* translators: %d: services row number */
				__( 'Row %d', '360-hotelier' ),
				(int) $m[1]
			);
		}

		$labels = array(
			'hero'     => __( 'Hero', '360-hotelier' ),
			'intro'    => __( 'Intro', '360-hotelier' ),
			'what'     => __( 'What we do', '360-hotelier' ),
			'bio'      => __( 'Bio', '360-hotelier' ),
			'tl'       => __( 'Experience', '360-hotelier' ),
			'pendeli'  => __( 'Pendeli SVG', '360-hotelier' ),
			'overview' => __( 'Overview', '360-hotelier' ),
			'misc'     => __( 'Other', '360-hotelier' ),
		);

		return isset( $labels[ $tab_id ] ) ? $labels[ $tab_id ] : $tab_id;
	}

	/**
	 * @return array<string, mixed>
	 */
	private static function make_image_field( string $context, string $schema_key, string $label ): array {
		$mimes = 'jpg,jpeg,png,webp,avif';
		if ( self::allows_svg( $context, $schema_key ) ) {
			$mimes .= ',svg';
		}

		$field = array(
			'key'           => 'field_hot_ctx_' . $context . '_img_' . $schema_key,
			'label'         => $label,
			'name'          => self::field_name( $context, $schema_key ),
			'type'          => 'image',
			'return_format' => 'id',
			'preview_size'  => 'medium',
			'library'       => 'all',
			'mime_types'    => $mimes,
		);

		// Per-page slug-based defaults (service overview) can't be encoded as a static field default.
		if ( 'service' === $context && 'overview_img' === $schema_key ) {
			return $field;
		}

		$default_id = self::default_attachment_id_for_field( $context, $schema_key, 0 );
		if ( $default_id > 0 ) {
			$field['default_value'] = $default_id;
		}

		return $field;
	}

	private static function allows_svg( string $context, string $schema_key ): bool {
		if ( 'pendeli_svg' === $schema_key ) {
			return true;
		}
		if ( 'portfolio' === $context && preg_match( '/^hotel_\d+_logo$/', $schema_key ) ) {
			return true;
		}
		return false;
	}
}
