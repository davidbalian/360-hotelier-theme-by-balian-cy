<?php
/**
 * Bootstrap the Portfolio gallery module.
 *
 * Loads the read-only Store. The picker UI is provided by the free
 * "ACF Photo Gallery Field" plugin; the field group itself is created
 * manually in the ACF admin UI (field name: `portfolio_gallery`).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/class-hotelier-portfolio-gallery-store.php';
