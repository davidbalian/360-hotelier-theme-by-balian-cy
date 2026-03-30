<?php
/**
 * Bootstrap Hotelier editable page content (post meta).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/class-hotelier-page-meta-schema.php';
require_once __DIR__ . '/class-hotelier-page-content.php';
require_once __DIR__ . '/class-hotelier-page-meta-sanitizer.php';
require_once __DIR__ . '/class-hotelier-page-meta-renderer.php';
require_once __DIR__ . '/class-hotelier-page-meta-registry.php';

Hotelier_Page_Meta_Registry::register();
