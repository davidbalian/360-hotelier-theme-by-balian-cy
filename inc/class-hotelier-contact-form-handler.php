<?php
/**
 * Handles POST from the contact form via admin-post.php.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers hooks and processes contact form submissions.
 */
final class Hotelier_Contact_Form_Handler {

	public const ACTION       = 'hotelier_contact_submit';
	public const NONCE_ACTION = 'hotelier_contact_form';

	private const MAX_NAME_LEN    = 120;
	private const MAX_SUBJECT_LEN = 200;
	private const MAX_MESSAGE_LEN = 8000;

	/**
	 * Wire admin-post handlers.
	 */
	public static function register(): void {
		add_action( 'admin_post_nopriv_' . self::ACTION, array( self::class, 'handle_submit' ) );
		add_action( 'admin_post_' . self::ACTION, array( self::class, 'handle_submit' ) );
	}

	/**
	 * Process submission, send mail, redirect with status.
	 */
	public static function handle_submit(): void {
		if ( ! isset( $_POST['hotelier_contact_nonce'] )
			|| ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['hotelier_contact_nonce'] ) ), self::NONCE_ACTION ) ) {
			self::redirect_with_status( 'error' );
		}

		if ( ! empty( $_POST['hotelier_contact_hp'] ) ) {
			self::redirect_with_status( 'sent' );
		}

		$name    = isset( $_POST['hotelier_contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['hotelier_contact_name'] ) ) : '';
		$email   = isset( $_POST['hotelier_contact_email'] ) ? sanitize_email( wp_unslash( $_POST['hotelier_contact_email'] ) ) : '';
		$subject = isset( $_POST['hotelier_contact_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['hotelier_contact_subject'] ) ) : '';
		$message = isset( $_POST['hotelier_contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['hotelier_contact_message'] ) ) : '';

		$name    = mb_substr( $name, 0, self::MAX_NAME_LEN );
		$subject = mb_substr( $subject, 0, self::MAX_SUBJECT_LEN );
		$message = mb_substr( $message, 0, self::MAX_MESSAGE_LEN );

		if ( '' === $name || '' === $email || ! is_email( $email ) || '' === $subject || '' === $message ) {
			self::redirect_with_status( 'error' );
		}

		$to = apply_filters( 'hotelier_contact_recipient_email', get_option( 'admin_email' ) );
		if ( ! is_string( $to ) || '' === $to || ! is_email( $to ) ) {
			$to = get_option( 'admin_email' );
		}

		$site     = wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES );
		$mail_sub = sprintf(
			/* translators: 1: site name, 2: visitor subject */
			__( '[%1$s] Contact: %2$s', '360-hotelier' ),
			$site,
			$subject
		);

		$body = sprintf(
			/* translators: 1: name, 2: email, 3: message */
			__( "Name: %1\$s\nEmail: %2\$s\n\nMessage:\n%3\$s", '360-hotelier' ),
			$name,
			$email,
			$message
		);

		$headers = array(
			'Content-Type: text/plain; charset=UTF-8',
			'Reply-To: ' . $name . ' <' . $email . '>',
		);

		$sent = wp_mail( $to, $mail_sub, $body, $headers );
		self::redirect_with_status( $sent ? 'sent' : 'error' );
	}

	/**
	 * Redirect to contact page with query arg.
	 *
	 * @param string $status sent|error.
	 */
	private static function redirect_with_status( string $status ): void {
		$url = function_exists( 'hotelier_get_page_url_by_slug' ) ? hotelier_get_page_url_by_slug( 'contact' ) : '';
		if ( '' === $url ) {
			$url = home_url( '/' );
		}
		wp_safe_redirect( add_query_arg( 'contact', $status, $url ) );
		exit;
	}
}

Hotelier_Contact_Form_Handler::register();
