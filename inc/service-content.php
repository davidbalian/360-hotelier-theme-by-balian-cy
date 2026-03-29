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
