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
	 *
	 * @param string $wrapper_extra_classes Optional space-separated classes on the root div (e.g. fade-in helpers).
	 */
	public static function render( string $wrapper_extra_classes = '' ): void {
		$o = Hotelier_Site_Content_Options::get();
		$email = isset( $o['topbar_email'] ) ? self::get_founder_email( (string) $o['topbar_email'] ) : '';

		$tb_tel = preg_replace( '/\s+/', '', (string) $o['topbar_phone_href'] );
		if ( $tb_tel !== '' && strpos( $tb_tel, 'tel:' ) !== 0 ) {
			$tb_tel = 'tel:' . $tb_tel;
		}

		$root_class = 'founder-card-contact';
		if ( $wrapper_extra_classes !== '' ) {
			$tokens = preg_split( '/\s+/', trim( $wrapper_extra_classes ), -1, PREG_SPLIT_NO_EMPTY );
			foreach ( $tokens as $token ) {
				$root_class .= ' ' . sanitize_html_class( $token );
			}
		}

		echo '<div class="' . esc_attr( $root_class ) . '">';
		echo '<div class="founder-card-contact__list">';

		if ( $email !== '' ) {
			echo '<a class="founder-card-contact__link" href="' . esc_url( 'mailto:' . antispambot( $email ) ) . '">' . esc_html( $email ) . '</a>';
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

	/**
	 * Use founder-specific mailbox for founder cards.
	 *
	 * @param string $email Site-level configured email.
	 * @return string
	 */
	private static function get_founder_email( string $email ): string {
		$email = trim( $email );
		if ( $email === '' ) {
			return '';
		}

		return (string) preg_replace( '/^info@/i', 'giorgos@', $email, 1 );
	}
}
