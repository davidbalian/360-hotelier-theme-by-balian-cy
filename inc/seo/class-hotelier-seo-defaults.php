<?php
/**
 * Fallback document title and meta description strings (EN/EL per context).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hardcoded SEO defaults used when ACF fields are empty.
 */
final class Hotelier_Seo_Defaults {

	/**
	 * @return array<string, array<string, array{title: string, description: string}>>
	 */
	public static function services_map(): array {
		return array(
			'services'                  => array(
				'en' => array(
					'title'       => 'Hotel Consulting Services | Revenue Management & Hotel Sales Strategy',
					'description' => 'Discover hotel consulting services including revenue management, OTA optimisation, digital marketing and tour operator contracting to increase hotel revenue and direct bookings.',
				),
				'el' => array(
					'title'       => 'Υπηρεσίες Hotel Consulting | Revenue Management & Online Sales Strategy',
					'description' => 'Ανακαλύψτε τις υπηρεσίες hotel consulting της 360 Hotelier: revenue management, online sales, OTA optimization, digital marketing και contracting με tour operators.',
				),
			),
			'revenue-management'        => array(
				'en' => array(
					'title'       => 'Hotel Revenue Management Services | Pricing Strategy & RevPAR Growth',
					'description' => 'Professional revenue management for hotels: dynamic pricing, forecasting, competitor benchmarking and channel optimisation to increase RevPAR and overall profitability.',
				),
				'el' => array(
					'title'       => 'Revenue Management για Ξενοδοχεία | Pricing Strategy & RevPAR Growth',
					'description' => 'Επαγγελματικές υπηρεσίες revenue management για ξενοδοχεία. Dynamic pricing, forecasting, competitor benchmarking και στρατηγική αύξησης RevPAR και πληρότητας.',
				),
			),
			'online-sales-distribution' => array(
				'en' => array(
					'title'       => 'Hotel Online Sales & Distribution Strategy | OTA & B2B Partnerships',
					'description' => 'Improve your hotel distribution strategy with OTA optimisation, wholesaler contracts and B2B partnerships that increase visibility and reduce OTA dependency.',
				),
				'el' => array(
					'title'       => 'Digital Marketing για Ξενοδοχεία | SEO, Direct Bookings & Online Growth',
					'description' => 'Αυξήστε τις απευθείας κρατήσεις του ξενοδοχείου σας με στρατηγικές SEO, Google Ads, social media marketing και βελτιστοποίηση booking engine.',
				),
			),
			'digital-marketing'         => array(
				'en' => array(
					'title'       => 'Hotel Digital Marketing Services | SEO, Direct Bookings & Growth',
					'description' => 'Increase direct hotel bookings with SEO, Google Ads, social media strategy and booking engine optimisation designed to boost your hotel’s online performance.',
				),
				'el' => array(
					'title'       => 'Digital Marketing για Ξενοδοχεία | SEO, Direct Bookings & Online Growth',
					'description' => 'Αυξήστε τις απευθείας κρατήσεις του ξενοδοχείου σας με στρατηγικές SEO, Google Ads, social media marketing και βελτιστοποίηση booking engine.',
				),
			),
			'tour-operator-contracting' => array(
				'en' => array(
					'title'       => 'Tour Operator Contracting for Hotels | Negotiation & Distribution',
					'description' => 'Expert negotiation and contracting with tour operators and travel partners to secure competitive rates, optimise allotments and grow hotel revenue.',
				),
				'el' => array(
					'title'       => 'Tour Operator Contracting για Ξενοδοχεία | Συμβόλαια & Διαπραγματεύσεις',
					'description' => 'Διαπραγμάτευση συμβολαίων με tour operators και ταξιδιωτικούς οργανισμούς. Βελτιστοποίηση allotments, τιμών και συνεργασιών για αύξηση εσόδων ξενοδοχείων.',
				),
			),
		);
	}

	/**
	 * @return array<string, array<string, array{title: string, description: string}>>
	 */
	public static function legal_pages_map(): array {
		return array(
			'contact'        => array(
				'en' => array(
					'title'       => 'Contact 360 Hotelier Consulting | Book Your Hotel Strategy Session',
					'description' => 'Contact 360 Hotelier Consulting to discuss revenue management, distribution strategy and digital growth for your hotel in Cyprus.',
				),
				'el' => array(
					'title'       => 'Επικοινωνία με την 360 Hotelier Consulting | Κλείστε Στρατηγική Συνεδρία',
					'description' => 'Επικοινωνήστε με την 360 Hotelier Consulting για revenue management, στρατηγική διανομής και digital ανάπτυξη του ξενοδοχείου σας στην Κύπρο.',
				),
			),
			'privacy-policy' => array(
				'en' => array(
					'title'       => 'Privacy Policy | 360 Hotelier Consulting',
					'description' => 'Read the Privacy Policy of 360 Hotelier Consulting to understand how we collect, use and protect your personal data.',
				),
				'el' => array(
					'title'       => 'Πολιτική Απορρήτου | 360 Hotelier Consulting',
					'description' => 'Διαβάστε την Πολιτική Απορρήτου της 360 Hotelier Consulting για το πώς συλλέγουμε, χρησιμοποιούμε και προστατεύουμε τα προσωπικά σας δεδομένα.',
				),
			),
			'cookie-policy'  => array(
				'en' => array(
					'title'       => 'Cookie Policy | 360 Hotelier Consulting',
					'description' => 'Learn how 360 Hotelier Consulting uses cookies and similar technologies to improve site performance and user experience.',
				),
				'el' => array(
					'title'       => 'Πολιτική Cookies | 360 Hotelier Consulting',
					'description' => 'Μάθετε πώς η 360 Hotelier Consulting χρησιμοποιεί cookies και παρόμοιες τεχνολογίες για βελτίωση απόδοσης και εμπειρίας χρήσης.',
				),
			),
			'terms'          => array(
				'en' => array(
					'title'       => 'Terms & Conditions | 360 Hotelier Consulting',
					'description' => 'Review the Terms & Conditions of 360 Hotelier Consulting for the rules governing use of this website and its services.',
				),
				'el' => array(
					'title'       => 'Όροι & Προϋποθέσεις | 360 Hotelier Consulting',
					'description' => 'Δείτε τους Όρους & Προϋποθέσεις της 360 Hotelier Consulting για τους κανόνες χρήσης της ιστοσελίδας και των υπηρεσιών της.',
				),
			),
		);
	}

