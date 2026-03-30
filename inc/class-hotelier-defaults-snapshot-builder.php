<?php
/**
 * Builds the site_content + page_meta snapshot (CLI and admin export).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Collects effective option + page meta for theme default sync / JSON export.
 */
final class Hotelier_Defaults_Snapshot_Builder {

	private string $theme_dir;

	private bool $skip_attachment_ids;

	/** @var int|null */
	private $service_post_id;

	public function __construct( string $theme_dir, bool $skip_attachment_ids = false, ?int $service_post_id = null ) {
		$this->theme_dir           = $theme_dir;
		$this->skip_attachment_ids = $skip_attachment_ids;
		$this->service_post_id     = $service_post_id;
	}

	/**
	 * @return array{site_content: array<string, mixed>, page_meta: array<string, array<string, array<string, mixed>>>}
	 */
	public function build(): array {
		return array(
			'site_content' => $this->build_site_content_payload(),
			'page_meta'    => $this->build_page_meta_payload(),
		);
	}

	/**
	 * @return array<string, mixed>
	 */
	private function build_site_content_payload(): array {
		$builtin = Hotelier_Site_Content_Options::builtin_defaults();
		$sync    = $this->read_existing_sync_array();
		$layer   = array_merge( $builtin, isset( $sync['site_content'] ) && is_array( $sync['site_content'] ) ? $sync['site_content'] : array() );
		$stored  = get_option( Hotelier_Site_Content_Options::OPTION_NAME, array() );
		if ( ! is_array( $stored ) ) {
			$stored = array();
		}
		$effective = array_merge( $layer, $stored );
		if ( $this->skip_attachment_ids ) {
			$effective['footer_logo_id'] = 0;
		}
		return $effective;
	}

	/**
	 * @return array<string, mixed>
	 */
	private function read_existing_sync_array(): array {
		$path = $this->theme_dir . '/inc/hotelier-db-defaults.sync.php';
		if ( ! is_readable( $path ) ) {
			return array();
		}
		/** @var mixed $data */
		$data = require $path;
		return is_array( $data ) ? $data : array();
	}

	/**
	 * @return array<string, array<string, array<string, mixed>>>
	 */
	private function build_page_meta_payload(): array {
		$baseline = Hotelier_Page_Meta_Schema::baseline_contexts();
		$out      = array();

		foreach ( array_keys( $baseline ) as $context ) {
			$post_id = $this->resolve_representative_post_id( (string) $context );
			if ( $post_id <= 0 ) {
				continue;
			}
			$fields = $baseline[ $context ];
			if ( ! is_array( $fields ) ) {
				continue;
			}
			$out[ $context ] = $this->patch_for_post( $post_id, (string) $context, $fields );
		}

		return $out;
	}

	public function resolve_representative_post_id( string $context ): int {
		if ( 'home' === $context ) {
			return (int) get_option( 'page_on_front' );
		}
		if ( 'service' === $context && null !== $this->service_post_id && $this->service_post_id > 0 ) {
			$pid      = (int) $this->service_post_id;
			$expected = Hotelier_Page_Meta_Schema::page_template_for_context( 'service' );
			if ( 'page' === get_post_type( $pid ) && $expected && get_page_template_slug( $pid ) === $expected ) {
				return $pid;
			}
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
				error_log( "Hotelier export/sync: service post ID {$pid} ignored (not a page with the service template)." );
			}
		}
		$template = Hotelier_Page_Meta_Schema::page_template_for_context( $context );
		if ( ! $template ) {
			return 0;
		}
		$posts = get_posts(
			array(
				'post_type'              => 'page',
				'post_status'            => array( 'publish', 'draft', 'pending' ),
				'posts_per_page'         => 1,
				'orderby'                => array(
					'menu_order' => 'ASC',
					'ID'         => 'ASC',
				),
				'meta_key'               => '_wp_page_template',
				'meta_value'             => $template,
				'no_found_rows'          => true,
				'update_post_meta_cache' => false,
				'update_post_term_cache' => false,
			)
		);
		if ( ! $posts || ! isset( $posts[0]->ID ) ) {
			return 0;
		}
		return (int) $posts[0]->ID;
	}

	/**
	 * @param array<string, mixed> $fields
	 * @return array<string, array<string, mixed>>
	 */
	private function patch_for_post( int $post_id, string $context, array $fields ): array {
		$patch = array();
		foreach ( $fields as $name => $def ) {
			if ( ! is_string( $name ) || ! is_array( $def ) ) {
				continue;
			}
			$type = isset( $def['type'] ) ? (string) $def['type'] : 'text';
			if ( 'image' === $type ) {
				$patch[ $name ] = array(
					'default_url' => $this->effective_image_url( $post_id, $context, $name, $def ),
				);
				continue;
			}
			if ( 'select' === $type ) {
				$patch[ $name ] = array(
					'default' => $this->effective_select( $post_id, $context, $name, $def ),
				);
				continue;
			}
			if ( 'textarea' === $type ) {
				$patch[ $name ] = array(
					'default' => $this->effective_text( $post_id, $context, $name, $def ),
				);
				continue;
			}
			$patch[ $name ] = array(
				'default' => $this->effective_text( $post_id, $context, $name, $def ),
			);
		}
		return $patch;
	}

	/**
	 * @param array<string, mixed> $def
	 */
	private function effective_text( int $post_id, string $context, string $field, array $def ): string {
		$key = Hotelier_Page_Meta_Schema::meta_key( $context, $field );
		$raw = get_post_meta( $post_id, $key, true );
		if ( is_string( $raw ) && $raw !== '' ) {
			return $raw;
		}
		return isset( $def['default'] ) ? (string) $def['default'] : '';
	}

	/**
	 * @param array<string, mixed> $def
	 */
	private function effective_select( int $post_id, string $context, string $field, array $def ): string {
		$options = isset( $def['options'] ) && is_array( $def['options'] ) ? $def['options'] : array();
		$keys    = array_keys( $options );
		$key     = Hotelier_Page_Meta_Schema::meta_key( $context, $field );
		$raw     = get_post_meta( $post_id, $key, true );
		$val     = is_string( $raw ) ? $raw : '';
		if ( $val !== '' && ( $keys === array() || in_array( $val, $keys, true ) ) ) {
			return $val;
		}
		return isset( $def['default'] ) ? (string) $def['default'] : '';
	}

	/**
	 * @param array<string, mixed> $def
	 */
	private function effective_image_url( int $post_id, string $context, string $field, array $def ): string {
		$key = Hotelier_Page_Meta_Schema::meta_key( $context, $field );
		$id  = (int) get_post_meta( $post_id, $key, true );
		if ( $id > 0 ) {
			$url = wp_get_attachment_image_url( $id, 'full' );
			if ( is_string( $url ) && $url !== '' ) {
				return $url;
			}
		}
		return isset( $def['default_url'] ) ? (string) $def['default_url'] : '';
	}
}
