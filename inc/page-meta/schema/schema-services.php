<?php
/**
 * Services listing page field definitions.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$u = content_url( '/uploads/2026/03/' );

return array(
	'hero_title'             => array( 'type' => 'text', 'label' => 'Hero — title', 'default' => 'Our Core Services' ),
	'hero_subtitle'          => array( 'type' => 'textarea', 'label' => 'Hero — subtitle', 'default' => 'Revenue, distribution and digital growth for hotels in Cyprus. We act as your external commercial team.' ),
	'hero_bg'                => array( 'type' => 'image', 'label' => 'Hero — background', 'default_url' => $u . 'cyprus-hotel-revenue-consulting.webp' ),

	'offer_title'            => array( 'type' => 'text', 'label' => 'What we offer — title', 'default' => 'What We Offer' ),
	'offer_subtitle'         => array( 'type' => 'textarea', 'label' => 'What we offer — subtitle', 'default' => 'We help hotels drive direct bookings, optimise channel mix and negotiate stronger tour-operator & B2B agreements.' ),
	'row_1_title'            => array( 'type' => 'text', 'label' => 'Row 1 — title', 'default' => 'Yield & Revenue Management' ),
	'row_1_text'             => array( 'type' => 'textarea', 'label' => 'Row 1 — text', 'default' => 'Dynamic pricing, forecasting, segmentation and performance analysis to maximise RevPAR and increase revenue.' ),
	'row_1_img'              => array( 'type' => 'image', 'label' => 'Row 1 — image', 'default_url' => $u . 'hotel-revenue-management-strategy.webp' ),
	'row_1_alt'              => array( 'type' => 'text', 'label' => 'Row 1 — alt', 'default' => 'Yield & Revenue Management' ),
	'row_2_title'            => array( 'type' => 'text', 'label' => 'Row 2 — title', 'default' => 'Online Sales & B2B Distribution' ),
	'row_2_text'             => array( 'type' => 'textarea', 'label' => 'Row 2 — text', 'default' => 'OTA optimisation, B2B partnerships, channel-mix strategy and distribution management across global and regional markets.' ),
	'row_2_img'              => array( 'type' => 'image', 'label' => 'Row 2 — image', 'default_url' => $u . 'hotel-online-sales-distribution-strategy.webp' ),
	'row_2_alt'              => array( 'type' => 'text', 'label' => 'Row 2 — alt', 'default' => 'Online Sales & B2B Distribution' ),
	'row_3_title'            => array( 'type' => 'text', 'label' => 'Row 3 — title', 'default' => 'E-Commerce & Digital Marketing' ),
	'row_3_text'             => array( 'type' => 'textarea', 'label' => 'Row 3 — text', 'default' => 'Direct booking strategy, SEO/SEM campaigns, social media management and digital performance tracking.' ),
	'row_3_img'              => array( 'type' => 'image', 'label' => 'Row 3 — image', 'default_url' => $u . 'hotel-digital-marketing-direct-bookings.webp' ),
	'row_3_alt'              => array( 'type' => 'text', 'label' => 'Row 3 — alt', 'default' => 'E-Commerce & Digital Marketing' ),
	'row_4_title'            => array( 'type' => 'text', 'label' => 'Row 4 — title', 'default' => 'Contracting & Negotiations (Tour Operators)' ),
	'row_4_text'             => array( 'type' => 'textarea', 'label' => 'Row 4 — text', 'default' => 'Full contracting services, benchmarking, negotiation support and relationship management with key tour operators & travel partners.' ),
	'row_4_img'              => array( 'type' => 'image', 'label' => 'Row 4 — image', 'default_url' => $u . 'hotel-tour-operator-contracting-negotiations.webp' ),
	'row_4_alt'              => array( 'type' => 'text', 'label' => 'Row 4 — alt', 'default' => 'Contracting & Negotiations' ),
	'learn_more_text'        => array( 'type' => 'text', 'label' => 'Row — “Learn more” button', 'default' => 'Learn more' ),

	'cta_feat_img'           => array( 'type' => 'image', 'label' => 'Bottom CTA — image', 'default_url' => $u . 'hotel-consulting-services-cyprus-360hotelier.webp' ),
	'cta_feat_title'         => array( 'type' => 'textarea', 'label' => 'Bottom CTA — title', 'default' => "Grow Your Hotel's Revenue." ),
	'cta_feat_text'          => array( 'type' => 'textarea', 'label' => 'Bottom CTA — text', 'default' => "We'll build a commercial strategy around your property, market and goals." ),
	'cta_feat_primary'       => array( 'type' => 'text', 'label' => 'Bottom CTA — button', 'default' => 'Book a Free Consultation' ),
);
