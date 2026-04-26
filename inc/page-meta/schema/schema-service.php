<?php
/**
 * Single service page field definitions (per child page under Services).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$u = content_url( '/uploads/2026/03/' );

return array(
	'hero_title'             => array( 'type' => 'text', 'label' => 'Hero — title', 'default' => '' ),
	'hero_subtitle'          => array( 'type' => 'textarea', 'label' => 'Hero — subtitle (first sentence / lead)', 'default' => '' ),
	'hero_bg'                => array( 'type' => 'image', 'label' => 'Hero — background', 'default_url' => $u . 'featured-360-hotelier.webp' ),
	'overview_heading'       => array( 'type' => 'text', 'label' => 'Overview — heading', 'default' => 'Overview' ),
	'intro'                  => array( 'type' => 'textarea', 'label' => 'Overview — full intro text', 'default' => '' ),
	'overview_img'           => array( 'type' => 'image', 'label' => 'Overview — image', 'default_url' => '' ),
	'overview_img_alt'       => array( 'type' => 'text', 'label' => 'Overview — image alt', 'default' => '' ),
	'deliver_heading'        => array( 'type' => 'text', 'label' => 'Deliverables — heading', 'default' => 'What We Deliver' ),
	'deliver_1'              => array( 'type' => 'textarea', 'label' => 'Deliverable 1', 'default' => '' ),
	'deliver_2'              => array( 'type' => 'textarea', 'label' => 'Deliverable 2', 'default' => '' ),
	'deliver_3'              => array( 'type' => 'textarea', 'label' => 'Deliverable 3', 'default' => '' ),
	'deliver_4'              => array( 'type' => 'textarea', 'label' => 'Deliverable 4', 'default' => '' ),
	'deliver_5'              => array( 'type' => 'textarea', 'label' => 'Deliverable 5', 'default' => '' ),

	'cta_feat_img'           => array( 'type' => 'image', 'label' => 'Bottom CTA — image', 'default_url' => $u . 'hotel-consulting-services-cyprus-360hotelier.webp' ),
	'cta_feat_title'         => array( 'type' => 'textarea', 'label' => 'Bottom CTA — title', 'default' => "Let's Build Your Hotel's Commercial Strategy" ),
	'cta_feat_text'          => array( 'type' => 'textarea', 'label' => 'Bottom CTA — text', 'default' => "Book a free strategy session and let's discuss how we can help your hotel grow." ),
	'cta_feat_primary'       => array( 'type' => 'text', 'label' => 'Bottom CTA — primary button', 'default' => 'Get in Touch' ),
	'cta_feat_secondary'     => array( 'type' => 'text', 'label' => 'Bottom CTA — secondary button', 'default' => 'All Services' ),
);
