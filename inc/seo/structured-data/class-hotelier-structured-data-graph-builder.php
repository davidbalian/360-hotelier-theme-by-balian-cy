<?php
/**
 * Assembles Schema.org @graph nodes for the current request.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Builds structured data graph nodes.
 */
final class Hotelier_Structured_Data_Graph_Builder {

	public static function build(): array {
		if ( self::needs_minimal_graph() ) {
			return array(
				self::local_business_node(),
				self::website_node(),
			);
		}

		$graph   = array();
		$graph[] = self::local_business_node();
		$graph[] = self::website_node();

		$page_id = Hotelier_Seo_Meta_Resolver::effective_page_id_for_request();
		$doc_url = self::current_document_url();
		$tpl     = $page_id > 0 ? (string) get_page_template_slug( $page_id ) : '';
		$slug    = $page_id > 0 ? (string) get_post_field( 'post_name', $page_id ) : '';

		$meta  = Hotelier_Seo_Meta_Resolver::resolve_for_request();
		$title = is_array( $meta ) ? $meta['title'] : '';
		$desc  = is_array( $meta ) ? $meta['description'] : '';
		if ( '' === $title && is_singular() ) {
			$title = get_the_title();
		}

		$lang = ( function_exists( 'hotelier_get_current_lang' ) && 'el' === hotelier_get_current_lang() ) ? 'el' : 'en';

		$faq_context  = self::faq_context_for_template( $tpl );
		$faq_entities = ( null !== $faq_context ) ? self::faq_main_entities( $faq_context ) : array();

		$webpage_types = self::webpage_types_for( $tpl, $page_id, $slug );
		if ( $faq_entities !== array() ) {
			$webpage_types = array_values( array_unique( array_merge( $webpage_types, array( 'FAQPage' ) ) ) );
		}

		$webpage = array(
			'@type'       => count( $webpage_types ) === 1 ? $webpage_types[0] : $webpage_types,
			'@id'         => $doc_url . '#webpage',
			'url'         => $doc_url,
			'name'        => $title,
			'isPartOf'    => array( '@id' => self::website_id() ),
			'publisher'   => array( '@id' => self::local_business_id() ),
			'inLanguage'  => $lang,
		);

		if ( '' !== $desc ) {
			$webpage['description'] = $desc;
		}

		if ( $faq_entities !== array() ) {
			$webpage['mainEntity'] = $faq_entities;
		}

		if ( 'page-templates/template-founder.php' === $tpl && $page_id > 0 ) {
			$person  = self::founder_person_node( $page_id, $doc_url );
			$graph[] = $person;
			$webpage['mainEntity'] = array( '@id' => $doc_url . '#person' );
		}

		if ( 'page-templates/template-service-single.php' === $tpl && $page_id > 0 ) {
			$service = self::service_node( $page_id, $slug, $doc_url, $title, $desc );
			$graph[] = $service;
			$webpage['mainEntity'] = array( '@id' => $doc_url . '#service' );
		}

		if ( 'page-templates/template-services.php' === $tpl ) {
			$item_list = self::services_item_list_node( $doc_url );
			$graph[]   = $item_list;
			$webpage['hasPart'] = array( '@id' => $doc_url . '#service-list' );
		}

		$graph[] = $webpage;

		return $graph;
	}

	private static function needs_minimal_graph(): bool {
		if ( is_404() ) {
			return true;
		}

		if ( is_page_template( 'page-templates/template-style-guide.php' ) ) {
			return true;
		}

		if ( is_front_page() && 'page' !== (string) get_option( 'show_on_front' ) ) {
			return true;
		}

		if ( ! is_singular() && ! is_front_page() ) {
			return true;
		}

		return false;
	}

	private static function site_base_for_ids(): string {
		return untrailingslashit( home_url( '/' ) );
	}

	private static function local_business_id(): string {
		return self::site_base_for_ids() . '#localbusiness';
	}

	private static function website_id(): string {
		return self::site_base_for_ids() . '#website';
	}

