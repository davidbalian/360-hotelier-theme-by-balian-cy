<?php
/**
 * Home (front page) field definitions.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$u = content_url( '/uploads/2026/03/' );

return array(
	'hero_title_line1'       => array(
		'type'    => 'text',
		'label'   => 'Hero — title line 1',
		'default' => 'Revenue, Distribution & ',
	),
	'hero_title_line2'       => array(
		'type'    => 'text',
		'label'   => 'Hero — title line 2',
		'default' => 'Digital Growth for Hotels in Cyprus',
	),
	'hero_subheadline'       => array(
		'type'    => 'textarea',
		'label'   => 'Hero — subheadline',
		'default' => 'Revenue management and B2B distribution for hotels in Cyprus. We act as your external commercial team.',
	),
	'hero_cta_text'          => array(
		'type'    => 'text',
		'label'   => 'Hero — CTA button',
		'default' => 'Book a Free Strategy Session',
	),
	'hero_bg'                => array(
		'type'        => 'image',
		'label'       => 'Hero — background image',
		'default_url' => $u . '360-hotelier-consulting-cyprus-hero.webp',
	),

	'services_title'         => array(
		'type'    => 'text',
		'label'   => 'Services overview — section title',
		'default' => 'Our Core Services',
	),
	'services_subtitle'      => array(
		'type'    => 'textarea',
		'label'   => 'Services overview — subtitle',
		'default' => 'Full commercial support across revenue, distribution and digital.',
	),
	'services_cta_text'      => array(
		'type'    => 'text',
		'label'   => 'Services overview — CTA button',
		'default' => 'View Our Services',
	),

	'svc_1_title'            => array( 'type' => 'text', 'label' => 'Service card 1 — title', 'default' => 'Yield & Revenue Management' ),
	'svc_1_text'             => array( 'type' => 'textarea', 'label' => 'Service card 1 — text', 'default' => "Dynamic pricing, forecasting and RevPAR optimization tailored to your hotel's performance." ),
	'svc_1_img'              => array( 'type' => 'image', 'label' => 'Service card 1 — image', 'default_url' => $u . 'service-yield-revenue-management.webp' ),
	'svc_1_alt'              => array( 'type' => 'text', 'label' => 'Service card 1 — image alt', 'default' => 'Yield & Revenue Management' ),
	'svc_2_title'            => array( 'type' => 'text', 'label' => 'Service card 2 — title', 'default' => 'Online Sales & B2B Distribution' ),
	'svc_2_text'             => array( 'type' => 'textarea', 'label' => 'Service card 2 — text', 'default' => 'OTA optimization, channel-mix management and new B2B strategic partnerships.' ),
	'svc_2_img'              => array( 'type' => 'image', 'label' => 'Service card 2 — image', 'default_url' => $u . 'service-online-sales-b2b-distribution.webp' ),
	'svc_2_alt'              => array( 'type' => 'text', 'label' => 'Service card 2 — image alt', 'default' => 'Online Sales & B2B Distribution' ),
	'svc_3_title'            => array( 'type' => 'text', 'label' => 'Service card 3 — title', 'default' => 'E-Commerce & Digital Marketing' ),
	'svc_3_text'             => array( 'type' => 'textarea', 'label' => 'Service card 3 — text', 'default' => 'Direct booking strategy, SEO/SEM, social media management and digital performance tracking.' ),
	'svc_3_img'              => array( 'type' => 'image', 'label' => 'Service card 3 — image', 'default_url' => $u . 'service-ecommerce-digital-marketing.webp' ),
	'svc_3_alt'              => array( 'type' => 'text', 'label' => 'Service card 3 — image alt', 'default' => 'E-Commerce & Digital Marketing' ),
	'svc_4_title'            => array( 'type' => 'text', 'label' => 'Service card 4 — title', 'default' => 'Contracting & Negotiations (Tour Operators)' ),
	'svc_4_text'             => array( 'type' => 'textarea', 'label' => 'Service card 4 — text', 'default' => 'Negotiation and contracting support with tour operators and wholesalers.' ),
	'svc_4_img'              => array( 'type' => 'image', 'label' => 'Service card 4 — image', 'default_url' => $u . 'service-contracting-negotiations.webp' ),
	'svc_4_alt'              => array( 'type' => 'text', 'label' => 'Service card 4 — image alt', 'default' => 'Contracting & Negotiations' ),

	'why_title'              => array( 'type' => 'text', 'label' => 'Why choose — title', 'default' => 'Why Hotels Choose 360° Hotelier Consulting' ),
	'why_subtitle'           => array( 'type' => 'textarea', 'label' => 'Why choose — subtitle', 'default' => 'Local market knowledge. Cyprus experience. Documented results.' ),
	'why_side_img'           => array( 'type' => 'image', 'label' => 'Why choose — side image', 'default_url' => $u . 'why-choose-360-hotelier.webp' ),
	'why_1_title'            => array( 'type' => 'text', 'label' => 'Why box 1 — title', 'default' => 'Cyprus Market Knowledge' ),
	'why_1_text'             => array( 'type' => 'textarea', 'label' => 'Why box 1 — text', 'default' => "Island seasonality, tour-operator networks and source market demand. We've worked this market for fifteen years." ),
	'why_2_title'            => array( 'type' => 'text', 'label' => 'Why box 2 — title', 'default' => 'Experience' ),
	'why_2_text'             => array( 'type' => 'textarea', 'label' => 'Why box 2 — text', 'default' => '15+ years of hotel sales, revenue, marketing and OTA experience.' ),
	'why_3_title'            => array( 'type' => 'text', 'label' => 'Why box 3 — title', 'default' => 'Full Commercial Support' ),
	'why_3_text'             => array( 'type' => 'textarea', 'label' => 'Why box 3 — text', 'default' => 'We cover the full revenue cycle: contracting, pricing, distribution and digital.' ),
	'why_4_title'            => array( 'type' => 'text', 'label' => 'Why box 4 — title', 'default' => 'Trusted Partnerships' ),
	'why_4_text'             => array( 'type' => 'textarea', 'label' => 'Why box 4 — text', 'default' => 'We keep our client list small. Every hotel gets full attention.' ),

	'results_title'          => array( 'type' => 'text', 'label' => 'Results — title', 'default' => 'Results for Hotels in Cyprus & Greece' ),
	'results_stat_1'         => array( 'type' => 'text', 'label' => 'Results — stat 1', 'default' => '+20%' ),
	'results_label_1'        => array( 'type' => 'text', 'label' => 'Results — label 1', 'default' => 'increase in online bookings' ),
	'results_stat_2'         => array( 'type' => 'text', 'label' => 'Results — stat 2', 'default' => '+15%' ),
	'results_label_2'        => array( 'type' => 'text', 'label' => 'Results — label 2', 'default' => 'RevPAR improvement' ),
	'results_stat_3'         => array( 'type' => 'text', 'label' => 'Results — stat 3', 'default' => 'B2B' ),
	'results_label_3'        => array( 'type' => 'text', 'label' => 'Results — label 3', 'default' => 'Stronger portfolios and better contracting terms' ),
	'results_stat_4'         => array( 'type' => 'text', 'label' => 'Results — stat 4', 'default' => '360°' ),
	'results_label_4'        => array( 'type' => 'text', 'label' => 'Results — label 4', 'default' => 'Stronger digital performance' ),
	'results_trust'          => array( 'type' => 'textarea', 'label' => 'Results — trust line', 'default' => 'Working with hotels across Cyprus & Greece.' ),
	'results_pendeli_label'  => array( 'type' => 'text', 'label' => 'Results ticker — Pendeli aria-label', 'default' => 'Pendeli Resort Hotel Cyprus' ),
	'results_pendeli_svg'    => array(
		'type'        => 'image',
		'label'       => 'Results ticker — Pendeli logo (SVG attachment, optional)',
		'default_url' => '',
	),
	'results_tick_1'         => array( 'type' => 'image', 'label' => 'Results ticker — logo 1', 'default_url' => $u . 'cap-st-georges-resort-logo-hd.webp' ),
	'results_tick_1_alt'     => array( 'type' => 'text', 'label' => 'Results ticker — logo 1 alt', 'default' => 'Cap St Georges Hotel & Resort Cyprus' ),
	'results_tick_2'         => array( 'type' => 'image', 'label' => 'Results ticker — logo 2', 'default_url' => $u . 'tsanotel-hd-logo.webp' ),
	'results_tick_2_alt'     => array( 'type' => 'text', 'label' => 'Results ticker — logo 2 alt', 'default' => 'Tsanotel Cyprus' ),
	'results_tick_3'         => array( 'type' => 'image', 'label' => 'Results ticker — logo 3', 'default_url' => $u . 'serbellas-boutique-hotel-logo-partner-hotel-of-360-Hotelier-Consulting.png' ),
	'results_tick_3_alt'     => array( 'type' => 'text', 'label' => 'Results ticker — logo 3 alt', 'default' => 'Serbellas Boutique Hotel' ),
	'results_tick_4'         => array( 'type' => 'image', 'label' => 'Results ticker — logo 4', 'default_url' => $u . 'petit-palais-platres-hotel-logo-color-cyprus.webp' ),
	'results_tick_4_alt'     => array( 'type' => 'text', 'label' => 'Results ticker — logo 4 alt', 'default' => 'Petit Palais Hotel Platres Cyprus' ),
	'results_tick_5'         => array( 'type' => 'image', 'label' => 'Results ticker — logo 5', 'default_url' => $u . 'chic-centre-suites-athens-hotel-logo.webp' ),
	'results_tick_5_alt'     => array( 'type' => 'text', 'label' => 'Results ticker — logo 5 alt', 'default' => 'Chic Centre Suites Athens' ),
	'results_tick_6'         => array( 'type' => 'image', 'label' => 'Results ticker — logo 6', 'default_url' => $u . 'napa-jay-hotel-logo-cropped.png' ),
	'results_tick_6_alt'     => array( 'type' => 'text', 'label' => 'Results ticker — logo 6 alt', 'default' => 'Napa Jay Hotel Ayia Napa Cyprus' ),
	'results_tick_7'         => array( 'type' => 'image', 'label' => 'Results ticker — logo 7', 'default_url' => $u . 'mito-developers-paphos-logo-partner-hotel-of-360-Hotelier-Consulting.png' ),
	'results_tick_7_alt'     => array( 'type' => 'text', 'label' => 'Results ticker — logo 7 alt', 'default' => 'Mito Developers Paphos' ),

	'approach_title'         => array( 'type' => 'text', 'label' => 'How we work — title', 'default' => 'How We Work' ),
	'approach_subtitle'      => array( 'type' => 'textarea', 'label' => 'How we work — subtitle', 'default' => 'Four steps, clearly laid out.' ),
	'approach_1_title'       => array( 'type' => 'text', 'label' => 'Step 1 — title', 'default' => 'Audit & Insights' ),
	'approach_1_text'        => array( 'type' => 'textarea', 'label' => 'Step 1 — text', 'default' => 'We analyze your current performance, channels, website, pricing and contracts.' ),
	'approach_1_img'         => array( 'type' => 'image', 'label' => 'Step 1 — image (above number)', 'default_url' => '' ),
	'approach_1_img_alt'     => array( 'type' => 'text', 'label' => 'Step 1 — image alt', 'default' => '' ),
	'approach_2_title'       => array( 'type' => 'text', 'label' => 'Step 2 — title', 'default' => 'Strategy & Planning' ),
	'approach_2_text'        => array( 'type' => 'textarea', 'label' => 'Step 2 — text', 'default' => "We build a commercial strategy around your hotel's goals and market position." ),
	'approach_2_img'         => array( 'type' => 'image', 'label' => 'Step 2 — image (above number)', 'default_url' => '' ),
	'approach_2_img_alt'     => array( 'type' => 'text', 'label' => 'Step 2 — image alt', 'default' => '' ),
	'approach_3_title'       => array( 'type' => 'text', 'label' => 'Step 3 — title', 'default' => 'Execution & Management' ),
	'approach_3_text'        => array( 'type' => 'textarea', 'label' => 'Step 3 — text', 'default' => 'Hands-on management across sales, pricing, digital and contracting.' ),
	'approach_3_img'         => array( 'type' => 'image', 'label' => 'Step 3 — image (above number)', 'default_url' => '' ),
	'approach_3_img_alt'     => array( 'type' => 'text', 'label' => 'Step 3 — image alt', 'default' => '' ),
	'approach_4_title'       => array( 'type' => 'text', 'label' => 'Step 4 — title', 'default' => 'Review & Optimization' ),
	'approach_4_text'        => array( 'type' => 'textarea', 'label' => 'Step 4 — text', 'default' => 'Monthly reporting, KPI tracking and ongoing adjustments.' ),
	'approach_4_img'         => array( 'type' => 'image', 'label' => 'Step 4 — image (above number)', 'default_url' => '' ),
	'approach_4_img_alt'     => array( 'type' => 'text', 'label' => 'Step 4 — image alt', 'default' => '' ),
	'approach_cta_text'      => array( 'type' => 'text', 'label' => 'How we work — CTA', 'default' => 'Book a Free Consultation' ),

	'feat_img'               => array( 'type' => 'image', 'label' => 'Featured banner — image', 'default_url' => $u . 'featured-360-hotelier.webp' ),
	'feat_title'             => array( 'type' => 'textarea', 'label' => 'Featured banner — title', 'default' => "We Become Your Hotel's External Commercial Team" ),
	'feat_text'              => array( 'type' => 'textarea', 'label' => 'Featured banner — text', 'default' => 'Pricing, distribution, contracting and digital marketing — all handled.' ),
	'feat_cta_text'          => array( 'type' => 'text', 'label' => 'Featured banner — CTA', 'default' => 'Book a Free Consultation' ),

	'founder_photo'          => array( 'type' => 'image', 'label' => 'Founder — photo', 'default_url' => $u . 'giorgos-peyiazis-hotel-consultant-founder-of-360-hotelier-consulting-cyprus.webp' ),
	'founder_photo_alt'      => array( 'type' => 'text', 'label' => 'Founder — photo alt', 'default' => 'Giorgos Peyiazis, Founder of 360 Hotelier Consulting' ),
	'founder_heading'        => array( 'type' => 'text', 'label' => 'Founder — heading', 'default' => 'Meet the Founder' ),
	'founder_name'           => array( 'type' => 'text', 'label' => 'Founder — name', 'default' => 'Giorgos Peyiazis' ),
	'founder_p1'             => array( 'type' => 'textarea', 'label' => 'Founder — paragraph 1', 'default' => 'Giorgos has 15+ years in hotel revenue management, digital marketing, online sales and tour-operator contracting. He works with independent and boutique hotels across Cyprus.' ),
	'founder_p2'             => array( 'type' => 'textarea', 'label' => 'Founder — paragraph 2', 'default' => 'His focus: help Cyprus hotels earn more through better pricing, distribution and digital.' ),
	'founder_pt_1'           => array( 'type' => 'textarea', 'label' => 'Founder — bullet 1', 'default' => '15+ years in hospitality sales & distribution' ),
	'founder_pt_2'           => array( 'type' => 'textarea', 'label' => 'Founder — bullet 2', 'default' => 'Hands-on knowledge of the Cyprus hotel market' ),
	'founder_pt_3'           => array( 'type' => 'textarea', 'label' => 'Founder — bullet 3', 'default' => 'Track record in growing RevPAR and direct bookings' ),
	'founder_pt_4'           => array( 'type' => 'textarea', 'label' => 'Founder — bullet 4', 'default' => 'Trusted advisor to boutique, resort and independent hotels' ),
	'founder_cta_text'       => array( 'type' => 'text', 'label' => 'Founder — About Us button', 'default' => 'About Us' ),
	'founder_profile_cta_text' => array( 'type' => 'text', 'label' => 'Founder — Founder page button (About page only)', 'default' => 'Founder profile' ),

	'contact_band_img'       => array( 'type' => 'image', 'label' => 'Contact band — image', 'default_url' => $u . 'contact-360-hotelier.webp' ),
	'contact_band_title'     => array( 'type' => 'textarea', 'label' => 'Contact band — title', 'default' => "Grow Your Hotel's Revenue." ),
	'contact_band_text'      => array( 'type' => 'textarea', 'label' => 'Contact band — text', 'default' => "Tell us about your property. We'll identify where you're leaving revenue on the table." ),
	'contact_band_cta'       => array( 'type' => 'text', 'label' => 'Contact band — CTA', 'default' => 'Book a Free Strategy Session' ),
);
