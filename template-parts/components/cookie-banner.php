<?php
/**
 * Fixed cookie consent strip (markup only; behavior in cookie-consent.js).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hotelier_legal = hotelier_get_footer_legal_urls();
$cookie_url     = isset( $hotelier_legal['cookie'] ) ? (string) $hotelier_legal['cookie'] : '';
$banner_id      = Hotelier_Cookie_Consent::BANNER_ID;
?>
<div
	id="<?php echo esc_attr( $banner_id ); ?>"
	class="cookie-banner"
	role="dialog"
	aria-label="<?php esc_attr_e( 'Cookie consent', '360-hotelier' ); ?>"
	hidden
>
	<p class="cookie-banner__text text-base-sm">
		<?php
		echo wp_kses(
			sprintf(
				/* translators: %s: Cookie policy link HTML. */
				__( 'We use cookies to improve your experience and for analytics. %s', '360-hotelier' ),
				'<a href="' . esc_url( $cookie_url ) . '" class="cookie-banner__policy-link">' . esc_html__( 'Cookie Policy', '360-hotelier' ) . '</a>'
			),
			array(
				'a' => array(
					'href'  => array(),
					'class' => array(),
				),
			)
		);
		?>
	</p>
	<div class="cookie-banner__actions">
		<button type="button" class="cookie-banner__accept btn btn--primary btn--sm">
			<?php esc_html_e( 'Accept', '360-hotelier' ); ?>
		</button>
		<button
			type="button"
			class="cookie-banner__close"
			aria-label="<?php esc_attr_e( 'Dismiss cookie banner', '360-hotelier' ); ?>"
		>
			&times;
		</button>
	</div>
</div>
