<?php
/**
 * ACF local field group location rules: pages with hero and bottom CTA band.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build `location` arrays for ACF (OR groups at top level).
 */
final class Hotelier_Acf_Image_Location_Rules {

	/**
	 * @return array<int, array<int, array<string, string>>>
	 */
	public static function build(): array {
		$rules   = array();
		$rules[] = array(
			array(
				'param'    => 'page_type',
				'operator' => '==',
				'value'    => 'front_page',
			),
		);

		$templates = array(
			'template-about.php',
			'template-portfolio.php',
			'template-contact.php',
			'template-services.php',
			'template-founder.php',
			'template-service-single.php',
			'template-style-guide.php',
		);

		foreach ( $templates as $file ) {
			$rules[] = array(
				array(
					'param'    => 'page_template',
					'operator' => '==',
					'value'    => 'page-templates/' . $file,
				),
			);
		}

		return $rules;
	}
}
