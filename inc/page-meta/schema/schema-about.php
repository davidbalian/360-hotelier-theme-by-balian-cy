<?php
/**
 * About page field definitions.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$u = content_url( '/uploads/2026/03/' );

return array(
	'hero_title'             => array( 'type' => 'text', 'label' => 'Hero — title', 'default' => 'About Us' ),
	'hero_tagline'           => array( 'type' => 'textarea', 'label' => 'Hero — tagline', 'default' => 'Hotel Consulting Built for Cyprus' ),
	'hero_subtitle'          => array( 'type' => 'textarea', 'label' => 'Hero — subtitle', 'default' => '15+ years of hospitality experience. We grow revenue for independent hotels across Cyprus.' ),
	'hero_bg'                => array( 'type' => 'image', 'label' => 'Hero — background', 'default_url' => $u . 'featured-360-hotelier.webp' ),

	'intro_h2'               => array( 'type' => 'text', 'label' => 'Intro — heading', 'default' => 'About 360° Hotelier Consulting' ),
	'intro_p1'               => array( 'type' => 'textarea', 'label' => 'Intro — paragraph 1', 'default' => '360° Hotelier Consulting is a Cyprus-based hotel consultancy providing strategic commercial support to independent hotels, boutique properties and resorts across the island.' ),
	'intro_p2'               => array( 'type' => 'textarea', 'label' => 'Intro — paragraph 2', 'default' => 'We specialize in hotel revenue management, online sales & B2B distribution, e-commerce, digital marketing and tour-operator contracting — helping hotels increase revenue and improve profitability.' ),
	'intro_p3'               => array( 'type' => 'textarea', 'label' => 'Intro — paragraph 3', 'default' => "With 15+ years in hospitality, we work hands-on across pricing, channels and digital. We keep our client list small to stay fully accountable to each hotel." ),
	'intro_side_img'         => array( 'type' => 'image', 'label' => 'Intro — side image', 'default_url' => $u . 'why-choose-360-hotelier.webp' ),

	'what_title'             => array( 'type' => 'text', 'label' => 'What we do — title', 'default' => 'What We Do' ),
	'what_subtitle'          => array( 'type' => 'textarea', 'label' => 'What we do — subtitle', 'default' => "End-to-end commercial consulting tailored to each property's market and goals." ),
	'what_1_title'           => array( 'type' => 'text', 'label' => 'What box 1 — title', 'default' => 'Yield & Revenue Management' ),
	'what_1_text'            => array( 'type' => 'textarea', 'label' => 'What box 1 — text', 'default' => 'Strategic pricing, demand forecasting and segmentation designed to maximize RevPAR and revenue performance.' ),
	'what_2_title'           => array( 'type' => 'text', 'label' => 'What box 2 — title', 'default' => 'Online Sales & B2B Distribution' ),
	'what_2_text'            => array( 'type' => 'textarea', 'label' => 'What box 2 — text', 'default' => 'OTA optimization, channel-mix strategy and development of profitable B2B partnerships.' ),
	'what_3_title'           => array( 'type' => 'text', 'label' => 'What box 3 — title', 'default' => 'E-Commerce & Digital Marketing' ),
	'what_3_text'            => array( 'type' => 'textarea', 'label' => 'What box 3 — text', 'default' => 'Direct booking optimization, SEO & SEM, social media marketing and digital performance analysis.' ),
	'what_4_title'           => array( 'type' => 'text', 'label' => 'What box 4 — title', 'default' => 'Contracting & Tour Operator Negotiations' ),
	'what_4_text'            => array( 'type' => 'textarea', 'label' => 'What box 4 — text', 'default' => "Professional representation and negotiation with tour operators and wholesalers, acting in the hotel's best commercial interest." ),
	'what_cta_text'          => array( 'type' => 'text', 'label' => 'What we do — CTA', 'default' => 'View All Services' ),

	'cta_feat_img'           => array( 'type' => 'image', 'label' => 'Bottom CTA — image', 'default_url' => $u . 'featured-360-hotelier.webp' ),
	'cta_feat_title'         => array( 'type' => 'textarea', 'label' => 'Bottom CTA — title', 'default' => 'Work With a Hotel Consultant in Cyprus.' ),
	'cta_feat_text'          => array( 'type' => 'textarea', 'label' => 'Bottom CTA — text', 'default' => "360° Hotelier Consulting covers revenue, distribution and digital for hotels across Cyprus. Let's talk." ),
	'cta_feat_primary'       => array( 'type' => 'text', 'label' => 'Bottom CTA — primary button', 'default' => 'Book a Free Consultation' ),
	'cta_feat_secondary'     => array( 'type' => 'text', 'label' => 'Bottom CTA — secondary button', 'default' => 'Explore Our Services' ),
);
