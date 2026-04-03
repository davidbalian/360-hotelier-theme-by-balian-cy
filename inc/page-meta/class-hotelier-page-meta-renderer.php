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

		$post_id = (int) $post->ID;

		// EN group.
		echo '<h3 style="margin:0 0 12px;font-size:13px;text-transform:uppercase;letter-spacing:.06em;color:#50575e;">English (EN)</h3>';
		echo '<div class="hotelier-page-meta-fields" data-context="' . esc_attr( $context ) . '">';
		self::render_fields( $post_id, $context, $fields, Hotelier_Page_Meta_Sanitizer::INPUT_PREFIX, '' );
		echo '</div>';

		// EL group.
		echo '<hr style="margin:20px 0;">';
		echo '<h3 style="margin:0 0 4px;font-size:13px;text-transform:uppercase;letter-spacing:.06em;color:#50575e;">Ελληνικά (EL)</h3>';
		echo '<p style="margin:0 0 12px;color:#646970;font-size:12px;">Leave empty to inherit the English value on the front end.</p>';
		echo '<div class="hotelier-page-meta-fields hotelier-page-meta-fields--el" data-context="' . esc_attr( $context ) . '">';
		self::render_fields( $post_id, $context, $fields, Hotelier_Page_Meta_Sanitizer::INPUT_PREFIX_EL, '_el' );
		echo '</div>';
	}

	/**
	 * Renders one group of fields (EN or EL).
	 *
	 * @param int                        $post_id       Post ID.
	 * @param string                     $context       Schema context slug.
	 * @param array<string, mixed>       $fields        Field definitions from schema.
	 * @param string                     $input_prefix  Form input name prefix.
	 * @param string                     $key_suffix    Meta key suffix: '' for EN, '_el' for EL.
	 */
	private static function render_fields( int $post_id, string $context, array $fields, string $input_prefix, string $key_suffix ): void {
		foreach ( $fields as $field => $def ) {
			$label = isset( $def['label'] ) ? (string) $def['label'] : $field;
			$type  = isset( $def['type'] ) ? $def['type'] : 'text';
			$fid   = 'hotelier-f-' . esc_attr( $field ) . ( $key_suffix !== '' ? '-el' : '' );

			// Images are not language-specific — skip the EL group for image fields.
			if ( 'image' === $type && $key_suffix !== '' ) {
				continue;
			}

			echo '<div class="hotelier-page-meta-field" style="margin-bottom:14px;">';
			echo '<label style="display:block;font-weight:600;margin-bottom:4px;" for="' . esc_attr( $fid ) . '">' . esc_html( $label ) . '</label>';

			if ( 'textarea' === $type ) {
				if ( $key_suffix !== '' ) {
					$meta_key = Hotelier_Page_Meta_Schema::meta_key( $context, $field ) . $key_suffix;
					$raw      = get_post_meta( $post_id, $meta_key, true );
					$text     = is_string( $raw ) ? $raw : '';
				} else {
					$text = Hotelier_Page_Content::get_admin_input_text( $post_id, $context, $field );
				}
				printf(
					'<textarea class="widefat" style="min-height:72px;" id="%1$s" name="%2$s[%3$s]">%4$s</textarea>',
					esc_attr( $fid ),
					esc_attr( $input_prefix ),
					esc_attr( $field ),
					esc_textarea( $text )
				);
			} elseif ( 'select' === $type ) {
				// Select fields are not language-specific — only render in EN group.
				if ( $key_suffix !== '' ) {
					echo '</div>';
					continue;
				}
				$options = isset( $def['options'] ) && is_array( $def['options'] ) ? $def['options'] : array();
				$current = Hotelier_Page_Content::get_admin_select_value( $post_id, $context, $field );
				echo '<select class="widefat" id="' . esc_attr( $fid ) . '" name="' . esc_attr( $input_prefix ) . '[' . esc_attr( $field ) . ']">';
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
				// EN only (EL skipped above).
				$id = (int) get_post_meta( $post_id, Hotelier_Page_Meta_Schema::meta_key( $context, $field ), true );
				$preview_url  = Hotelier_Page_Content::get_admin_image_preview_url( $post_id, $context, $field );
				$default_url  = isset( $def['default_url'] ) ? (string) $def['default_url'] : '';
				$data_default = ( $id <= 0 && $default_url !== '' ) ? $default_url : '';
				echo '<div class="hotelier-image-field" data-field="' . esc_attr( $field ) . '" data-default-preview-url="' . esc_url( $data_default ) . '">';
				echo '<input type="hidden" class="hotelier-image-id" id="' . esc_attr( $fid ) . '" name="' . esc_attr( $input_prefix ) . '[' . esc_attr( $field ) . ']" value="' . esc_attr( (string) $id ) . '">';
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
				if ( $key_suffix !== '' ) {
					$meta_key = Hotelier_Page_Meta_Schema::meta_key( $context, $field ) . $key_suffix;
					$raw      = get_post_meta( $post_id, $meta_key, true );
					$text     = is_string( $raw ) ? $raw : '';
				} else {
					$text = Hotelier_Page_Content::get_admin_input_text( $post_id, $context, $field );
				}
				printf(
					'<input class="widefat" type="text" id="%1$s" name="%2$s[%3$s]" value="%4$s">',
					esc_attr( $fid ),
					esc_attr( $input_prefix ),
					esc_attr( $field ),
					esc_attr( $text )
				);
			}

			echo '</div>';
		}
	}
}
