<?php
/**
 * 404 page (storage page + public template) field definitions.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero_default = 'https://www.360hotelier.com/staging/8979/wp-content/uploads/2026/04/serbellas-boutique-hotel-paphos-suite.webp';

return array(
	'error_title'   => array(
		'type'    => 'text',
		'label'   => '404 — page title (body)',
		'default' => '404 — Page Not Found',
	),
	'error_text'    => array(
		'type'    => 'textarea',
		'label'   => '404 — message (body)',
		'default' => 'It looks like nothing was found at this location.',
	),
	'error_btn'     => array(
		'type'    => 'text',
		'label'   => '404 — button label',
		'default' => 'Back to home',
	),
	'error_hero_bg' => array(
		'type'        => 'image',
		'label'       => '404 hero — background image',
		'default_url' => $hero_default,
	),
);
