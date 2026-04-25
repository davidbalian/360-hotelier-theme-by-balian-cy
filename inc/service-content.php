<?php
/**
 * Service sub-page content data.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get service content by slug.
 *
 * @param string $slug Page slug.
 * @return array|null Content array or null.
 */
function hotelier_get_service_content( $slug ) {
    $services = array(
        'revenue-management' => array(
            'title'       => __( 'Yield & Revenue Management', '360-hotelier' ),
            'intro'       => __( 'Hotels often lose revenue through inconsistent pricing, weak forecasting and limited data.', '360-hotelier' ) . ' ' . __( 'We implement revenue-management systems, pricing models and demand-based decisions specific to your property.', '360-hotelier' ),
            'deliverables' => array(
                __( 'Daily / weekly / monthly pricing strategy', '360-hotelier' ),
                __( 'Forecasting & demand analysis', '360-hotelier' ),
                __( 'OTA & competitor benchmarking', '360-hotelier' ),
                __( 'Segmentation & channel-mix optimisation', '360-hotelier' ),
                __( 'RevPAR and profitability reporting', '360-hotelier' ),
            ),
        ),
        'online-sales-distribution' => array(
            'title'       => __( 'Online Sales & B2B Distribution', '360-hotelier' ),
            'intro'       => __( 'Many hotels rely too heavily on OTAs while leaving B2B contracts, wholesalers and niche partners untapped.', '360-hotelier' ) . ' ' . __( 'We build a distribution mix that cuts OTA dependency and improves margin.', '360-hotelier' ),
            'deliverables' => array(
                __( 'OTA profile optimisation and content scoring', '360-hotelier' ),
                __( 'New B2B partnership sourcing', '360-hotelier' ),
                __( 'Wholesaler contracts & dynamic rate setups', '360-hotelier' ),
                __( 'Rate parity monitoring', '360-hotelier' ),
                __( 'Channel manager & PMS optimisation', '360-hotelier' ),
            ),
        ),
        'digital-marketing' => array(
            'title'       => __( 'E-Commerce & Digital Marketing', '360-hotelier' ),
            'intro'       => __( 'Your website and social channels can drive direct bookings and reduce OTA costs.', '360-hotelier' ) . ' ' . __( 'We build digital strategies that convert.', '360-hotelier' ),
            'deliverables' => array(
                __( 'Website audit & booking engine optimisation', '360-hotelier' ),
                __( 'SEO (search optimisation) & SEM (paid ads)', '360-hotelier' ),
                __( 'Social media content strategy', '360-hotelier' ),
                __( 'Email marketing & guest-journey automation', '360-hotelier' ),
                __( 'Analytics dashboards & conversion tracking', '360-hotelier' ),
            ),
        ),
        'tour-operator-contracting' => array(
            'title'       => __( 'Contracting & Negotiations (Tour Operators)', '360-hotelier' ),
            'intro'       => __( 'We represent your hotel in negotiations — securing better margins, tighter allotment terms and competitive agreements with tour operators.', '360-hotelier' ),
            'deliverables' => array(
                __( 'Contract benchmarking & performance evaluation', '360-hotelier' ),
                __( 'New tour-operator network development', '360-hotelier' ),
                __( 'Rate strategy & allotment planning', '360-hotelier' ),
                __( 'Negotiation support and final handover', '360-hotelier' ),
                __( 'Ongoing monitoring of production & terms', '360-hotelier' ),
            ),
        ),
    );

    return isset( $services[ $slug ] ) ? $services[ $slug ] : null;
}

/**
 * Service single page content: post meta merged with theme defaults from slug.
 *
 * @param int    $post_id Page ID.
 * @param string $slug    Page slug.
 * @return array<string, mixed>|null
 */
function hotelier_get_service_page_content( int $post_id, string $slug ): ?array {
	$ctx      = 'service';
	$fallback = hotelier_get_service_content( $slug );

	$title = Hotelier_Page_Content::get_text( $post_id, $ctx, 'hero_title' );
	if ( $title === '' && $fallback ) {
		$title = $fallback['title'];
	}

	$intro = Hotelier_Page_Content::get_text( $post_id, $ctx, 'intro' );
	if ( $intro === '' && $fallback ) {
		$intro = $fallback['intro'];
	}

	$hero_subtitle = Hotelier_Page_Content::get_text( $post_id, $ctx, 'hero_subtitle' );
	if ( $hero_subtitle === '' && $intro !== '' ) {
		$intro_sentences = explode( '. ', $intro, 2 );
		$hero_subtitle   = isset( $intro_sentences[0] ) ? $intro_sentences[0] . '.' : '';
	}

	$deliverables = array();
	for ( $i = 1; $i <= 5; $i++ ) {
		$d = Hotelier_Page_Content::get_text( $post_id, $ctx, 'deliver_' . $i );
		if ( $d !== '' ) {
			$deliverables[] = $d;
		}
	}
	if ( $deliverables === array() && $fallback ) {
		$deliverables = $fallback['deliverables'];
	}

	if ( ! $fallback && $title === '' && $intro === '' && $deliverables === array() ) {
		return null;
	}

	$overview_h = Hotelier_Page_Content::get_text( $post_id, $ctx, 'overview_heading' );
	$deliver_h  = Hotelier_Page_Content::get_text( $post_id, $ctx, 'deliver_heading' );

	return array(
		'title'            => $title,
		'hero_subtitle'    => $hero_subtitle,
		'intro'            => $intro,
		'deliverables'     => $deliverables,
		'overview_heading' => $overview_h !== '' ? $overview_h : __( 'Overview', '360-hotelier' ),
		'deliver_heading'  => $deliver_h !== '' ? $deliver_h : __( 'What We Deliver', '360-hotelier' ),
		'hero_image_url'   => Hotelier_Hero_Image_Field::resolve_url( $post_id, $ctx ),
		'cta_img'          => Hotelier_Page_Content::get_image_url( $post_id, $ctx, 'cta_feat_img' ),
		'cta_title'        => Hotelier_Page_Content::get_text( $post_id, $ctx, 'cta_feat_title' ),
		'cta_text'         => Hotelier_Page_Content::get_text( $post_id, $ctx, 'cta_feat_text' ),
		'cta_primary'      => Hotelier_Page_Content::get_text( $post_id, $ctx, 'cta_feat_primary' ),
		'cta_secondary'    => Hotelier_Page_Content::get_text( $post_id, $ctx, 'cta_feat_secondary' ),
	);
}
