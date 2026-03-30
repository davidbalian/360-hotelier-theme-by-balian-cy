<?php
/**
 * Page meta field schema: contexts, template map, field definitions.
 *
 * @todo Greek (Ελληνικά): add parallel meta keys (e.g. suffix _el) and fields below English
 *       in the meta UI once translations are required.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Schema registry for editable page content.
 */
final class Hotelier_Page_Meta_Schema {

	public const META_PREFIX = '_hotelier_ctx_';

	/**
	 * Page template file => context slug.
	 *
	 * @var array<string, string>
	 */
	private const TEMPLATE_MAP = array(
		'page-templates/template-about.php'         => 'about',
		'page-templates/template-services.php'      => 'services',
		'page-templates/template-service-single.php' => 'service',
		'page-templates/template-portfolio.php'     => 'portfolio',
		'page-templates/template-contact.php'       => 'contact',
		'page-templates/template-founder.php'       => 'founder',
	);

	/**
	 * @return array<string, array<string, mixed>>
	 */
	public static function all_contexts(): array {
		static $cache = null;
		if ( null !== $cache ) {
			return $cache;
		}
		$dir  = __DIR__ . '/schema/';
		$cache = array(
			'home'      => require $dir . 'schema-home.php',
			'about'     => require $dir . 'schema-about.php',
			'services'  => require $dir . 'schema-services.php',
			'service'   => require $dir . 'schema-service.php',
			'portfolio' => require $dir . 'schema-portfolio.php',
			'contact'   => require $dir . 'schema-contact.php',
			'founder'   => require $dir . 'schema-founder.php',
		);
		return $cache;
	}

	/**
	 * @return array<string, mixed>|null
	 */
	public static function fields_for_context( string $context ): ?array {
		$all = self::all_contexts();
		return isset( $all[ $context ] ) ? $all[ $context ] : null;
	}

	public static function meta_key( string $context, string $field ): string {
		return self::META_PREFIX . $context . '_' . $field;
	}

	/**
	 * Context for a page post, or null if this screen should not show the box.
	 */
	public static function context_for_post_id( int $post_id ): ?string {
		if ( $post_id <= 0 ) {
			return null;
		}
		$front = (int) get_option( 'page_on_front' );
		if ( $front === $post_id ) {
			return 'home';
		}
		$tpl = get_page_template_slug( $post_id );
		if ( $tpl && isset( self::TEMPLATE_MAP[ $tpl ] ) ) {
			return self::TEMPLATE_MAP[ $tpl ];
		}
		return null;
	}

	/**
	 * @return list<string>
	 */
	public static function contexts_with_meta_box(): array {
		return array_keys( self::all_contexts() );
	}
}
