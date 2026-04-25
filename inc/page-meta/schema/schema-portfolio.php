<?php
/**
 * Portfolio page field definitions.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$u = content_url( '/uploads/2026/03/' );

$hotels = array();
for ( $i = 1; $i <= 8; $i++ ) {
	$hotels[ "hotel_{$i}_name" ]     = array( 'type' => 'text', 'label' => "Hotel {$i} — name", 'default' => '' );
	$hotels[ "hotel_{$i}_location" ] = array( 'type' => 'text', 'label' => "Hotel {$i} — location", 'default' => '' );
	$hotels[ "hotel_{$i}_url" ]      = array( 'type' => 'text', 'label' => "Hotel {$i} — website URL", 'default' => '' );
	$hotels[ "hotel_{$i}_mode" ]     = array(
		'type'    => 'select',
		'label'   => "Hotel {$i} — logo type",
		'options' => array(
			'img'     => 'Image / raster logo',
			'pendeli' => 'Pendeli-style inline SVG',
		),
		'default' => 'img',
	);
	$hotels[ "hotel_{$i}_logo" ]     = array( 'type' => 'image', 'label' => "Hotel {$i} — logo image", 'default_url' => '' );
	$hotels[ "hotel_{$i}_photo" ]    = array( 'type' => 'image', 'label' => "Hotel {$i} — partner photo (large image beside card)", 'default_url' => '' );
	$hotels[ "hotel_{$i}_alt" ]      = array( 'type' => 'text', 'label' => "Hotel {$i} — logo alt", 'default' => '' );
	$hotels[ "hotel_{$i}_variant" ]  = array( 'type' => 'text', 'label' => "Hotel {$i} — CSS variant (optional, e.g. serbellas)", 'default' => '' );
	$hotels[ "hotel_{$i}_tagline" ]  = array( 'type' => 'textarea', 'label' => "Hotel {$i} — short description (under title)", 'default' => '' );
}

$testimonials = array();
for ( $i = 1; $i <= 8; $i++ ) {
	$testimonials[ "testimonial_{$i}_quote" ] = array(
		'type'    => 'textarea',
		'label'   => "Testimonial {$i} — quote",
		'default' => '',
	);
	$testimonials[ "testimonial_{$i}_name" ] = array(
		'type'    => 'text',
		'label'   => "Testimonial {$i} — name",
		'default' => '',
	);
	$testimonials[ "testimonial_{$i}_role" ] = array(
		'type'    => 'text',
		'label'   => "Testimonial {$i} — role / property",
		'default' => '',
	);
}

$defaults = array(
	'hero_title'             => array( 'type' => 'text', 'label' => 'Hero — title', 'default' => 'Our Hotel Partners' ),
	'hero_subtitle'          => array( 'type' => 'textarea', 'label' => 'Hero — subtitle', 'default' => 'Boutique, independent and resort hotels across Cyprus and beyond, each delivering measurable results.' ),
	'hero_bg'                => array( 'type' => 'image', 'label' => 'Hero — background', 'default_url' => $u . 'why-choose-360-hotelier.webp' ),

	'intro_h2'               => array( 'type' => 'text', 'label' => 'Intro — heading', 'default' => 'Hotels We Work With' ),
	'intro_p1'               => array( 'type' => 'textarea', 'label' => 'Intro — paragraph 1', 'default' => 'We work with independent, boutique and resort hotels in Cyprus across revenue management, online sales & B2B distribution, digital marketing and tour-operator contracting.' ),
	'intro_p2'               => array( 'type' => 'textarea', 'label' => 'Intro — paragraph 2', 'default' => "Each engagement is built around the hotel's market, seasonality and commercial goals." ),
	'intro_side_img'         => array( 'type' => 'image', 'label' => 'Intro — side image', 'default_url' => $u . 'why-choose-360-hotelier.webp' ),

	'partners_title'         => array( 'type' => 'text', 'label' => 'Partners section — title', 'default' => 'Hotels & Partners' ),
	'partners_subtitle'      => array( 'type' => 'textarea', 'label' => 'Partners section — subtitle', 'default' => 'Independent, boutique and resort properties we support with revenue, distribution and digital strategy.' ),
	'gallery_title'          => array( 'type' => 'text', 'label' => 'Gallery — title', 'default' => 'Inside Our Properties' ),
	'gallery_subtitle'       => array( 'type' => 'textarea', 'label' => 'Gallery — subtitle', 'default' => 'A look at the rooms, suites and spaces of the hotels we work with across Cyprus and Greece.' ),
	'testimonials_title'     => array( 'type' => 'text', 'label' => 'Testimonials — title', 'default' => 'What partners say' ),
	'testimonials_subtitle'  => array( 'type' => 'textarea', 'label' => 'Testimonials — subtitle', 'default' => 'Feedback from hotel leaders on revenue, distribution and working with our team.' ),
	'testimonials_closing'   => array( 'type' => 'textarea', 'label' => 'Testimonials — closing paragraph (below carousel)', 'default' => '360 Hotelier Consulting collaborates with boutique hotels, independent hotels, and hospitality partners across Cyprus and Greece, helping them increase occupancy, optimize OTA performance, and improve revenue strategy.' ),
	'visit_website_text'     => array( 'type' => 'text', 'label' => 'Partner card — button', 'default' => 'Visit Website' ),
	'pendeli_aria'           => array( 'type' => 'text', 'label' => 'Pendeli logo — aria label', 'default' => 'Pendeli Resort Hotel Cyprus' ),
	'pendeli_svg'            => array(
		'type'        => 'image',
		'label'       => 'Pendeli — SVG attachment (optional override)',
		'default_url' => '',
	),

	'cta_feat_img'           => array( 'type' => 'image', 'label' => 'Bottom CTA — image', 'default_url' => $u . 'hotel-consulting-services-cyprus-360hotelier-1.webp' ),
	'cta_feat_title'         => array( 'type' => 'textarea', 'label' => 'Bottom CTA — title', 'default' => 'Add Your Hotel to Our Portfolio.' ),
	'cta_feat_text'          => array( 'type' => 'textarea', 'label' => 'Bottom CTA — text', 'default' => 'We keep our client list small. Every hotel gets direct access to Giorgos and full commercial support.' ),
	'cta_feat_primary'       => array( 'type' => 'text', 'label' => 'Bottom CTA — button', 'default' => 'Book a Free Consultation' ),
);

$out = array_merge( $defaults, $testimonials, $hotels );

$out['hotel_1_name']['default']          = 'Cap St. Georges Hotel & Resort';
$out['hotel_1_location']['default']      = 'Paphos, Cyprus';
$out['hotel_1_url']['default']           = 'https://www.capstgeorges.com/';
$out['hotel_1_logo']['default_url']      = $u . 'cap-st-georges-resort-logo-hd.webp';
$out['hotel_1_photo']['default_url']     = $u . 'cap-st-georges-hotel-resort-paphos-hotel-consulting.webp';
$out['hotel_1_alt']['default']           = 'Cap St Georges Hotel & Resort Cyprus';

$out['hotel_2_name']['default']          = 'Serbellas Boutique Hotel';
$out['hotel_2_location']['default']      = 'Paphos, Cyprus';
$out['hotel_2_url']['default']           = 'https://serbellashotel.com/';
$out['hotel_2_logo']['default_url']      = $u . 'serbellas-boutique-hotel-logo-partner-hotel-of-360-Hotelier-Consulting.png';
$out['hotel_2_photo']['default_url']     = $u . 'serbellas-boutique-hotel-paphos-consulting-project.webp';
$out['hotel_2_alt']['default']           = 'Serbellas Boutique Hotel';
$out['hotel_2_variant']['default']       = 'serbellas';

$out['hotel_3_name']['default']          = 'MITO Seaview by Serbellas';
$out['hotel_3_location']['default']      = 'Paphos, Cyprus';
$out['hotel_3_url']['default']           = 'https://mitodevelopers.com/';
$out['hotel_3_logo']['default_url']      = $u . 'mito-developers-paphos-logo-partner-hotel-of-360-Hotelier-Consulting.png';
$out['hotel_3_photo']['default_url']     = $u . 'mito-seaview-villas-by-serbellas-paphos-hotel-consulting.webp';
$out['hotel_3_alt']['default']           = 'MITO Seaview by Serbellas Paphos';

$out['hotel_4_name']['default']          = 'TSANotel';
$out['hotel_4_location']['default']      = 'Limassol, Cyprus';
$out['hotel_4_url']['default']           = 'https://www.tsanotel.com/';
$out['hotel_4_logo']['default_url']      = $u . 'tsanotel-hd-logo.webp';
$out['hotel_4_photo']['default_url']     = $u . 'tsanotel-limassol-hotel-revenue-management.webp';
$out['hotel_4_alt']['default']           = 'Tsanotel Cyprus';

$out['hotel_5_name']['default']          = 'Pendeli Resort';
$out['hotel_5_location']['default']      = 'Platres, Cyprus';
$out['hotel_5_url']['default']           = 'https://www.pendeliresort.com/';
$out['hotel_5_mode']['default']          = 'pendeli';
$out['hotel_5_logo']['default_url']      = '';
$out['hotel_5_photo']['default_url']     = $u . 'pendeli-resort-platres-hotel-consulting.webp';

$out['hotel_6_name']['default']          = 'Petit Palais Platres Boutique Hotel';
$out['hotel_6_location']['default']      = 'Platres, Cyprus';
$out['hotel_6_url']['default']           = 'https://www.petitpalais.com.cy/';
$out['hotel_6_logo']['default_url']      = $u . 'petit-palais-platres-hotel-logo-color-cyprus.webp';
$out['hotel_6_photo']['default_url']     = $u . 'petit-palais-platres-boutique-hotel-consulting.webp';
$out['hotel_6_alt']['default']           = 'Petit Palais Hotel Platres Cyprus';

$out['hotel_7_name']['default']          = 'Napa Jay Hotel';
$out['hotel_7_location']['default']      = 'Ayia Napa, Cyprus';
$out['hotel_7_url']['default']           = 'https://napajayhotel.com/';
$out['hotel_7_logo']['default_url']      = $u . 'napa-jay-hotel-logo-cropped.png';
$out['hotel_7_photo']['default_url']     = $u . 'napa-jay-hotel-ayia-napa-hotel-consulting.webp';
$out['hotel_7_alt']['default']           = 'Napa Jay Hotel Ayia Napa Cyprus';

$out['hotel_8_name']['default']          = 'Chic Centre Suites Athens';
$out['hotel_8_location']['default']      = 'Athens, Greece';
$out['hotel_8_url']['default']           = 'https://chiccentresuites.com/';
$out['hotel_8_logo']['default_url']      = $u . 'chic-centre-suites-athens-hotel-logo.webp';
$out['hotel_8_photo']['default_url']     = $u . 'chic-centre-suites-athens-hotel-consulting-project.webp';
$out['hotel_8_alt']['default']           = 'Chic Centre Suites Athens';

$out['hotel_1_tagline']['default']  = 'Cyprus\' most luxurious beachfront hotel with breathtaking sea views.';
$out['hotel_2_tagline']['default']  = 'Newly opened boutique luxury hotel in Paphos with stylish design.';
$out['hotel_3_tagline']['default']  = 'Exclusive seaside residences in Paphos with panoramic sea views.';
$out['hotel_4_tagline']['default']  = 'Hotel in Limassol\'s vibrant tourist area with modern comforts.';
$out['hotel_5_tagline']['default']  = 'Iconic historical mountain resort in Platres surrounded by scenic beauty.';
$out['hotel_6_tagline']['default']  = 'Charming historical boutique hotel in Platres with cozy elegance.';
$out['hotel_7_tagline']['default']  = 'Affordable hotel near Ayia Napa\'s top attractions and nightlife.';
$out['hotel_8_tagline']['default']  = 'Stylish city-centre suites in Athens, Greece\'s capital, ideal for urban stays.';

$out['testimonial_1_quote']['default']  = 'Working with 360 Hotelier Consulting has been a professional and productive experience. The hands-on involvement in revenue strategy, contracting, and commercial planning provided valuable insights and practical solutions that supported our resort. Strong industry knowledge, strategic thinking, and close cooperation make this collaboration highly effective.';
$out['testimonial_1_name']['default']  = 'Panayiotis Markou';
$out['testimonial_1_role']['default']   = 'Sales & Marketing Director · Cap St. Georges Hotel & Resort · Paphos, Cyprus';

$out['testimonial_2_quote']['default']  = 'The pre-opening support from 360 Hotelier Consulting has been essential for our hotel development. Giorgos provided valuable support in building our commercial and revenue strategy. The guidance in pricing, OTA structure, and market positioning helped us develop a clear and competitive approach. The collaboration is professional, transparent, and focused on long-term results.';
$out['testimonial_2_name']['default']  = 'Marios Vassiliou';
$out['testimonial_2_role']['default']   = 'General Manager · Serbellas Boutique Hotel · Paphos, Cyprus';

$out['testimonial_3_quote']['default']  = '360 Hotelier Consulting demonstrated a practical approach in supporting our commercial and revenue strategy. The collaboration was focused, structured, and result-driven, with strong attention to OTA performance, pricing strategy, and market positioning. A reliable partner who understands the needs of the market and actively works alongside the team to improve performance.';
$out['testimonial_3_name']['default']  = 'Stavros G. Tsanos';
$out['testimonial_3_role']['default']   = 'Director · George Tsanos Hotels Group (TSANotel, Pendeli Resort & Petit Palais Platres Boutique Hotel) · Limassol, Cyprus';

$out['testimonial_4_quote']['default']  = 'Working with 360 Hotelier Consulting has significantly improved our hotel\'s online presence and pricing strategy. The structured approach to OTA management and revenue planning increased our visibility and strengthened our market positioning. Within the first year of collaboration, revenue from OTAs and direct bookings increased by more than 45%.';
$out['testimonial_4_name']['default']  = 'Zacharias Papadopoulos';
$out['testimonial_4_role']['default']   = 'General Manager · Napa Jay Hotel · Ayia Napa, Cyprus';

$out['testimonial_5_quote']['default']  = 'Collaborating with Giorgos was a must due to his extensive knowledge of the Athens market through his Booking.com experience, which brought valuable insights and clear strategic direction. A reliable and professional partner for business growth.';
$out['testimonial_5_name']['default']  = 'Miranda Yiatrou-Grammatikopoulou';
$out['testimonial_5_role']['default']   = 'CEO Yiatros Group · Chic Centre Suites Athens · Athens, Greece';

$out['testimonial_6_quote']['default']  = 'Giorgos brings deep knowledge of the Cyprus hospitality market and strong expertise in revenue management and OTA strategy. The collaboration helped us better understand our pricing structure and improve our commercial decision-making. A valuable partner for any hotel looking to grow.';
$out['testimonial_6_name']['default']  = 'Constantinos Droussiotis';
$out['testimonial_6_role']['default']   = 'General Manager · Alinea Hospitality Group · Limassol, Cyprus';

$out['testimonial_7_quote']['default']  = 'Professional, structured, and highly experienced in hotel contracting and commercial strategy. Giorgos demonstrates strong industry knowledge and excellent communication, making cooperation smooth and efficient. A reliable partner in the hospitality sector.';
$out['testimonial_7_name']['default']  = 'Kratinos Socratous';
$out['testimonial_7_role']['default']   = 'General Manager · Capo Bay Hotel · Protaras, Cyprus';

$out['testimonial_8_quote']['default']  = 'A highly experienced hotel professional with deep understanding of revenue management, OTA performance, and market dynamics in Cyprus and Greece. Giorgos\' strategic approach and commercial mindset make 360 Hotelier Consulting a strong partner for hotels aiming to improve occupancy and revenue.';
$out['testimonial_8_name']['default']  = 'Omiros Omirou';
$out['testimonial_8_role']['default']   = 'Business Development Manager · STADEMOS HOTELS LTD · Limassol, Cyprus';

return $out;
