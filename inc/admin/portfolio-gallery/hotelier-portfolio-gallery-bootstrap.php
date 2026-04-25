<?php
/**
 * Bootstrap the Portfolio gallery admin module.
 *
 * Loads the Store, Meta Box and Assets classes and wires their hooks.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/class-hotelier-portfolio-gallery-store.php';
require_once __DIR__ . '/class-hotelier-portfolio-gallery-meta-box.php';
require_once __DIR__ . '/class-hotelier-portfolio-gallery-assets.php';

Hotelier_Portfolio_Gallery_Meta_Box::register();
Hotelier_Portfolio_Gallery_Assets::register();
