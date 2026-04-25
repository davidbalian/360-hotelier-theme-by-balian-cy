<?php
/**
 * Bootstrap Hotelier hardcoded page content.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/class-hotelier-page-meta-schema.php';
require_once __DIR__ . '/class-hotelier-page-content.php';
require_once __DIR__ . '/class-hotelier-hero-image-field.php';

Hotelier_Hero_Image_Field::register();
