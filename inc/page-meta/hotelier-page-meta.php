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
require_once __DIR__ . '/class-hotelier-acf-image-location-rules.php';
require_once __DIR__ . '/class-hotelier-hero-image-field.php';
require_once __DIR__ . '/class-hotelier-cta-feat-image-field.php';
require_once __DIR__ . '/../seo/class-hotelier-seo-defaults.php';
require_once __DIR__ . '/../seo/class-hotelier-seo-context.php';
require_once __DIR__ . '/class-hotelier-seo-meta-field.php';
require_once __DIR__ . '/class-hotelier-seo-meta-resolver.php';
require_once __DIR__ . '/class-hotelier-seo-meta-seeder.php';
require_once __DIR__ . '/class-hotelier-home-text-acf-field.php';
require_once __DIR__ . '/class-hotelier-home-text-acf-seeder.php';
require_once __DIR__ . '/class-hotelier-home-image-acf-field.php';
require_once __DIR__ . '/class-hotelier-home-image-acf-seeder.php';
require_once __DIR__ . '/class-hotelier-context-page-text-acf-field.php';
require_once __DIR__ . '/class-hotelier-context-page-text-acf-seeder.php';
require_once __DIR__ . '/class-hotelier-context-page-image-acf-field.php';
require_once __DIR__ . '/class-hotelier-context-page-image-acf-seeder.php';

Hotelier_Hero_Image_Field::register();
Hotelier_Cta_Feat_Image_Field::register();
Hotelier_Seo_Meta_Field::register();
Hotelier_Seo_Meta_Seeder::register();
Hotelier_Home_Text_Acf_Field::register();
Hotelier_Home_Text_Acf_Seeder::register();
Hotelier_Home_Image_Acf_Field::register();
Hotelier_Home_Image_Acf_Seeder::register();
Hotelier_Context_Page_Text_Acf_Field::register();
Hotelier_Context_Page_Text_Acf_Seeder::register();
Hotelier_Context_Page_Image_Acf_Field::register();
Hotelier_Context_Page_Image_Acf_Seeder::register();
