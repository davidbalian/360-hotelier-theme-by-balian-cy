<?php
/**
 * ACF local field groups: bilingual copy for About, Founder, and Portfolio templates.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers EN/EL text fields from schema for inner page contexts.
 */
final class Hotelier_Context_Page_Text_Acf_Field {

	/** @var string[] */
	private const CONTEXTS = array( 'about', 'founder', 'portfolio' );

	/**
	 * @var array<string, string> context => page template path
	 */
	private const CONTEXT_TEMPLATE = array(
		'about'     => 'page-templates/template-about.php',
		'founder'   => 'page-templates/template-founder.php',
		'portfolio' => 'page-templates/template-portfolio.php',
	);

	public static function register(): void {
		add_action( 'acf/init', array( self::class, 'register_field_groups' ) );
	}

	/**
	 * Page IDs using the template mapped to this schema context.
	 *
	 * @return int[]
	 */
	public static function page_ids_for_context( string $context ): array {
		if ( ! isset( self::CONTEXT_TEMPLATE[ $context ] ) ) {
			return array();
		}
		$template = self::CONTEXT_TEMPLATE[ $context ];
		$found    = get_posts(
			array(
				'post_type'      => 'page',
				'post_status'    => 'any',
				'posts_per_page' => -1,
				'fields'         => 'ids',
				'meta_key'       => '_wp_page_template',
				'meta_value'     => $template,
			)
		);
		return array_map( 'intval', $found );
	}

	/**
	 * Meta field name for a context, schema key, and language (en|el).
	 */
	public static function field_name( string $context, string $schema_key, string $lang ): string {
		return 'hotelier_' . $context . '_' . $schema_key . '_' . $lang;
	}

	/**
	 * @return string[]
	 */
	public static function managed_contexts(): array {
		return self::CONTEXTS;
	}

	/**
	 * Schema keys (schema order) that are text or textarea for a context.
	 *
	 * @return string[]
	 */
	public static function text_schema_keys( string $context ): array {
		$fields = Hotelier_Page_Meta_Schema::fields_for_context( $context );
		if ( ! $fields ) {
			return array();
		}
		$keys = array();
		foreach ( $fields as $key => $def ) {
			$type = isset( $def['type'] ) ? (string) $def['type'] : '';
			if ( 'text' === $type || 'textarea' === $type ) {
				$keys[] = (string) $key;
			}
		}
		return $keys;
	}

	public static function is_managed_text_field( string $context, string $field ): bool {
		if ( ! in_array( $context, self::CONTEXTS, true ) ) {
			return false;
		}
		return in_array( $field, self::text_schema_keys( $context ), true );
	}

	/**
	 * Value from ACF for the current request language, or ''.
	 */
	public static function get_acf_value_for_post( int $post_id, string $context, string $schema_key ): string {
		if ( $post_id <= 0 || ! self::is_managed_text_field( $context, $schema_key ) || ! function_exists( 'get_field' ) ) {
			return '';
		}
		$lang = ( function_exists( 'hotelier_get_current_lang' ) && 'el' === hotelier_get_current_lang() ) ? 'el' : 'en';
		$name = self::field_name( $context, $schema_key, $lang );
		$raw  = get_field( $name, $post_id, false );
		if ( null === $raw || false === $raw ) {
			return '';
		}
		return trim( (string) $raw );
	}

	public static function english_default_for_key( string $context, string $schema_key ): string {
		$fields = Hotelier_Page_Meta_Schema::fields_for_context( $context );
		if ( ! $fields || ! isset( $fields[ $schema_key ]['default'] ) ) {
			return '';
		}
		return (string) $fields[ $schema_key ]['default'];
	}

	public static function greek_default_for_key( string $context, string $schema_key ): string {
		if ( class_exists( 'Hotelier_El_Page_Defaults' ) ) {
			$el = Hotelier_El_Page_Defaults::get( $context, $schema_key );
			if ( is_string( $el ) && $el !== '' ) {
				return $el;
			}
		}
		return self::english_default_for_key( $context, $schema_key );
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
		$keys     = self::text_schema_keys( $context );
		if ( $keys === array() ) {
			return;
		}

		$acf_fields = array();
		$last_tab   = '';

		foreach ( $keys as $schema_key ) {
			$tab = self::tab_id( $context, $schema_key );
			if ( $tab !== $last_tab ) {
				$acf_fields[] = self::make_tab_field( $context, $tab );
				$last_tab     = $tab;
			}

			$row        = Hotelier_Page_Meta_Schema::fields_for_context( $context );
			$label_base = isset( $row[ $schema_key ]['label'] ) ? (string) $row[ $schema_key ]['label'] : $schema_key;
			$type       = isset( $row[ $schema_key ]['type'] ) ? (string) $row[ $schema_key ]['type'] : 'text';

			$acf_fields[] = self::make_subfield( $context, $schema_key, 'en', $label_base, $type, self::english_default_for_key( $context, $schema_key ) );
			$acf_fields[] = self::make_subfield( $context, $schema_key, 'el', $label_base, $type, self::greek_default_for_key( $context, $schema_key ) );
		}

		$titles = array(
			'about'     => __( 'About page — text (EN / EL)', '360-hotelier' ),
			'founder'   => __( 'Founder page — text (EN / EL)', '360-hotelier' ),
			'portfolio' => __( 'Portfolio page — text (EN / EL)', '360-hotelier' ),
		);

		acf_add_local_field_group(
			array(
				'key'                   => 'group_hotelier_ctx_' . $context . '_text',
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
				'menu_order'            => 27,
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'active'                => true,
			)
		);
	}

