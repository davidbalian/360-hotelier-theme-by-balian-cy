<?php
/**
 * Bootstrap the Portfolio gallery module.
 *
 * Loads the read-only Store and the ACF field group registrar, and wires
 * the latter into the `acf/init` hook. Picker UI is provided by ACF Pro.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/class-hotelier-portfolio-gallery-acf.php';
require_once __DIR__ . '/class-hotelier-portfolio-gallery-store.php';

Hotelier_Portfolio_Gallery_Acf::register();
