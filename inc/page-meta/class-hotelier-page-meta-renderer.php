<?php
/**
 * Meta box markup for Hotelier page content.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders fields for the active context.
 */
final class Hotelier_Page_Meta_Renderer {

	public static function render( WP_Post $post ): void {
		$context = Hotelier_Page_Meta_Schema::context_for_post_id( (int) $post->ID );
		if ( null === $context ) {
			return;
		}
		$fields = Hotelier_Page_Meta_Schema::fields_for_context( $context );
		if ( ! $fields ) {
			return;
		}

		wp_nonce_field( Hotelier_Page_Meta_Sanitizer::NONCE_ACTION, Hotelier_Page_Meta_Sanitizer::NONCE_FIELD );

		echo '<p class="hotelier-page-meta-notice" style="padding:8px 12px;background:#f0f6fc;border-left:4px solid #2271b1;margin:0 0 16px;">';
		echo esc_html__( 'English fields below. Greek (Ελληνικά) inputs will be added in a future phase.', '360-hotelier' );
		echo '</p>';

		echo '<div class="hotelier-page-meta-fields" data-context="' . esc_attr( $context ) . '">';

		$post_id = (int) $post->ID;

		foreach ( $fields as $field => $def ) {
			$label = isset( $def['label'] ) ? (string) $def['label'] : $field;
			$type  = isset( $def['type'] ) ? $def['type'] : 'text';

			echo '<div class="hotelier-page-meta-field" style="margin-bottom:14px;">';
			echo '<label style="display:block;font-weight:600;margin-bottom:4px;" for="hotelier-f-' . esc_attr( $field ) . '">' . esc_html( $label ) . '</label>';

			if ( 'textarea' === $type ) {
				$text = Hotelier_Page_Content::get_admin_input_text( $post_id, $context, $field );
				printf(
					'<textarea class="widefat" style="min-height:72px;" id="hotelier-f-%1$s" name="%2$s[%1$s]">%3$s</textarea>',
					esc_attr( $field ),
					esc_attr( Hotelier_Page_Meta_Sanitizer::INPUT_PREFIX ),
					esc_textarea( $text )
				);
			} elseif ( 'select' === $type ) {
				$options = isset( $def['options'] ) && is_array( $def['options'] ) ? $def['options'] : array();
				$current = Hotelier_Page_Content::get_admin_select_value( $post_id, $context, $field );
				echo '<select class="widefat" id="hotelier-f-' . esc_attr( $field ) . '" name="' . esc_attr( Hotelier_Page_Meta_Sanitizer::INPUT_PREFIX ) . '[' . esc_attr( $field ) . ']">';
				foreach ( $options as $opt_val => $opt_label ) {
					printf(
						'<option value="%s" %s>%s</option>',
						esc_attr( (string) $opt_val ),
						selected( $current, (string) $opt_val, false ),
						esc_html( (string) $opt_label )
					);
				}
				echo '</select>';
			} elseif ( 'image' === $type ) {
				$id = (int) get_post_meta(
					$post->ID,
					Hotelier_Page_Meta_Schema::meta_key( $context, $field ),
					true
				);
				$preview_url  = Hotelier_Page_Content::get_admin_image_preview_url( $post_id, $context, $field );
				$default_url  = isset( $def['default_url'] ) ? (string) $def['default_url'] : '';
				$data_default = ( $id <= 0 && $default_url !== '' ) ? $default_url : '';
				echo '<div class="hotelier-image-field" data-field="' . esc_attr( $field ) . '" data-default-preview-url="' . esc_url( $data_default ) . '">';
				echo '<input type="hidden" class="hotelier-image-id" id="hotelier-f-' . esc_attr( $field ) . '" name="' . esc_attr( Hotelier_Page_Meta_Sanitizer::INPUT_PREFIX ) . '[' . esc_attr( $field ) . ']" value="' . esc_attr( (string) $id ) . '">';
				echo '<p class="hotelier-image-preview" style="min-height:40px;">';
				if ( $preview_url !== '' ) {
					echo '<img src="' . esc_url( $preview_url ) . '" alt="" style="max-height:80px;width:auto;">';
				}
				echo '</p>';
				if ( $id <= 0 && $preview_url !== '' ) {
					echo '<p class="description" style="margin:4px 0 8px;">' . esc_html__( 'Preview shows the theme default. Choose an image to override; Clear keeps the default on the site.', '360-hotelier' ) . '</p>';
				}
				echo '<button type="button" class="button hotelier-pick-image">' . esc_html__( 'Select image', '360-hotelier' ) . '</button> ';
				echo '<button type="button" class="button hotelier-clear-image">' . esc_html__( 'Clear', '360-hotelier' ) . '</button>';
				echo '</div>';
			} else {
				$text = Hotelier_Page_Content::get_admin_input_text( $post_id, $context, $field );
				printf(
					'<input class="widefat" type="text" id="hotelier-f-%1$s" name="%2$s[%1$s]" value="%3$s">',
					esc_attr( $field ),
					esc_attr( Hotelier_Page_Meta_Sanitizer::INPUT_PREFIX ),
					esc_attr( $text )
				);
			}

			echo '</div>';
		}

		echo '</div>';
	}
}
