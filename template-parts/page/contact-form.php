<?php
/**
 * Contact page form (name, email, subject, message).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$contact_status = isset( $_GET['contact'] ) ? sanitize_text_field( wp_unslash( $_GET['contact'] ) ) : '';
?>
<div id="page-contact-form" class="page-contact__card card-border fade-in fade-in-delay-1">
	<h2 class="page-contact__card-title"><?php esc_html_e( 'Send us a message', '360-hotelier' ); ?></h2>

	<?php if ( 'sent' === $contact_status ) : ?>
		<p class="page-contact__form-notice page-contact__form-notice--success" role="status">
			<?php esc_html_e( 'Thank you — your message was sent. We will get back to you soon.', '360-hotelier' ); ?>
		</p>
	<?php elseif ( 'error' === $contact_status ) : ?>
		<p class="page-contact__form-notice page-contact__form-notice--error" role="alert">
			<?php esc_html_e( 'Something went wrong or required fields were missing. Please try again.', '360-hotelier' ); ?>
		</p>
	<?php endif; ?>

	<form
		class="page-contact__form"
		method="post"
		action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>"
	>
		<input type="hidden" name="action" value="<?php echo esc_attr( Hotelier_Contact_Form_Handler::ACTION ); ?>">
		<?php wp_nonce_field( Hotelier_Contact_Form_Handler::NONCE_ACTION, 'hotelier_contact_nonce' ); ?>

		<div class="page-contact__hp" aria-hidden="true">
			<label for="hotelier-contact-hp"><?php esc_html_e( 'Leave blank', '360-hotelier' ); ?></label>
			<input type="text" name="hotelier_contact_hp" id="hotelier-contact-hp" value="" tabindex="-1" autocomplete="off">
		</div>

		<div class="page-contact__field">
			<label for="hotelier-contact-name"><?php esc_html_e( 'Name', '360-hotelier' ); ?></label>
			<input
				type="text"
				name="hotelier_contact_name"
				id="hotelier-contact-name"
				required
				autocomplete="name"
				maxlength="120"
				placeholder="<?php echo esc_attr__( 'Your full name', '360-hotelier' ); ?>"
			>
		</div>

		<div class="page-contact__field">
			<label for="hotelier-contact-email"><?php esc_html_e( 'Email', '360-hotelier' ); ?></label>
			<input
				type="email"
				name="hotelier_contact_email"
				id="hotelier-contact-email"
				required
				autocomplete="email"
				placeholder="<?php echo esc_attr__( 'you@yourhotel.com', '360-hotelier' ); ?>"
			>
		</div>

		<div class="page-contact__field">
			<label for="hotelier-contact-subject"><?php esc_html_e( 'Subject', '360-hotelier' ); ?></label>
			<input
				type="text"
				name="hotelier_contact_subject"
				id="hotelier-contact-subject"
				required
				maxlength="200"
				placeholder="<?php echo esc_attr__( 'e.g., Revenue strategy consultation', '360-hotelier' ); ?>"
			>
		</div>

		<div class="page-contact__field">
			<label for="hotelier-contact-message"><?php esc_html_e( 'Message', '360-hotelier' ); ?></label>
			<textarea
				name="hotelier_contact_message"
				id="hotelier-contact-message"
				required
				rows="6"
				maxlength="8000"
				placeholder="<?php echo esc_attr__( 'Tell us about your property, your goals, and how we can help…', '360-hotelier' ); ?>"
			></textarea>
		</div>

		<div class="page-contact__form-submit">
			<button type="submit" class="btn btn--primary"><?php esc_html_e( 'Send message', '360-hotelier' ); ?></button>
		</div>
	</form>
</div>
