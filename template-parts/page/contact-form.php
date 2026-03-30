<?php
/**
 * Contact page form (name, email, subject, message).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$page_id = (int) get_queried_object_id();
$ctx     = 'contact';

$contact_status = isset( $_GET['contact'] ) ? sanitize_text_field( wp_unslash( $_GET['contact'] ) ) : '';
?>
<div id="page-contact-form" class="page-contact__card card-border fade-in fade-in-delay-1">
	<h2 class="page-contact__card-title"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'form_title' ) ); ?></h2>

	<?php if ( 'sent' === $contact_status ) : ?>
		<p class="page-contact__form-notice page-contact__form-notice--success" role="status">
			<?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'form_success' ) ); ?>
		</p>
	<?php elseif ( 'error' === $contact_status ) : ?>
		<p class="page-contact__form-notice page-contact__form-notice--error" role="alert">
			<?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'form_error' ) ); ?>
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
			<label for="hotelier-contact-hp"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'form_hp_label' ) ); ?></label>
			<input type="text" name="hotelier_contact_hp" id="hotelier-contact-hp" value="" tabindex="-1" autocomplete="off">
		</div>

		<div class="page-contact__field">
			<label for="hotelier-contact-name"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'form_name_label' ) ); ?></label>
			<input
				type="text"
				name="hotelier_contact_name"
				id="hotelier-contact-name"
				required
				autocomplete="name"
				maxlength="120"
				placeholder="<?php echo esc_attr( Hotelier_Page_Content::get_text( $page_id, $ctx, 'form_name_ph' ) ); ?>"
			>
		</div>

		<div class="page-contact__field">
			<label for="hotelier-contact-email"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'form_email_label' ) ); ?></label>
			<input
				type="email"
				name="hotelier_contact_email"
				id="hotelier-contact-email"
				required
				autocomplete="email"
				placeholder="<?php echo esc_attr( Hotelier_Page_Content::get_text( $page_id, $ctx, 'form_email_ph' ) ); ?>"
			>
		</div>

		<div class="page-contact__field">
			<label for="hotelier-contact-subject"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'form_subject_label' ) ); ?></label>
			<input
				type="text"
				name="hotelier_contact_subject"
				id="hotelier-contact-subject"
				required
				maxlength="200"
				placeholder="<?php echo esc_attr( Hotelier_Page_Content::get_text( $page_id, $ctx, 'form_subject_ph' ) ); ?>"
			>
		</div>

		<div class="page-contact__field">
			<label for="hotelier-contact-message"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'form_message_label' ) ); ?></label>
			<textarea
				name="hotelier_contact_message"
				id="hotelier-contact-message"
				required
				rows="6"
				maxlength="8000"
				placeholder="<?php echo esc_attr( Hotelier_Page_Content::get_text( $page_id, $ctx, 'form_message_ph' ) ); ?>"
			></textarea>
		</div>

		<div class="page-contact__form-submit">
			<button type="submit" class="btn btn--primary"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'form_submit' ) ); ?></button>
		</div>
	</form>
</div>
