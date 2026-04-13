<?php
/**
 * Founder / Meet the Founder card: contact links from site-wide options (same data as top bar).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders stacked plain-text contact links (no icons).
 */
final class Hotelier_Founder_Card_Contact {

	/**
	 * Echo contact block markup.
	 */
	public static function render(): void {
		$o = Hotelier_Site_Content_Options::get();

		$tb_tel = preg_replace( '/\s+/', '', (string) $o['topbar_phone_href'] );
		if ( $tb_tel !== '' && strpos( $tb_tel, 'tel:' ) !== 0 ) {
			$tb_tel = 'tel:' . $tb_tel;
		}

		echo '<div class="founder-card-contact">';
		echo '<h3 class="founder-card-contact__title">' . esc_html( __( 'Contact', '360-hotelier' ) ) . '</h3>';
		echo '<div class="founder-card-contact__list">';

		if ( ! empty( $o['topbar_email'] ) ) {
			echo '<a class="founder-card-contact__link" href="' . esc_url( 'mailto:' . antispambot( $o['topbar_email'] ) ) . '">' . esc_html( $o['topbar_email'] ) . '</a>';
		}

		if ( ! empty( $o['topbar_phone_display'] ) && $tb_tel !== '' ) {
			echo '<a class="founder-card-contact__link" href="' . esc_url( $tb_tel ) . '">' . esc_html( $o['topbar_phone_display'] ) . '</a>';
		}

		$social_rows = array(
			array(
				'url'   => isset( $o['social_facebook'] ) ? (string) $o['social_facebook'] : '',
				'label' => __( 'Facebook', '360-hotelier' ),
			),
			array(
				'url'   => isset( $o['social_linkedin'] ) ? (string) $o['social_linkedin'] : '',
				'label' => __( 'LinkedIn', '360-hotelier' ),
			),
			array(
				'url'   => isset( $o['social_instagram'] ) ? (string) $o['social_instagram'] : '',
				'label' => __( 'Instagram', '360-hotelier' ),
			),
		);

		foreach ( $social_rows as $row ) {
			$url = trim( $row['url'] );
			if ( $url === '' ) {
				continue;
			}
			echo '<a class="founder-card-contact__link" href="' . esc_url( $url ) . '" rel="noopener noreferrer" target="_blank">' . esc_html( $row['label'] ) . '</a>';
		}

		echo '</div></div>';
	}
}