	private static function current_document_url(): string {
		$logical = Hotelier_Locale_Detector::logical_path_without_lang_prefix();
		$trim    = trim( $logical, '/' );
		$lang    = Hotelier_Locale_Detector::current_lang();

		return home_url( user_trailingslashit( Hotelier_Local_Urls::relative_path_for( $trim, $lang ) ) );
	}

	/**
	 * @return string[]
	 */
	private static function webpage_types_for( string $template, int $page_id, string $slug ): array {
		if ( is_front_page() && 'page' === (string) get_option( 'show_on_front' ) ) {
			return array( 'WebPage' );
		}

		if ( 'page-templates/template-about.php' === $template ) {
			return array( 'AboutPage', 'WebPage' );
		}

		if ( 'page-templates/template-contact.php' === $template ) {
			return array( 'ContactPage', 'WebPage' );
		}

		if ( 'page-templates/template-services.php' === $template ) {
			return array( 'WebPage' );
		}

		if ( 'page-templates/template-portfolio.php' === $template ) {
			return array( 'CollectionPage', 'WebPage' );
		}

		if ( 'page-templates/template-founder.php' === $template ) {
			return array( 'WebPage' );
		}

		if ( 'page-templates/template-service-single.php' === $template ) {
			return array( 'WebPage' );
		}

		if ( in_array( $slug, array( 'privacy-policy', 'cookie-policy', 'terms' ), true ) ) {
			return array( 'WebPage' );
		}

		return array( 'WebPage' );
	}

	private static function faq_context_for_template( string $template ): ?string {
		if ( is_front_page() && 'page' === (string) get_option( 'show_on_front' ) ) {
			return Hotelier_Faq_Content::CONTEXT_FRONT_PAGE;
		}

		if ( 'page-templates/template-contact.php' === $template ) {
			return Hotelier_Faq_Content::CONTEXT_CONTACT;
		}

		if ( 'page-templates/template-services.php' === $template ) {
			return Hotelier_Faq_Content::CONTEXT_SERVICES;
		}

		return null;
	}

