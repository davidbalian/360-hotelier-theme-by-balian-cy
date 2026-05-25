<?php
/**
 * Resolve media library attachment IDs from theme default URLs.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Looks up attachments when attachment_url_to_postid() fails (scaled variants, URL mismatches).
 */
final class Hotelier_Attachment_Lookup {

	/**
	 * @param string $url Full upload URL from schema default_url.
	 */
	public static function id_from_url( string $url ): int {
		$url = trim( $url );
		if ( '' === $url ) {
			return 0;
		}

		$candidates = self::url_candidates( $url );
		foreach ( $candidates as $candidate ) {
			$id = (int) attachment_url_to_postid( $candidate );
			if ( $id > 0 ) {
				return $id;
			}
		}

		foreach ( $candidates as $candidate ) {
			$id = self::id_from_basename( wp_basename( $candidate ) );
			if ( $id > 0 ) {
				return $id;
			}
		}

		return 0;
	}

	/**
	 * @return string[]
	 */
	private static function url_candidates( string $url ): array {
		$out   = array( $url );
		$parts = wp_parse_url( $url );
		if ( ! is_array( $parts ) || empty( $parts['path'] ) ) {
			return array_unique( $out );
		}

		$path = (string) $parts['path'];
		if ( preg_match( '/-scaled(\.[^.]+)$/', $path ) ) {
			$out[] = str_replace( '-scaled', '', $url );
		} else {
			$ext = pathinfo( $path, PATHINFO_EXTENSION );
			if ( is_string( $ext ) && $ext !== '' ) {
				$scaled_path = preg_replace( '/\.' . preg_quote( $ext, '/' ) . '$/', '-scaled.' . $ext, $path );
				if ( is_string( $scaled_path ) && $scaled_path !== $path ) {
					$out[] = self::rebuild_url( $parts, $scaled_path );
				}
			}
		}

		return array_values( array_unique( array_filter( $out ) ) );
	}

	/**
	 * @param array<string, mixed> $parts wp_parse_url() result.
	 */
	private static function rebuild_url( array $parts, string $path ): string {
		$scheme = isset( $parts['scheme'] ) ? (string) $parts['scheme'] . '://' : '';
		$host   = isset( $parts['host'] ) ? (string) $parts['host'] : '';
		$port   = isset( $parts['port'] ) ? ':' . (int) $parts['port'] : '';
		return $scheme . $host . $port . $path;
	}

	private static function id_from_basename( string $basename ): int {
		$basename = trim( $basename );
		if ( '' === $basename ) {
			return 0;
		}

		global $wpdb;
		if ( ! isset( $wpdb ) ) {
			return 0;
		}

		$like = '%' . $wpdb->esc_like( $basename );
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$post_id = $wpdb->get_var(
			$wpdb->prepare(
				"SELECT post_id FROM {$wpdb->postmeta}
				WHERE meta_key = '_wp_attached_file' AND meta_value LIKE %s
				ORDER BY post_id DESC LIMIT 1",
				$like
			)
		);

		return $post_id ? (int) $post_id : 0;
	}
}
