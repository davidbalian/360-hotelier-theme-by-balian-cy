<?php
/**
 * Registers meta box and admin assets for page content.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hooks for Hotelier page meta UI.
 */
final class Hotelier_Page_Meta_Registry {

	public static function register(): void {
		add_action( 'add_meta_boxes', array( self::class, 'add_box' ) );
		add_action( 'admin_enqueue_scripts', array( self::class, 'enqueue' ) );
		Hotelier_Page_Meta_Sanitizer::register();
	}

	public static function add_box(): void {
		add_meta_box(
			'hotelier_page_content',
			__( 'Page content (360 Hotelier)', '360-hotelier' ),
			array( self::class, 'render_box' ),
			'page',
			'normal',
			'high'
		);
	}

	public static function render_box( WP_Post $post ): void {
		$ctx = Hotelier_Page_Meta_Schema::context_for_post_id( (int) $post->ID );
		if ( null === $ctx ) {
			echo '<p>' . esc_html__( 'This page template does not use editable theme fields. Assign a Hotelier template or set as the static front page.', '360-hotelier' ) . '</p>';
			return;
		}
		Hotelier_Page_Meta_Renderer::render( $post );
	}

	public static function enqueue( string $hook ): void {
		if ( 'post.php' !== $hook && 'post-new.php' !== $hook ) {
			return;
		}
		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || 'page' !== $screen->post_type ) {
			return;
		}

		wp_enqueue_media();

		$rel = '/assets/js/hotelier-page-meta-admin.js';
		$path = HOTELIER_THEME_DIR . $rel;
		$ver  = file_exists( $path ) ? (string) filemtime( $path ) : HOTELIER_THEME_VERSION;

		wp_enqueue_script(
			'hotelier-page-meta-admin',
			HOTELIER_THEME_URI . $rel,
			array( 'jquery' ),
			$ver,
			true
		);
	}
}