	/**
	 * @return array<int, array<string, mixed>>
	 */
	private static function faq_main_entities( string $faq_context ): array {
		$items  = Hotelier_Faq_Content::get_items_for_context( $faq_context );
		$out    = array();
		foreach ( $items as $item ) {
			$text = Hotelier_Faq_Schema_Text::from_blocks( $item['blocks'] );
			if ( '' === $text ) {
				continue;
			}
			$out[] = array(
				'@type'          => 'Question',
				'name'           => $item['question'],
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => $text,
				),
			);
		}
		return $out;
	}

	/**
	 * @return array<string, mixed>
	 */
	private static function founder_person_node( int $page_id, string $doc_url ): array {
		$ctx = 'founder';
		$name = Hotelier_Page_Content::get_text( $page_id, $ctx, 'hero_title' );
		if ( '' === $name ) {
			$name = 'Giorgos Peyiazis';
		}
		$role = Hotelier_Page_Content::get_text( $page_id, $ctx, 'bio_role' );
		$img  = Hotelier_Page_Content::get_image_url( $page_id, $ctx, 'bio_photo' );

		$node = array(
			'@type'    => 'Person',
			'@id'      => $doc_url . '#person',
			'name'     => $name,
			'url'      => $doc_url,
			'worksFor' => array( '@id' => self::local_business_id() ),
		);
		if ( '' !== $role ) {
			$node['jobTitle'] = $role;
		}
		if ( '' !== $img ) {
			$node['image'] = $img;
		}
		return $node;
	}

	/**
	 * @return array<string, mixed>
	 */
	private static function service_node( int $page_id, string $slug, string $doc_url, string $title_fallback, string $desc_fallback ): array {
		$content = function_exists( 'hotelier_get_service_page_content' )
			? hotelier_get_service_page_content( $page_id, $slug )
			: null;

		$name = $title_fallback;
		$desc = $desc_fallback;
		if ( is_array( $content ) ) {
			if ( '' !== $content['title'] ) {
				$name = $content['title'];
			}
			if ( '' !== $content['intro'] ) {
				$desc = wp_strip_all_tags( $content['intro'] );
			}
		}

		$node = array(
			'@type'    => 'Service',
			'@id'      => $doc_url . '#service',
			'name'     => $name,
			'url'      => $doc_url,
			'provider' => array( '@id' => self::local_business_id() ),
		);
		if ( '' !== $desc ) {
			$node['description'] = $desc;
		}
		return $node;
	}

	/**
	 * @return array<string, mixed>
	 */
	private static function services_item_list_node( string $doc_url ): array {
		$elements = array();
		$pos      = 1;
		foreach ( hotelier_get_service_child_slugs() as $child_slug ) {
			$title = '';
			if ( function_exists( 'hotelier_get_service_content' ) ) {
				$bundle = hotelier_get_service_content( $child_slug );
				if ( is_array( $bundle ) && isset( $bundle['title'] ) ) {
					$title = $bundle['title'];
				}
			}
			$elements[] = array(
				'@type'    => 'ListItem',
				'position' => $pos,
				'item'     => array(
					'@type' => 'Service',
					'name'  => $title,
					'url'   => hotelier_get_page_url_by_slug( $child_slug ),
				),
			);
			++$pos;
		}

		return array(
			'@type'           => 'ItemList',
			'@id'             => $doc_url . '#service-list',
			'name'            => __( 'Services', '360-hotelier' ),
			'itemListElement' => $elements,
		);
	}

	/**
	 * @return array<string, mixed>
	 */
	private static function local_business_node(): array {
		$opts = Hotelier_Site_Content_Options::get();

		$telephone = isset( $opts['contact_phone_href'] ) ? trim( (string) $opts['contact_phone_href'] ) : '';
		if ( '' === $telephone ) {
			$telephone = '+35770001818';
		}

		$email = isset( $opts['contact_email'] ) ? trim( (string) $opts['contact_email'] ) : '';

		$address_text = isset( $opts['contact_address'] ) ? trim( (string) $opts['contact_address'] ) : '';
		if ( '' !== $address_text ) {
			$address = array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => $address_text,
				'addressCountry'  => 'CY',
			);
		} else {
			$address = array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => 'Epaminondou 9',
				'addressLocality' => 'Limassol',
				'addressRegion'   => 'Limassol District',
				'postalCode'      => '3075',
				'addressCountry'  => 'CY',
			);
		}

		$logo_url = has_custom_logo()
			? wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' )
			: Hotelier_Site_Content_Options::default_brand_logo_url();

		$home_url = function_exists( 'hotelier_get_localized_home_url' )
			? hotelier_get_localized_home_url()
			: home_url( '/' );

		$node = array(
			'@type'       => array( 'LocalBusiness', 'ProfessionalService' ),
			'@id'         => self::local_business_id(),
			'name'        => '360° Hotelier Consulting',
			'url'         => $home_url,
			'image'       => $logo_url,
			'priceRange'  => '$$',
			'telephone'   => $telephone,
			'address'     => $address,
			'description' => __( 'Hotel revenue management, digital marketing, online sales and tour operator contracting services for hotels in Cyprus.', '360-hotelier' ),
			'areaServed'  => 'Cyprus',
		);

		if ( '' !== $email ) {
			$node['email'] = $email;
		}

		$same_as = array_filter(
			array(
				isset( $opts['social_facebook'] ) ? trim( (string) $opts['social_facebook'] ) : '',
				isset( $opts['social_linkedin'] ) ? trim( (string) $opts['social_linkedin'] ) : '',
				isset( $opts['social_instagram'] ) ? trim( (string) $opts['social_instagram'] ) : '',
			),
			'strlen'
		);
		if ( $same_as !== array() ) {
			$node['sameAs'] = array_values( $same_as );
		}

		return $node;
	}

	/**
	 * @return array<string, mixed>
	 */
	private static function website_node(): array {
		$lang = ( function_exists( 'hotelier_get_current_lang' ) && 'el' === hotelier_get_current_lang() ) ? 'el' : 'en';

		$url = function_exists( 'hotelier_get_localized_home_url' )
			? hotelier_get_localized_home_url()
			: home_url( '/' );

		return array(
			'@type'       => 'WebSite',
			'@id'         => self::website_id(),
			'url'         => $url,
			'publisher'   => array( '@id' => self::local_business_id() ),
			'inLanguage'  => $lang,
		);
	}
}
