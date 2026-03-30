<?php
/**
 * Contact page field definitions (hero, form copy, CTAs). Contact details live in site options.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$u = content_url( '/uploads/2026/03/' );

return array(
	'hero_title'             => array( 'type' => 'text', 'label' => 'Hero — title', 'default' => 'Contact' ),
	'hero_tagline'           => array( 'type' => 'textarea', 'label' => 'Hero — tagline', 'default' => "Grow Your Hotel's Revenue & Distribution." ),
	'hero_subtitle'          => array( 'type' => 'textarea', 'label' => 'Hero — subtitle', 'default' => "Tell us about your property. We'll identify where the revenue opportunity is." ),
	'hero_bg'                => array( 'type' => 'image', 'label' => 'Hero — background', 'default_url' => $u . 'featured-360-hotelier.webp' ),

	'card_title'             => array( 'type' => 'text', 'label' => 'Details card — title', 'default' => 'Contact Us Directly' ),

	'form_title'             => array( 'type' => 'text', 'label' => 'Form — title', 'default' => 'Send us a message' ),
	'form_success'           => array( 'type' => 'textarea', 'label' => 'Form — success message', 'default' => 'Thank you — your message was sent. We will get back to you soon.' ),
	'form_error'             => array( 'type' => 'textarea', 'label' => 'Form — error message', 'default' => 'Something went wrong or required fields were missing. Please try again.' ),
	'form_hp_label'          => array( 'type' => 'text', 'label' => 'Form — honeypot label', 'default' => 'Leave blank' ),
	'form_name_label'        => array( 'type' => 'text', 'label' => 'Form — name label', 'default' => 'Name' ),
	'form_name_ph'           => array( 'type' => 'text', 'label' => 'Form — name placeholder', 'default' => 'Your full name' ),
	'form_email_label'       => array( 'type' => 'text', 'label' => 'Form — email label', 'default' => 'Email' ),
	'form_email_ph'          => array( 'type' => 'text', 'label' => 'Form — email placeholder', 'default' => 'you@yourhotel.com' ),
	'form_subject_label'     => array( 'type' => 'text', 'label' => 'Form — subject label', 'default' => 'Subject' ),
	'form_subject_ph'        => array( 'type' => 'text', 'label' => 'Form — subject placeholder', 'default' => 'e.g., Revenue strategy consultation' ),
	'form_message_label'     => array( 'type' => 'text', 'label' => 'Form — message label', 'default' => 'Message' ),
	'form_message_ph'        => array( 'type' => 'textarea', 'label' => 'Form — message placeholder', 'default' => 'Tell us about your property, your goals, and how we can help…' ),
	'form_submit'            => array( 'type' => 'text', 'label' => 'Form — submit button', 'default' => 'Send message' ),

	'cta_feat_img'           => array( 'type' => 'image', 'label' => 'Bottom CTA — image', 'default_url' => $u . 'featured-360-hotelier.webp' ),
	'cta_feat_title'         => array( 'type' => 'text', 'label' => 'Bottom CTA — title', 'default' => 'Book a Free Strategy Session' ),
	'cta_feat_text'          => array( 'type' => 'textarea', 'label' => 'Bottom CTA — text', 'default' => "Tell us about your hotel. We'll show you where the revenue opportunity is — no cost, no commitment." ),
	'cta_feat_primary'       => array( 'type' => 'text', 'label' => 'Bottom CTA — button', 'default' => 'Book a Free Strategy Session' ),
);
