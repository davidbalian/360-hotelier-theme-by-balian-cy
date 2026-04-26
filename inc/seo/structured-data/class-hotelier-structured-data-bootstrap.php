<?php
/**
 * Registers JSON-LD @graph output in wp_head.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/class-hotelier-faq-schema-text.php';
require_once __DIR__ . '/class-hotelier-structured-data-graph-builder.php';

/**
 * Front-end structured data bootstrap.
 */
final class Hotelier_Structured_Data_Bootstrap {

	public static function register(): void {
		add_action( 'wp_head', array( self::class, 'output' ), 5 );
	}

	public static function output(): void {
		if ( is_admin() ) {
			return;
		}

		$graph = Hotelier_Structured_Data_Graph_Builder::build();
		if ( $graph === array() ) {
			return;
		}

		$document = array(
			'@context' => 'https://schema.org',
			'@graph'   => $graph,
		);

		echo '<script type="application/ld+json">' . wp_json_encode( $document, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ) . '</script>' . "\n";
	}
}
