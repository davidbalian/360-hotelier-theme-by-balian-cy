<?php
/**
 * Admin asset enqueue for the Portfolio gallery picker.
 *
 * Single responsibility: load `wp.media` + the picker JS/CSS only on the
 * Portfolio page edit screen.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue the WP media library and our picker assets where appropriate.
 */
final class Hotelier_Portfolio_Gallery_Assets {

	public const HANDLE_JS  = 'hotelier-portfolio-gallery-picker';
	public const HANDLE_CSS = 'hotelier-portfolio-gallery-picker';

	public static function register(): void {
		add_action( 'admin_enqueue_scripts', array( self::class, 'maybe_enqueue' ) );
	}

	/**
	 * @param string $hook Current admin page hook (post.php / post-new.php).
	 */
	public static function maybe_enqueue( string $hook ): void {
		if ( ! self::is_target_screen( $hook ) ) {
			return;
		}

		wp_enqueue_media();

		$js_rel  = '/assets/js/admin/portfolio-gallery-picker.js';
		$css_rel = '/assets/css/admin/portfolio-gallery-picker.css';

		$js_path  = HOTELIER_THEME_DIR . $js_rel;
		$css_path = HOTELIER_THEME_DIR . $css_rel;

		$js_ver  = file_exists( $js_path ) ? (string) filemtime( $js_path ) : HOTELIER_THEME_VERSION;
		$css_ver = file_exists( $css_path ) ? (string) filemtime( $css_path ) : HOTELIER_THEME_VERSION;

		wp_enqueue_style(
			self::HANDLE_CSS,
			HOTELIER_THEME_URI . $css_rel,
			array(),
			$css_ver
		);

		wp_enqueue_script(
			self::HANDLE_JS,
			HOTELIER_THEME_URI . $js_rel,
			array( 'jquery' ),
			$js_ver,
			true
		);

		wp_localize_script(
			self::HANDLE_JS,
			'hotelierPortfolioGalleryL10n',
			array(
				'frameTitle'   => __( 'Select portfolio gallery images', '360-hotelier' ),
				'frameButton'  => __( 'Use these images', '360-hotelier' ),
				'removeLabel'  => __( 'Remove image', '360-hotelier' ),
				'countSingle'  => __( '%d image selected', '360-hotelier' ),
				'countPlural'  => __( '%d images selected', '360-hotelier' ),
				'confirmClear' => __( 'Remove all selected images?', '360-hotelier' ),
			)
		);
	}

	/**
	 * Only true on the post.php / post-new.php editor for a Portfolio page.
	 */
	private static function is_target_screen( string $hook ): bool {
		if ( $hook !== 'post.php' && $hook !== 'post-new.php' ) {
			return false;
		}

		$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;
		if ( ! $screen || $screen->post_type !== 'page' ) {
			return false;
		}

		$post_id = isset( $_GET['post'] ) ? (int) $_GET['post'] : 0; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( $post_id <= 0 ) {
			return false;
		}

		return Hotelier_Portfolio_Gallery_Meta_Box::is_portfolio_page( $post_id );
	}
}