	private static function tab_id( string $context, string $key ): string {
		switch ( $context ) {
			case 'about':
				if ( 0 === strpos( $key, 'hero_' ) ) {
					return 'hero';
				}
				if ( 0 === strpos( $key, 'intro_' ) ) {
					return 'intro';
				}
				if ( 0 === strpos( $key, 'what_' ) ) {
					return 'what';
				}
				if ( 0 === strpos( $key, 'cta_feat_' ) ) {
					return 'cta';
				}
				return 'misc';

			case 'founder':
				if ( 0 === strpos( $key, 'hero_' ) ) {
					return 'hero';
				}
				if ( 0 === strpos( $key, 'bio_' ) ) {
					return 'bio';
				}
				if ( 0 === strpos( $key, 'tl_' ) ) {
					return 'tl';
				}
				if ( 0 === strpos( $key, 'cta_feat_' ) ) {
					return 'cta';
				}
				return 'misc';

			case 'portfolio':
				if ( 0 === strpos( $key, 'hero_' ) ) {
					return 'hero';
				}
				if ( 0 === strpos( $key, 'intro_' ) ) {
					return 'intro';
				}
				if ( 0 === strpos( $key, 'partners_' ) ) {
					return 'partners';
				}
				if ( 0 === strpos( $key, 'gallery_' ) ) {
					return 'gallery';
				}
				if ( 0 === strpos( $key, 'testimonials_' ) ) {
					return 'testimonials';
				}
				if ( preg_match( '/^testimonial_(\d+)_/', $key, $m ) ) {
					return 'testimonial_' . $m[1];
				}
				if ( preg_match( '/^hotel_(\d+)_/', $key, $m ) ) {
					return 'hotel_' . $m[1];
				}
				if ( 0 === strpos( $key, 'visit_' ) ) {
					return 'partners';
				}
				if ( 0 === strpos( $key, 'pendeli_' ) ) {
					return 'pendeli';
				}
				if ( 0 === strpos( $key, 'cta_feat_' ) ) {
					return 'cta';
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
			'key'               => 'field_hot_ctx_' . $context . '_tab_' . $tab_id,
			'label'             => $label,
			'name'              => '_hotelier_ctx_' . $context . '_tab_' . $tab_id,
			'type'              => 'tab',
			'placement'         => 'top',
			'endpoint'          => 0,
			'wrapper'           => array( 'width' => '100' ),
		);
	}

	private static function tab_label( string $context, string $tab_id ): string {
		if ( 'portfolio' === $context && preg_match( '/^hotel_(\d+)$/', $tab_id, $m ) ) {
			return sprintf(
				/* translators: %d: hotel slot number */
				__( 'Hotel %d', '360-hotelier' ),
				(int) $m[1]
			);
		}
		if ( 'portfolio' === $context && preg_match( '/^testimonial_(\d+)$/', $tab_id, $m ) ) {
			return sprintf(
				/* translators: %d: testimonial number */
				__( 'Testimonial %d', '360-hotelier' ),
				(int) $m[1]
			);
		}

		$labels = array(
			'hero'          => __( 'Hero', '360-hotelier' ),
			'intro'         => __( 'Intro', '360-hotelier' ),
			'what'          => __( 'What we do', '360-hotelier' ),
			'bio'           => __( 'Bio', '360-hotelier' ),
			'tl'            => __( 'Experience', '360-hotelier' ),
			'partners'      => __( 'Partners', '360-hotelier' ),
			'gallery'       => __( 'Gallery (headings)', '360-hotelier' ),
			'testimonials'  => __( 'Testimonials (headings)', '360-hotelier' ),
			'pendeli'       => __( 'Pendeli', '360-hotelier' ),
			'cta'           => __( 'Bottom CTA', '360-hotelier' ),
			'misc'          => __( 'Other', '360-hotelier' ),
		);

		return isset( $labels[ $tab_id ] ) ? $labels[ $tab_id ] : $tab_id;
	}

	/**
	 * @return array<string, mixed>
	 */
	private static function make_subfield( string $context, string $schema_key, string $lang, string $label_base, string $schema_type, string $default_value ): array {
		$suffix   = ( 'el' === $lang ) ? __( ' (Greek)', '360-hotelier' ) : __( ' (English)', '360-hotelier' );
		$acf_type = ( 'textarea' === $schema_type ) ? 'textarea' : 'text';

		$row = array(
			'key'           => 'field_hot_ctx_' . $context . '_' . $schema_key . '_' . $lang,
			'label'         => $label_base . $suffix,
			'name'          => self::field_name( $context, $schema_key, $lang ),
			'type'          => $acf_type,
			'default_value' => $default_value,
			'wrapper'       => array( 'width' => '50' ),
		);

		if ( 'textarea' === $acf_type ) {
			$row['rows']      = 3;
			$row['new_lines'] = '';
		}

		return $row;
	}
}
