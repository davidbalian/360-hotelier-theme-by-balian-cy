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
            'intro'       => __( 'Hotels often lose revenue due to inconsistent pricing, weak forecasting and limited data insights.', '360-hotelier' ) . ' ' . __( 'We implement professional revenue-management systems, strategic pricing models and market-driven decisions tailored to your property.', '360-hotelier' ),
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
            'intro'       => __( 'Many hotels rely heavily on OTAs while missing opportunities in B2B contracts, wholesalers and niche partners.', '360-hotelier' ) . ' ' . __( 'We build a balanced distribution strategy that increases visibility, reduces dependency and improves profitability.', '360-hotelier' ),
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
            'intro'       => __( 'Your website and social channels should be strategic revenue drivers — not just online brochures.', '360-hotelier' ) . ' ' . __( 'We create digital strategies that increase direct bookings and strengthen your brand.', '360-hotelier' ),
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
            'intro'       => __( 'We represent your hotel and negotiate on your behalf — ensuring strong margins, competitive agreements and balanced tour-operator partnerships.', '360-hotelier' ),
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
