<?php
/**
 * Portfolio gallery meta box: registration, render, save.
 *
 * Single responsibility: WordPress meta-box lifecycle for the portfolio
 * gallery picker. Persistence is delegated to {@see Hotelier_Portfolio_Gallery_Store}.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers and handles the Portfolio Gallery meta box on the page editor.
 */
final class Hotelier_Portfolio_Gallery_Meta_Box {

	public const META_BOX_ID  = 'hotelier-portfolio-gallery';
	public const NONCE_NAME   = 'hotelier_portfolio_gallery_nonce';
	public const NONCE_ACTION = 'hotelier_portfolio_gallery_save';
	public const INPUT_NAME   = 'hotelier_portfolio_gallery_ids';
	public const TEMPLATE     = 'page-templates/template-portfolio.php';

	public static function register(): void {
		add_action( 'add_meta_boxes_page', array( self::class, 'maybe_add_meta_box' ) );
		add_action( 'save_post_page', array( self::class, 'handle_save' ), 10, 2 );
	}

	/**
	 * Add the meta box only when the page uses the Portfolio template.
	 */
	public static function maybe_add_meta_box( WP_Post $post ): void {
		if ( ! self::is_portfolio_page( $post->ID ) ) {
			return;
		}

		add_meta_box(
			self::META_BOX_ID,
			__( 'Portfolio Gallery (shared between EN & GR)', '360-hotelier' ),
			array( self::class, 'render' ),
			'page',
			'normal',
			'high'
		);
	}

	/**
	 * Render the picker UI: hidden CSV input + thumbnails container.
	 */
	public static function render( WP_Post $post ): void {
		wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME );

		$ids = Hotelier_Portfolio_Gallery_Store::get_attachment_ids( $post->ID );
		$csv = implode( ',', $ids );

		?>
		<div class="hotelier-pg-picker" data-hotelier-portfolio-gallery>
			<p class="hotelier-pg-picker__caption">
				<?php esc_html_e( 'Pick the images that appear in the marquee below the partner cards. The first half of your selection appears in the top row, the second half in the bottom row. Drag thumbnails to reorder. Shared between English and Greek versions of the page.', '360-hotelier' ); ?>
			</p>

			<input
				type="hidden"
				name="<?php echo esc_attr( self::INPUT_NAME ); ?>"
				value="<?php echo esc_attr( $csv ); ?>"
				data-hotelier-pg-input
			/>

			<div class="hotelier-pg-picker__actions">
				<button type="button" class="button button-primary" data-hotelier-pg-open>
					<?php esc_html_e( 'Add / edit images', '360-hotelier' ); ?>
				</button>
				<button type="button" class="button button-link-delete" data-hotelier-pg-clear<?php echo empty( $ids ) ? ' hidden' : ''; ?>>
					<?php esc_html_e( 'Remove all', '360-hotelier' ); ?>
				</button>
				<span class="hotelier-pg-picker__count" data-hotelier-pg-count>
					<?php
					/* translators: %d: number of images currently selected. */
					echo esc_html( sprintf( _n( '%d image selected', '%d images selected', count( $ids ), '360-hotelier' ), count( $ids ) ) );
					?>
				</span>
			</div>

			<ul
				class="hotelier-pg-picker__grid"
				data-hotelier-pg-grid
				aria-label="<?php esc_attr_e( 'Selected gallery images, drag to reorder.', '360-hotelier' ); ?>"
			>
				<?php foreach ( $ids as $id ) : ?>
					<?php self::render_thumb_li( (int) $id ); ?>
				<?php endforeach; ?>
			</ul>
		</div>
		<?php
	}

	/**
	 * Render a single thumbnail <li> for server-side initial paint.
	 * The JS clones this same structure when adding new picks.
	 */
	private static function render_thumb_li( int $attachment_id ): void {
		$thumb = wp_get_attachment_image_src( $attachment_id, 'thumbnail' );
		if ( ! is_array( $thumb ) || empty( $thumb[0] ) ) {
			return;
		}
		$alt = (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
		?>
		<li
			class="hotelier-pg-picker__thumb"
			data-hotelier-pg-thumb
			data-id="<?php echo esc_attr( (string) $attachment_id ); ?>"
			draggable="true"
		>
			<img src="<?php echo esc_url( $thumb[0] ); ?>" alt="<?php echo esc_attr( $alt ); ?>" />
			<button
				type="button"
				class="hotelier-pg-picker__remove"
				data-hotelier-pg-remove
				aria-label="<?php esc_attr_e( 'Remove image', '360-hotelier' ); ?>"
			>&times;</button>
		</li>
		<?php
	}

	/**
	 * Persist gallery IDs on save_post.
	 */
	public static function handle_save( int $post_id, WP_Post $post ): void {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
			return;
		}
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		if ( ! isset( $_POST[ self::NONCE_NAME ] ) ) {
			return;
		}
		$nonce = sanitize_text_field( wp_unslash( (string) $_POST[ self::NONCE_NAME ] ) );
		if ( ! wp_verify_nonce( $nonce, self::NONCE_ACTION ) ) {
			return;
		}
		if ( ! self::is_portfolio_page( $post_id ) ) {
			return;
		}

		$raw = isset( $_POST[ self::INPUT_NAME ] ) ? (string) wp_unslash( $_POST[ self::INPUT_NAME ] ) : '';
		$ids = Hotelier_Portfolio_Gallery_Store::parse_csv( $raw );
		Hotelier_Portfolio_Gallery_Store::save_attachment_ids( $post_id, $ids );
	}

	/**
	 * Whether a page record uses the Portfolio template.
	 */
	public static function is_portfolio_page( int $post_id ): bool {
		if ( $post_id <= 0 ) {
			return false;
		}
		$template = (string) get_page_template_slug( $post_id );
		return self::TEMPLATE === $template;
	}
}
