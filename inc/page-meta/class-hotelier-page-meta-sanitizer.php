<?php
/**
 * Save handler for Hotelier page content meta.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Persists meta from POST.
 */
final class Hotelier_Page_Meta_Sanitizer {

	public const NONCE_ACTION   = 'hotelier_save_page_ctx';
	public const NONCE_FIELD  = 'hotelier_page_ctx_nonce';
	public const INPUT_PREFIX = 'hotelier_ctx';

	public static function register(): void {
		add_action( 'save_post_page', array( self::class, 'save' ), 10, 2 );
	}

	/**
	 * @param int     $post_id Post ID.
	 * @param WP_Post $post    Post object.
	 */
	public static function save( int $post_id, $post ): void {
		if ( ! isset( $_POST[ self::NONCE_FIELD ] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ self::NONCE_FIELD ] ) ), self::NONCE_ACTION ) ) {
			return;
		}
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}
		if ( ! current_user_can( 'edit_page', $post_id ) ) {
			return;
		}
		if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
			return;
		}

		$context = Hotelier_Page_Meta_Schema::context_for_post_id( $post_id );
		if ( null === $context ) {
			return;
		}

		$fields = Hotelier_Page_Meta_Schema::fields_for_context( $context );
		if ( ! $fields ) {
			return;
		}

		$input = isset( $_POST[ self::INPUT_PREFIX ] ) && is_array( $_POST[ self::INPUT_PREFIX ] )
			? wp_unslash( $_POST[ self::INPUT_PREFIX ] )
			: array();

		foreach ( $fields as $field => $def ) {
			$key  = Hotelier_Page_Meta_Schema::meta_key( $context, $field );
			$type = isset( $def['type'] ) ? $def['type'] : 'text';

			if ( 'image' === $type ) {
				$raw = isset( $input[ $field ] ) ? $input[ $field ] : '';
				$id  = absint( $raw );
				if ( $id > 0 && 'attachment' === get_post_type( $id ) ) {
					update_post_meta( $post_id, $key, $id );
				} else {
					delete_post_meta( $post_id, $key );
				}
				continue;
			}

			if ( 'select' === $type ) {
				$raw     = isset( $input[ $field ] ) ? sanitize_text_field( (string) $input[ $field ] ) : '';
				$options = isset( $def['options'] ) && is_array( $def['options'] ) ? array_keys( $def['options'] ) : array();
				if ( $raw !== '' && in_array( $raw, $options, true ) ) {
					update_post_meta( $post_id, $key, $raw );
				} else {
					delete_post_meta( $post_id, $key );
				}
				continue;
			}

			if ( 'textarea' === $type ) {
				$raw = isset( $input[ $field ] ) ? sanitize_textarea_field( (string) $input[ $field ] ) : '';
				if ( $raw !== '' ) {
					update_post_meta( $post_id, $key, $raw );
				} else {
					delete_post_meta( $post_id, $key );
				}
				continue;
			}

			$raw = isset( $input[ $field ] ) ? sanitize_text_field( (string) $input[ $field ] ) : '';
			if ( $raw !== '' ) {
				update_post_meta( $post_id, $key, $raw );
			} else {
				delete_post_meta( $post_id, $key );
			}
		}
	}
}
