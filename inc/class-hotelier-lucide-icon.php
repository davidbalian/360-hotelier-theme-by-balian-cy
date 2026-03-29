<?php
/**
 * Lucide icon placeholder markup (replaced client-side by lucide-icons.bundle.js).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders a data-lucide placeholder element.
 */
final class Hotelier_Lucide_Icon {

	/**
	 * Echo a Lucide placeholder. Use kebab-case icon names (e.g. map-pin).
	 *
	 * @param string $icon_kebab Lucide icon name.
	 * @param string $class      Optional CSS classes for the generated SVG.
	 */
	public static function render( string $icon_kebab, string $class = '' ): void {
		$class_attr = '' !== $class ? ' class="' . esc_attr( $class ) . '"' : '';
		echo '<i data-lucide="' . esc_attr( $icon_kebab ) . '"' . $class_attr . ' aria-hidden="true"></i>';
	}
}
