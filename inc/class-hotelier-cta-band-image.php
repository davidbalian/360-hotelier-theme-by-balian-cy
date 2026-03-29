<?php
/**
 * Full-bleed CTA band cover image (object-fit: cover for crisp scaling vs CSS backgrounds).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Prints an absolutely positioned decorative cover <img> for CTA sections.
 */
final class Hotelier_Cta_Band_Image {

	/**
	 * Echo cover image markup.
	 *
	 * @param string $image_url Absolute or content URL to the image.
	 * @param array  $args {
	 *     Optional. Extra attributes.
	 *
	 *     @type string $class         Extra CSS classes (merged with default).
	 *     @type string $loading       img loading attribute. Default 'lazy'.
	 *     @type string $fetchpriority fetchpriority. Default 'low'.
	 *     @type string $decoding    Default 'async'.
	 *     @type bool   $aria_hidden Default true (decorative).
	 * }
	 */
	public static function render( string $image_url, array $args = array() ): void {
		$image_url = trim( $image_url );
		if ( $image_url === '' ) {
			return;
		}

		$defaults = array(
			'class'         => '',
			'loading'       => 'lazy',
			'fetchpriority' => 'low',
			'decoding'      => 'async',
			'aria_hidden'   => true,
		);
		$args = wp_parse_args( $args, $defaults );

		$class = trim( 'cta-band-cover-image ' . $args['class'] );

		$srcset = self::build_srcset( $image_url );

		echo '<img';
		echo ' class="' . esc_attr( $class ) . '"';
		echo ' src="' . esc_url( $image_url ) . '"';
		if ( $srcset !== '' ) {
			echo ' srcset="' . esc_attr( $srcset ) . '" sizes="100vw"';
		}
		echo ' alt=""';
		if ( ! empty( $args['aria_hidden'] ) ) {
			echo ' aria-hidden="true"';
		}
		echo ' decoding="' . esc_attr( (string) $args['decoding'] ) . '"';
		echo ' loading="' . esc_attr( (string) $args['loading'] ) . '"';
		if ( $args['fetchpriority'] !== '' ) {
			echo ' fetchpriority="' . esc_attr( (string) $args['fetchpriority'] ) . '"';
		}
		echo '>';
	}

	/**
	 * Build srcset: filter first, else auto-detect @2x / -2x sibling in uploads.
	 *
	 * @param string $image_url Image URL.
	 * @return string Empty or "url 1x, url 2x" / custom descriptors from filter.
	 */
	private static function build_srcset( string $image_url ): string {
		/**
		 * Custom srcset for CTA band images, e.g. array( 'https://.../a.webp' => '800w', 'https://.../b.webp' => '1600w' ).
		 *
		 * @param array  $parts Empty or map of URL => descriptor.
		 * @param string $image_url Default image URL.
		 */
		$filtered = apply_filters( 'hotelier_cta_band_image_srcset_parts', array(), $image_url );
		if ( is_array( $filtered ) && $filtered !== array() ) {
			$pair = array();
			foreach ( $filtered as $url => $descriptor ) {
				$url = is_string( $url ) ? trim( $url ) : '';
				$descriptor = is_string( $descriptor ) ? trim( $descriptor ) : '';
				if ( $url !== '' && $descriptor !== '' ) {
					$pair[] = esc_url( $url ) . ' ' . $descriptor;
				}
			}
			return implode( ', ', $pair );
		}

		$high = self::find_high_res_variant_url( $image_url );
		if ( $high === '' ) {
			return '';
		}

		return esc_url( $image_url ) . ' 1x, ' . esc_url( $high ) . ' 2x';
	}

	/**
	 * Look for same-name @2x or -2x file beside the default asset in uploads.
	 *
	 * @param string $url Public URL to the base image.
	 * @return string High-res URL or empty.
	 */
	private static function find_high_res_variant_url( string $url ): string {
		$path = wp_parse_url( $url, PHP_URL_PATH );
		if ( ! is_string( $path ) ) {
			return '';
		}

		$uploads_marker = '/uploads/';
		$pos            = strpos( $path, $uploads_marker );
		if ( false === $pos ) {
			return '';
		}

		$uploads = wp_upload_dir();
		if ( ! empty( $uploads['error'] ) ) {
			return '';
		}

		$relative_from_uploads = substr( $path, $pos + strlen( $uploads_marker ) );
		$dir                   = trailingslashit( $uploads['basedir'] ) . dirname( $relative_from_uploads );
		$filename              = basename( $relative_from_uploads );
		$info                  = pathinfo( $filename );

		if ( empty( $info['filename'] ) || empty( $info['extension'] ) ) {
			return '';
		}

		$base       = $info['filename'];
		$ext        = $info['extension'];
		$candidates = array(
			$dir . '/' . $base . '@2x.' . $ext,
			$dir . '/' . $base . '-2x.' . $ext,
		);

		foreach ( $candidates as $fs_path ) {
			if ( ! is_readable( $fs_path ) ) {
				continue;
			}
			$rel = _wp_relative_upload_path( $fs_path );
			if ( ! is_string( $rel ) || $rel === '' ) {
				continue;
			}
			return trailingslashit( $uploads['baseurl'] ) . $rel;
		}

		return '';
	}
}
