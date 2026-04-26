<?php
/**
 * Site-wide editable strings and images (Settings screen).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers Settings → Site content and helpers for the front end.
 */
	final class Hotelier_Site_Content_Options {

	public const OPTION_NAME = 'hotelier_site_content';

	public static function register(): void {
		add_action( 'admin_init', array( self::class, 'register_setting' ) );
		add_action( 'admin_menu', array( self::class, 'add_menu' ) );
	}

	public static function add_menu(): void {
		add_options_page(
			__( 'Site content', '360-hotelier' ),
			__( 'Site content', '360-hotelier' ),
			'manage_options',
			'hotelier-site-content',
			array( self::class, 'render_page' )
		);
	}

	public static function register_setting(): void {
		register_setting(
			'hotelier_site_content_group',
			self::OPTION_NAME,
			array(
				'type'              => 'array',
				'sanitize_callback' => array( self::class, 'sanitize' ),
				'default'           => self::defaults(),
			)
		);
	}

	/**
	 * Built-in defaults (theme code). Used by defaults() and JSON export.
	 *
	 * @return array<string, mixed>
	 */
	public static function builtin_defaults(): array {
		return array(
			'topbar_email'          => 'info@360hotelier.com',
			'topbar_phone_display'  => '7000 1818',
			'topbar_phone_href'     => '+35770001818',
			'contact_phone_display' => '7000 1818',
			'contact_phone_href'    => '+35770001818',
			'contact_email'         => 'info@360hotelier.com',
			'contact_address'       => '9, Epaminondou street, 3075, Limassol, Cyprus',
			'contact_map_query'     => '360° Hotelier Consulting Limassol',
			'label_phone'           => 'Phone',
			'label_email'           => 'Email',
			'label_address'         => 'Address',
			'footer_heading_nav'    => 'Navigation',
			'footer_heading_follow' => 'Social Media',
			'footer_heading_legal'  => 'Legal',
			'footer_heading_contact'  => 'Contact',
			'footer_copyright_name' => '360° Hotelier Consulting.',
			'footer_rights'         => 'All Rights Reserved.',
			'footer_credit_html'    => '<a href="https://balian.cy/" rel="noopener noreferrer" target="_blank">Balian Web Development Co.</a>',
			'footer_logo_id'        => 0,
			'social_facebook'       => '',
			'social_linkedin'       => '',
			'social_instagram'      => '',
		);
	}

	/**
	 * @return array<string, mixed>
	 */
	public static function defaults(): array {
		return self::builtin_defaults();
	}

	/**
	 * @param mixed $input Raw option.
	 * @return array<string, mixed>
	 */
	public static function sanitize( $input ): array {
		$base    = self::defaults();
		$input   = is_array( $input ) ? $input : array();
		$out     = $base;
		$text    = array(
			'topbar_email', 'topbar_phone_display', 'topbar_phone_href',
			'contact_phone_display', 'contact_phone_href', 'contact_email',
			'contact_address', 'contact_map_query',
			'label_phone', 'label_email', 'label_address',
			'footer_heading_nav', 'footer_heading_follow', 'footer_heading_legal', 'footer_heading_contact',
			'footer_copyright_name', 'footer_rights',
			'social_facebook', 'social_linkedin', 'social_instagram',
		);
		foreach ( $text as $k ) {
			if ( isset( $input[ $k ] ) ) {
				$out[ $k ] = sanitize_text_field( (string) $input[ $k ] );
			}
		}
		if ( isset( $input['footer_credit_html'] ) ) {
			$out['footer_credit_html'] = wp_kses_post( (string) $input['footer_credit_html'] );
		}
		$out['footer_logo_id'] = isset( $input['footer_logo_id'] ) ? absint( $input['footer_logo_id'] ) : 0;
		return $out;
	}

	/**
	 * @return array<string, mixed>
	 */
	public static function get(): array {
		$stored = get_option( self::OPTION_NAME, array() );
		if ( ! is_array( $stored ) ) {
			$stored = array();
		}
		$merged = array_merge( self::defaults(), $stored );

		return apply_filters( 'hotelier_site_content', $merged );
	}

	public static function get_text( string $key, string $fallback = '' ): string {
		$all = self::get();
		if ( isset( $all[ $key ] ) && is_string( $all[ $key ] ) && $all[ $key ] !== '' ) {
			return $all[ $key ];
		}
		return $fallback;
	}

	/**
	 * Default brand mark when no Customizer logo and no footer attachment (header fallback, footer, JSON-LD).
	 */
	public static function default_brand_logo_url(): string {
		return content_url( '/uploads/2026/04/360-hotelier-new-logo.webp' );
	}

	public static function footer_logo_url(): string {
		$all = self::get();
		$id  = isset( $all['footer_logo_id'] ) ? (int) $all['footer_logo_id'] : 0;
		if ( $id > 0 ) {
			$url = wp_get_attachment_image_url( $id, 'full' );
			if ( is_string( $url ) && $url !== '' ) {
				return $url;
			}
		}
		return self::default_brand_logo_url();
	}

	public static function render_page(): void {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		$v = self::get();
		?>
		<div class="wrap">
			<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action="options.php" method="post">
				<?php
				settings_fields( 'hotelier_site_content_group' );
				?>
				<h2 class="title"><?php esc_html_e( 'Top bar', '360-hotelier' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr><th><label for="h-topbar-email"><?php esc_html_e( 'Email', '360-hotelier' ); ?></label></th>
						<td><input class="regular-text" id="h-topbar-email" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[topbar_email]" type="text" value="<?php echo esc_attr( $v['topbar_email'] ); ?>"></td></tr>
					<tr><th><label for="h-topbar-phone-d"><?php esc_html_e( 'Phone (display)', '360-hotelier' ); ?></label></th>
						<td><input class="regular-text" id="h-topbar-phone-d" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[topbar_phone_display]" type="text" value="<?php echo esc_attr( $v['topbar_phone_display'] ); ?>"></td></tr>
					<tr><th><label for="h-topbar-phone-h"><?php esc_html_e( 'Phone (tel: href, e.g. +35770001818)', '360-hotelier' ); ?></label></th>
						<td><input class="regular-text" id="h-topbar-phone-h" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[topbar_phone_href]" type="text" value="<?php echo esc_attr( $v['topbar_phone_href'] ); ?>"></td></tr>
				</table>

				<h2 class="title"><?php esc_html_e( 'Contact details (Contact page, footer, map)', '360-hotelier' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr><th><label for="h-c-phone-d"><?php esc_html_e( 'Phone (display)', '360-hotelier' ); ?></label></th>
						<td><input class="regular-text" id="h-c-phone-d" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[contact_phone_display]" type="text" value="<?php echo esc_attr( $v['contact_phone_display'] ); ?>"></td></tr>
					<tr><th><label for="h-c-phone-h"><?php esc_html_e( 'Phone (tel: href)', '360-hotelier' ); ?></label></th>
						<td><input class="regular-text" id="h-c-phone-h" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[contact_phone_href]" type="text" value="<?php echo esc_attr( $v['contact_phone_href'] ); ?>"></td></tr>
					<tr><th><label for="h-c-email"><?php esc_html_e( 'Email', '360-hotelier' ); ?></label></th>
						<td><input class="regular-text" id="h-c-email" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[contact_email]" type="text" value="<?php echo esc_attr( $v['contact_email'] ); ?>"></td></tr>
					<tr><th><label for="h-c-addr"><?php esc_html_e( 'Address', '360-hotelier' ); ?></label></th>
						<td><textarea class="large-text" rows="2" id="h-c-addr" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[contact_address]"><?php echo esc_textarea( $v['contact_address'] ); ?></textarea></td></tr>
					<tr><th><label for="h-c-map"><?php esc_html_e( 'Map search query', '360-hotelier' ); ?></label></th>
						<td><input class="large-text" id="h-c-map" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[contact_map_query]" type="text" value="<?php echo esc_attr( $v['contact_map_query'] ); ?>"></td></tr>
					<tr><th><?php esc_html_e( 'Detail labels', '360-hotelier' ); ?></th>
						<td>
							<label><?php esc_html_e( 'Phone', '360-hotelier' ); ?> <input class="regular-text" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[label_phone]" type="text" value="<?php echo esc_attr( $v['label_phone'] ); ?>"></label><br><br>
							<label><?php esc_html_e( 'Email', '360-hotelier' ); ?> <input class="regular-text" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[label_email]" type="text" value="<?php echo esc_attr( $v['label_email'] ); ?>"></label><br><br>
							<label><?php esc_html_e( 'Address', '360-hotelier' ); ?> <input class="regular-text" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[label_address]" type="text" value="<?php echo esc_attr( $v['label_address'] ); ?>"></label>
						</td></tr>
				</table>

				<h2 class="title"><?php esc_html_e( 'Footer', '360-hotelier' ); ?></h2>
				<table class="form-table" role="presentation">
					<tr><th><?php esc_html_e( 'Column headings', '360-hotelier' ); ?></th>
						<td>
							<label><?php esc_html_e( 'Navigation', '360-hotelier' ); ?> <input class="regular-text" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[footer_heading_nav]" type="text" value="<?php echo esc_attr( $v['footer_heading_nav'] ); ?>"></label><br><br>
							<label><?php esc_html_e( 'Social Media', '360-hotelier' ); ?> <input class="regular-text" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[footer_heading_follow]" type="text" value="<?php echo esc_attr( $v['footer_heading_follow'] ); ?>"></label><br><br>
							<label><?php esc_html_e( 'Legal', '360-hotelier' ); ?> <input class="regular-text" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[footer_heading_legal]" type="text" value="<?php echo esc_attr( $v['footer_heading_legal'] ); ?>"></label><br><br>
							<label><?php esc_html_e( 'Contact', '360-hotelier' ); ?> <input class="regular-text" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[footer_heading_contact]" type="text" value="<?php echo esc_attr( $v['footer_heading_contact'] ); ?>"></label>
						</td></tr>
					<tr><th><label for="h-f-copy"><?php esc_html_e( 'Copyright name line', '360-hotelier' ); ?></label></th>
						<td><input class="large-text" id="h-f-copy" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[footer_copyright_name]" type="text" value="<?php echo esc_attr( $v['footer_copyright_name'] ); ?>"> <p class="description"><?php esc_html_e( 'Shown after the © year.', '360-hotelier' ); ?></p></td></tr>
					<tr><th><label for="h-f-rights"><?php esc_html_e( 'Rights reserved text', '360-hotelier' ); ?></label></th>
						<td><input class="large-text" id="h-f-rights" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[footer_rights]" type="text" value="<?php echo esc_attr( $v['footer_rights'] ); ?>"></td></tr>
					<tr><th><label for="h-f-credit"><?php esc_html_e( 'Credit HTML', '360-hotelier' ); ?></label></th>
						<td><textarea class="large-text code" rows="3" id="h-f-credit" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[footer_credit_html]"><?php echo esc_textarea( $v['footer_credit_html'] ); ?></textarea></td></tr>
					<tr><th><label for="h-f-logo"><?php esc_html_e( 'Footer logo attachment ID', '360-hotelier' ); ?></label></th>
						<td><input class="small-text" id="h-f-logo" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[footer_logo_id]" type="number" min="0" step="1" value="<?php echo esc_attr( (string) (int) $v['footer_logo_id'] ); ?>"> <p class="description"><?php esc_html_e( '0 = default theme asset.', '360-hotelier' ); ?></p></td></tr>
					<tr><th><?php esc_html_e( 'Social URLs', '360-hotelier' ); ?></th>
						<td>
							<label>Facebook <input class="large-text" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[social_facebook]" type="url" value="<?php echo esc_attr( $v['social_facebook'] ); ?>"></label><br><br>
							<label>LinkedIn <input class="large-text" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[social_linkedin]" type="url" value="<?php echo esc_attr( $v['social_linkedin'] ); ?>"></label><br><br>
							<label>Instagram <input class="large-text" name="<?php echo esc_attr( self::OPTION_NAME ); ?>[social_instagram]" type="url" value="<?php echo esc_attr( $v['social_instagram'] ); ?>"></label>
						</td></tr>
				</table>

				<?php submit_button(); ?>
			</form>
			<?php do_action( 'hotelier_site_content_page_footer' ); ?>
		</div>
		<?php
	}
}

Hotelier_Site_Content_Options::register();
