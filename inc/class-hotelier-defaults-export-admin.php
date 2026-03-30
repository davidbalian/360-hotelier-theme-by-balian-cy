<?php
/**
 * Admin: download JSON snapshot of site content + page meta (for theme repo sync).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers Settings → Site content footer export + admin-post handler.
 */
final class Hotelier_Defaults_Export_Admin {

	public const NONCE_ACTION = 'hotelier_export_defaults';

	public static function register(): void {
		add_action( 'admin_post_hotelier_export_defaults', array( self::class, 'handle_download' ) );
		add_action( 'hotelier_site_content_page_footer', array( self::class, 'render_export_box' ) );
	}

	public static function handle_download(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			wp_die( esc_html__( 'You do not have permission to export.', '360-hotelier' ), 403 );
		}
		check_admin_referer( self::NONCE_ACTION );

		$skip = ! empty( $_POST['hotelier_export_skip_attachment_ids'] );
		$sid  = isset( $_POST['hotelier_export_service_post_id'] ) ? absint( $_POST['hotelier_export_service_post_id'] ) : 0;

		$builder = new Hotelier_Defaults_Snapshot_Builder(
			HOTELIER_THEME_DIR,
			$skip,
			$sid > 0 ? $sid : null
		);
		$data    = $builder->build();

		$export = array_merge(
			array(
				'_hotelier_export' => array(
					'generated_at' => gmdate( 'c' ),
					'host'         => wp_parse_url( home_url(), PHP_URL_HOST ),
					'note'         => 'Use site_content and page_meta like inc/hotelier-db-defaults.sync.php. Remove _hotelier_export before converting to PHP if needed.',
				),
			),
			$data
		);

		nocache_headers();
		header( 'Content-Type: application/json; charset=utf-8' );
		header( 'Content-Disposition: attachment; filename="hotelier-db-defaults-export.json"' );

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo wp_json_encode( $export, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
		exit;
	}

	public static function render_export_box(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		$service_tpl = Hotelier_Page_Meta_Schema::page_template_for_context( 'service' );
		$svc_pages   = array();
		if ( $service_tpl ) {
			$svc_pages = get_posts(
				array(
					'post_type'              => 'page',
					'post_status'            => 'any',
					'posts_per_page'         => 200,
					'orderby'                => array(
						'menu_order' => 'ASC',
						'title'      => 'ASC',
					),
					'meta_key'               => '_wp_page_template',
					'meta_value'             => $service_tpl,
					'no_found_rows'          => true,
					'update_post_meta_cache' => false,
					'update_post_term_cache' => false,
				)
			);
		}

		?>
		<hr>
		<h2 class="title"><?php esc_html_e( 'Export for theme / development', '360-hotelier' ); ?></h2>
		<p class="description">
			<?php esc_html_e( 'Download a JSON file with the same structure as the theme sync file (site content + page field defaults). Share it with your developer or AI to refresh inc/hotelier-db-defaults.sync.php in the theme repository.', '360-hotelier' ); ?>
		</p>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="hotelier-export-defaults-form">
			<?php wp_nonce_field( self::NONCE_ACTION ); ?>
			<input type="hidden" name="action" value="hotelier_export_defaults">
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Service page context', '360-hotelier' ); ?></th>
					<td>
						<?php if ( ! empty( $svc_pages ) ) : ?>
							<select name="hotelier_export_service_post_id" id="hotelier-export-service-post">
								<option value="0"><?php esc_html_e( 'Auto (first by menu order)', '360-hotelier' ); ?></option>
								<?php foreach ( $svc_pages as $p ) : ?>
									<option value="<?php echo esc_attr( (string) (int) $p->ID ); ?>"><?php echo esc_html( get_the_title( $p ) . ' (ID ' . (int) $p->ID . ')' ); ?></option>
								<?php endforeach; ?>
							</select>
							<p class="description"><?php esc_html_e( 'Which single service page to use when exporting the “service” template fields.', '360-hotelier' ); ?></p>
						<?php else : ?>
							<input type="hidden" name="hotelier_export_service_post_id" value="0">
							<p class="description"><?php esc_html_e( 'No service template pages found.', '360-hotelier' ); ?></p>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Attachment IDs', '360-hotelier' ); ?></th>
					<td>
						<label>
							<input type="checkbox" name="hotelier_export_skip_attachment_ids" value="1">
							<?php esc_html_e( 'Export footer logo ID as 0 (more portable across WordPress installs)', '360-hotelier' ); ?>
						</label>
					</td>
				</tr>
			</table>
			<?php
			submit_button( __( 'Download JSON export', '360-hotelier' ), 'secondary', 'submit', false );
			?>
		</form>
		<?php
	}
}

Hotelier_Defaults_Export_Admin::register();