	/**
	 * @return array{en: array{title: string, description: string}, el: array{title: string, description: string}}|null
	 */
	public static function bilingual_pair( string $context ): ?array {
		if ( 'home' === $context ) {
			return array(
				'en' => array(
					'title'       => '360° Hotelier Consulting | Revenue, Distribution & Digital Strategy for Hotels in Cyprus',
					'description' => 'Hotel revenue management, online sales, digital marketing and tour-operator contracting for Cyprus hotels. Boost bookings, optimize distribution, increase profit.',
				),
				'el' => array(
					'title'       => '360° Hotelier Consulting | Έσοδα, Διανομή & Digital Marketing για Ξενοδοχεία στην Κύπρο',
					'description' => 'Διαχείριση εσόδων, online πωλήσεις, digital marketing & συμβόλαια με tour operators για ξενοδοχεία Κύπρου. Αυξήστε κρατήσεις & κέρδη.',
				),
			);
		}

		if ( 'founder' === $context ) {
			return array(
				'en' => array(
					'title'       => 'Giorgos Peyiazis | Founder of 360 Hotelier Consulting Cyprus',
					'description' => 'Meet Giorgos Peyiazis, founder of 360 Hotelier Consulting. Hospitality consultant specialising in hotel revenue management, online sales and digital distribution.',
				),
				'el' => array(
					'title'       => 'Γιώργος Πεγιαζής | Ιδρυτής 360 Hotelier Consulting',
					'description' => 'Γνωρίστε τον Γιώργο Πεγιαζή, ιδρυτή της 360 Hotelier Consulting και σύμβουλο ξενοδοχείων με εξειδίκευση σε revenue management και online πωλήσεις.',
				),
			);
		}

		if ( 'about' === $context ) {
			return array(
				'en' => array(
					'title'       => 'Hotel Consultant Cyprus | 360 Hotelier Consulting',
					'description' => '360° Hotelier Consulting is a leading hotel consultant in Cyprus, specializing in revenue management, online sales, digital marketing and tour-operator contracting.',
				),
				'el' => array(
					'title'       => 'Συμβουλευτικές Υπηρεσίες Ξενοδοχείων στην Κύπρο | 360 Hotelier Consulting',
					'description' => 'Η 360 Hotelier Consulting είναι εταιρεία συμβουλευτικών υπηρεσιών ξενοδοχείων στην Κύπρο με εξειδίκευση σε revenue management, online πωλήσεις και στρατηγική διανομής.',
				),
			);
		}

		if ( 'portfolio' === $context ) {
			return array(
				'en' => array(
					'title'       => 'Hotel Consulting Portfolio | 360 Hotelier Consulting Cyprus',
					'description' => 'Explore the portfolio of 360 Hotelier Consulting and discover how we help hotels in Cyprus improve revenue, optimize distribution and increase direct bookings.',
				),
				'el' => array(
					'title'       => 'Portfolio Ξενοδοχειακών Συνεργασιών | 360 Hotelier Consulting Cyprus',
					'description' => 'Δείτε το portfolio της 360 Hotelier Consulting και πώς βοηθάμε ξενοδοχεία στην Κύπρο να αυξήσουν έσοδα, απευθείας κρατήσεις και απόδοση καναλιών πώλησης.',
				),
			);
		}

		$services = self::services_map();
		if ( isset( $services[ $context ] ) ) {
			return array(
				'en' => $services[ $context ]['en'],
				'el' => $services[ $context ]['el'],
			);
		}

		$legal = self::legal_pages_map();
		if ( isset( $legal[ $context ] ) ) {
			return array(
				'en' => $legal[ $context ]['en'],
				'el' => $legal[ $context ]['el'],
			);
		}

		return null;
	}

	/**
	 * @return array{title: string, description: string}|null
	 */
	public static function for_lang( string $context, string $lang ): ?array {
		$pair = self::bilingual_pair( $context );
		if ( null === $pair ) {
			return null;
		}
		$lang = ( 'el' === $lang ) ? 'el' : 'en';
		return $pair[ $lang ];
	}
}
