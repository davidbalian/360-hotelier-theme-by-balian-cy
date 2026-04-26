<?php
/**
 * ACF local field group: homepage copy (English + Greek) on the static front page.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers bilingual text fields derived from {@see schema-home.php}.
 */
final class Hotelier_Home_Text_Acf_Field {

	private const GROUP_KEY = 'group_hotelier_home_text';

	public static function register(): void {
		add_action( 'acf/init', array( self::class, 'register_field_group' ) );
	}

	/**
	 * Meta field name for a schema key and language (en|el).
	 */
	public static function field_name( string $schema_key, string $lang ): string {
		return 'hotelier_home_' . $schema_key . '_' . $lang;
	}

	/**
	 * Schema keys (ordered) that are text or textarea on the home context.
	 *
	 * @return string[]
	 */
	public static function text_schema_keys(): array {
		$fields = Hotelier_Page_Meta_Schema::fields_for_context( 'home' );
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

	/**
	 * Whether this schema field is managed as ACF home copy.
	 */
	public static function is_text_schema_field( string $field ): bool {
		return in_array( $field, self::text_schema_keys(), true );
	}

	/**
	 * Value saved in ACF for the current request language, or '' if unset.
	 */
	public static function get_acf_value_for_request( string $schema_key ): string {
		if ( ! self::is_text_schema_field( $schema_key ) || ! function_exists( 'get_field' ) ) {
			return '';
		}
		$page_id = Hotelier_Page_Content::front_page_id();
		if ( $page_id <= 0 ) {
			return '';
		}
		$lang = ( function_exists( 'hotelier_get_current_lang' ) && 'el' === hotelier_get_current_lang() ) ? 'el' : 'en';
		$name = self::field_name( $schema_key, $lang );
		$raw  = get_field( $name, $page_id, false );
		if ( null === $raw || false === $raw ) {
			return '';
		}
		return trim( (string) $raw );
	}

	/**
	 * English default from schema `default`.
	 */
	public static function english_default_for_key( string $schema_key ): string {
		$fields = Hotelier_Page_Meta_Schema::fields_for_context( 'home' );
		if ( ! $fields || ! isset( $fields[ $schema_key ]['default'] ) ) {
			return '';
		}
		return (string) $fields[ $schema_key ]['default'];
	}

	/**
	 * Greek default: EL map when set, else English schema default.
	 */
	public static function greek_default_for_key( string $schema_key ): string {
		if ( class_exists( 'Hotelier_El_Page_Defaults' ) ) {
			$el = Hotelier_El_Page_Defaults::get( 'home', $schema_key );
			if ( is_string( $el ) && $el !== '' ) {
				return $el;
			}
		}
		return self::english_default_for_key( $schema_key );
	}

	public static function register_field_group(): void {
		if ( ! function_exists( 'acf_add_local_field_group' ) ) {
			return;
		}

		$acf_fields = array();
		$last_tab   = '';

		foreach ( self::text_schema_keys() as $schema_key ) {
			$tab = self::tab_id_for_schema_key( $schema_key );
			if ( $tab !== $last_tab ) {
				$acf_fields[] = self::make_tab_field( $tab );
				$last_tab     = $tab;
			}

			$fields_row = Hotelier_Page_Meta_Schema::fields_for_context( 'home' );
			$label_base = isset( $fields_row[ $schema_key ]['label'] ) ? (string) $fields_row[ $schema_key ]['label'] : $schema_key;
			$type       = isset( $fields_row[ $schema_key ]['type'] ) ? (string) $fields_row[ $schema_key ]['type'] : 'text';

			$acf_fields[] = self::make_subfield( $schema_key, 'en', $label_base, $type, self::english_default_for_key( $schema_key ) );
			$acf_fields[] = self::make_subfield( $schema_key, 'el', $label_base, $type, self::greek_default_for_key( $schema_key ) );
		}

		acf_add_local_field_group(
			array(
				'key'                   => self::GROUP_KEY,
				'title'                 => __( 'Homepage — text (EN / EL)', '360-hotelier' ),
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
				'menu_order'            => 25,
				'label_placement'       => 'top',
				'instruction_placement' => 'label',
				'active'                => true,
			)
		);
	}

	/**
	 * @return string Tab id (stable key for ACF field key suffix).
	 */
	private static function tab_id_for_schema_key( string $key ): string {
		if ( 0 === strpos( $key, 'hero_' ) ) {
			return 'hero';
		}
		if ( 0 === strpos( $key, 'services_' ) ) {
			return 'svc_overview';
		}
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
			'hero'          => __( 'Hero', '360-hotelier' ),
			'svc_overview'  => __( 'Services overview', '360-hotelier' ),
			'svc_cards'     => __( 'Service cards', '360-hotelier' ),
			'why'           => __( 'Why choose us', '360-hotelier' ),
			'results'       => __( 'Results', '360-hotelier' ),
			'approach'      => __( 'How we work', '360-hotelier' ),
			'feat'          => __( 'Featured banner', '360-hotelier' ),
			'founder'       => __( 'Founder', '360-hotelier' ),
			'contact_band'  => __( 'Contact band', '360-hotelier' ),
			'misc'          => __( 'Other', '360-hotelier' ),
		);

		$label = isset( $labels[ $tab_id ] ) ? $labels[ $tab_id ] : $tab_id;

		return array(
			'key'               => 'field_hot_home_tab_' . $tab_id,
			'label'             => $label,
			'name'              => '_hotelier_home_tab_' . $tab_id,
			'type'              => 'tab',
			'placement'         => 'top',
			'endpoint'          => 0,
			'wrapper'           => array( 'width' => '100' ),
		);
	}

	/**
	 * @return array<string, mixed>
	 */
	private static function make_subfield( string $schema_key, string $lang, string $label_base, string $schema_type, string $default_value ): array {
		$suffix   = ( 'el' === $lang ) ? __( ' (Greek)', '360-hotelier' ) : __( ' (English)', '360-hotelier' );
		$acf_type = ( 'textarea' === $schema_type ) ? 'textarea' : 'text';

		$row = array(
			'key'           => 'field_hot_home_' . $schema_key . '_' . $lang,
			'label'         => $label_base . $suffix,
			'name'          => self::field_name( $schema_key, $lang ),
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
