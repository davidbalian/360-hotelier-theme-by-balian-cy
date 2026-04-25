<?php
/**
 * Founder page field definitions.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$u = content_url( '/uploads/2026/03/' );

return array(
	'hero_title'             => array( 'type' => 'text', 'label' => 'Hero — title', 'default' => 'Giorgos Peyiazis' ),
	'hero_subtitle'          => array( 'type' => 'textarea', 'label' => 'Hero — subtitle', 'default' => 'Founder & Hospitality Consultant · 15+ years in hotel revenue management, online sales and digital strategy.' ),
	'hero_bg'                => array( 'type' => 'image', 'label' => 'Hero — background', 'default_url' => $u . 'giorgos-peyiazis-hotel-consultant-founder-of-360-hotelier-consulting-cyprus.webp' ),
	'bio_photo'              => array( 'type' => 'image', 'label' => 'Bio — photo', 'default_url' => $u . 'giorgos-peyiazis-hotel-consultant-founder-of-360-hotelier-consulting-cyprus.webp' ),
	'bio_photo_alt'          => array( 'type' => 'text', 'label' => 'Bio — photo alt', 'default' => 'Giorgos Peyiazis, Founder of 360 Hotelier Consulting' ),
	'bio_h2'                 => array( 'type' => 'text', 'label' => 'Bio — heading', 'default' => 'About Giorgos' ),
	'bio_role'               => array( 'type' => 'text', 'label' => 'Bio — role line', 'default' => 'Founder & Hospitality Consultant — 360° Hotelier Consulting' ),
	'bio_p1'                 => array( 'type' => 'textarea', 'label' => 'Bio — paragraph 1', 'default' => 'Giorgos Peyiazis is the Founder of 360° Hotelier Consulting, a hospitality sales and e-commerce consultancy based in Cyprus. With over fifteen years of experience in hotel sales, contracting, and digital distribution, Giorgos specialises in helping hotels increase direct bookings, sharpen distribution and grow revenue.' ),
	'bio_p2'                 => array( 'type' => 'textarea', 'label' => 'Bio — paragraph 2', 'default' => 'He studied Business Administration (Marketing) at Les Roches International School of Hotel Management in Switzerland, then worked across hotel operations, distribution and digital in Cyprus and abroad.' ),
	'bio_p3'                 => array( 'type' => 'textarea', 'label' => 'Bio — paragraph 3', 'default' => '360° Hotelier Consulting focuses on revenue optimisation, e-commerce and digital marketing for independent and boutique hotels. Giorgos helps hoteliers improve channel mix, increase direct bookings and grow RevPAR.' ),
	'bio_cta_primary'        => array( 'type' => 'text', 'label' => 'Bio — primary button', 'default' => 'Get in Touch' ),
	'bio_cta_secondary'      => array( 'type' => 'text', 'label' => 'Bio — secondary button', 'default' => 'About 360° Hotelier' ),

	'tl_title'               => array( 'type' => 'text', 'label' => 'Timeline — title (not shown on site; legacy)', 'default' => 'Professional Experience' ),
	'tl_subtitle'            => array( 'type' => 'textarea', 'label' => 'Experience — lead line', 'default' => 'Past experience' ),
	'tl_image'               => array( 'type' => 'image', 'label' => 'Timeline — image', 'default_url' => content_url( 'uploads/2026/03/person-at-hotel-reception-scaled.webp' ) ),
	'tl_image_alt'           => array( 'type' => 'text', 'label' => 'Timeline — image alt', 'default' => 'Hotel consultant at work' ),
	'tl_1_title'             => array( 'type' => 'text', 'label' => 'Timeline 1 — title', 'default' => 'Booking.com · 2013–2021' ),
	'tl_1_text'              => array( 'type' => 'textarea', 'label' => 'Timeline 1 — text', 'default' => 'Sales strategy, distribution management and partner development. Delivered workshops and represented Booking.com at international conferences.' ),
	'tl_2_title'             => array( 'type' => 'text', 'label' => 'Timeline 2 — title', 'default' => 'Tour Operators & Wholesalers · 2022–2024' ),
	'tl_2_text'              => array( 'type' => 'textarea', 'label' => 'Timeline 2 — text', 'default' => 'Contracting management, tactical promotions and strategic pricing for DERTOUR Group, EasyJet Holidays, Sunweb Group, Love Holidays, ITAKA, Grecos Holidays and more.' ),
	'tl_3_title'             => array( 'type' => 'text', 'label' => 'Timeline 3 — title', 'default' => '360° Hotelier Consulting · 2024–Present' ),
	'tl_3_text'              => array( 'type' => 'textarea', 'label' => 'Timeline 3 — text', 'default' => 'External e-commerce manager and pre-opening consultant for boutique, mid-scale and upscale hotels across Cyprus and abroad. Full commercial support from revenue to digital.' ),

	'cta_feat_img'           => array( 'type' => 'image', 'label' => 'Bottom CTA — image', 'default_url' => $u . 'featured-360-hotelier.webp' ),
	'cta_feat_title'         => array( 'type' => 'text', 'label' => 'Bottom CTA — title', 'default' => 'Work With Giorgos' ),
	'cta_feat_text'          => array( 'type' => 'textarea', 'label' => 'Bottom CTA — text', 'default' => "Grow your hotel's revenue and distribution. Get in touch today." ),
	'cta_feat_primary'       => array( 'type' => 'text', 'label' => 'Bottom CTA — button', 'default' => 'Get in Touch' ),
);
