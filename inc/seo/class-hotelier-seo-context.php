<?php
/**
 * Maps a page ID to a theme SEO context key for defaults and seeding.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Resolves which hardcoded SEO bundle applies to a page, if any.
 */
final class Hotelier_Seo_Context {

	/**
	 * Context keys match {@see Hotelier_Seo_Defaults::bilingual_pair()}.
	 *
	 * @return string|null e.g. home, founder, services, revenue-management, contact, privacy-policy.
	 */
	public static function for_page_id( int $page_id ): ?string {
		if ( $page_id <= 0 ) {
			return null;
		}

		$post = get_post( $page_id );
		if ( ! $post instanceof WP_Post || 'page' !== $post->post_type ) {
			return null;
		}

		if ( 'page' === (string) get_option( 'show_on_front' ) && $page_id === (int) get_option( 'page_on_front' ) ) {
			return 'home';
		}

		$slug = (string) $post->post_name;
		$tpl  = (string) get_page_template_slug( $page_id );

		if ( 'page-templates/template-founder.php' === $tpl ) {
			return 'founder';
		}
		if ( 'page-templates/template-about.php' === $tpl ) {
			return 'about';
		}
		if ( 'page-templates/template-portfolio.php' === $tpl ) {
			return 'portfolio';
		}
		if ( 'page-templates/template-contact.php' === $tpl ) {
			return 'contact';
		}
		if ( 'page-templates/template-services.php' === $tpl ) {
			return 'services';
		}
		if ( 'page-templates/template-service-single.php' === $tpl ) {
			$map = Hotelier_Seo_Defaults::services_map();
			return isset( $map[ $slug ] ) ? $slug : null;
		}

		if ( in_array( $slug, array( 'privacy-policy', 'cookie-policy', 'terms' ), true ) ) {
			$legal = Hotelier_Seo_Defaults::legal_pages_map();
			return isset( $legal[ $slug ] ) ? $slug : null;
		}

		return null;
	}
}
