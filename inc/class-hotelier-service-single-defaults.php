<?php
/**
 * Per-slug defaults for service single template (overview image URL/alt, seed copy).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Slug-keyed fallbacks; shared schema context is `service`.
 */
final class Hotelier_Service_Single_Defaults {

	private const UPLOAD_SUBDIR = '/uploads/2026/03/';

	/**
	 * @return string[]
	 */
	public static function known_slugs(): array {
		return array(
			'revenue-management',
			'online-sales-distribution',
			'digital-marketing',
			'tour-operator-contracting',
		);
	}

	public static function is_known_slug( string $slug ): bool {
		return in_array( $slug, self::known_slugs(), true );
	}

	public static function default_overview_image_url( string $slug ): string {
		$files = array(
			'revenue-management'          => 'hotel-revenue-management-strategy-cyprus.webp',
			'online-sales-distribution' => 'hotel-online-sales-distribution-strategy-1.webp',
			'digital-marketing'         => 'hotel-digital-marketing-direct-bookings-1.webp',
			'tour-operator-contracting' => 'hotel-tour-operator-contracting-negotiations-1.webp',
		);
		if ( ! isset( $files[ $slug ] ) ) {
			return '';
		}
		return content_url( self::UPLOAD_SUBDIR . $files[ $slug ] );
	}

	public static function default_overview_image_alt( string $slug, string $lang ): string {
		$en = array(
			'revenue-management'          => 'Hotel revenue management strategy including pricing optimisation and RevPAR performance analysis',
			'online-sales-distribution' => 'Hotel online sales and B2B distribution strategy including OTA optimisation and travel partnerships',
			'digital-marketing'         => 'Hotel digital marketing strategy focused on SEO, direct bookings and website optimisation',
			'tour-operator-contracting' => 'Hotel tour operator contracting and negotiation strategy with international travel partners',
		);
		$el = array(
			'revenue-management'          => 'Στρατηγική revenue management ξενοδοχείου με βελτιστοποίηση τιμών και ανάλυση απόδοσης RevPAR',
			'online-sales-distribution' => 'Στρατηγική online πωλήσεων και B2B διανομής ξενοδοχείου με βελτιστοποίηση OTA και συνεργασίες ταξιδιωτικών εταίρων',
			'digital-marketing'         => 'Στρατηγική ψηφιακού μάρκετινγκ ξενοδοχείου με SEO, άμεσες κρατήσεις και βελτιστοποίηση ιστοσελίδας',
			'tour-operator-contracting' => 'Συμβάσεις και διαπραγματεύσεις με tour operators και διεθνείς ταξιδιωτικούς εταίρους για ξενοδοχεία',
		);
		$map = ( 'el' === $lang ) ? $el : $en;
		return isset( $map[ $slug ] ) ? $map[ $slug ] : '';
	}

	/**
	 * English strings for ACF seeding (matches theme gettext sources).
	 *
	 * @return array<string, string>|null hero_title, intro, deliver_1..5, overview_heading, deliver_heading, overview_img_alt, cta_*
	 */
	public static function seed_text_fields_en( string $slug ): ?array {
		$row = self::english_row( $slug );
		if ( ! $row ) {
			return null;
		}
		$out = array(
			'hero_title'         => $row['title'],
			'intro'              => $row['intro'],
			'overview_heading'   => 'Overview',
			'deliver_heading'    => 'What We Deliver',
			'overview_img_alt'   => self::default_overview_image_alt( $slug, 'en' ),
			'cta_feat_title'     => "Let's Build Your Hotel's Commercial Strategy",
			'cta_feat_text'      => "Book a free strategy session and let's discuss how we can help your hotel grow.",
			'cta_feat_primary'   => 'Get in Touch',
			'cta_feat_secondary' => 'All Services',
		);
		foreach ( $row['deliverables'] as $i => $text ) {
			$out[ 'deliver_' . ( $i + 1 ) ] = $text;
		}
		return $out;
	}

	/**
	 * Greek strings for ACF seeding.
	 *
	 * @return array<string, string>|null
	 */
	public static function seed_text_fields_el( string $slug ): ?array {
		$row = self::greek_row( $slug );
		if ( ! $row ) {
			return null;
		}
		$out = array(
			'hero_title'         => $row['title'],
			'intro'              => $row['intro'],
			'overview_heading'   => 'Επισκόπηση',
			'deliver_heading'    => 'Τι παραδίδουμε',
			'overview_img_alt'   => self::default_overview_image_alt( $slug, 'el' ),
			'cta_feat_title'     => 'Ας χτίσουμε την εμπορική στρατηγική του ξενοδοχείου σας',
			'cta_feat_text'      => 'Κλείστε μια δωρεάν στρατηγική συνάντηση και ας δούμε πώς μπορούμε να βοηθήσουμε το ξενοδοχείο σας να αναπτυχθεί.',
			'cta_feat_primary'   => 'Επικοινωνήστε',
			'cta_feat_secondary' => 'Όλες οι υπηρεσίες',
		);
		foreach ( $row['deliverables'] as $i => $text ) {
			$out[ 'deliver_' . ( $i + 1 ) ] = $text;
		}
		return $out;
	}

	/**
	 * @return array{title: string, intro: string, deliverables: string[]}|null
	 */
	private static function english_row( string $slug ): ?array {
		switch ( $slug ) {
			case 'revenue-management':
				return array(
					'title'        => 'Yield & Revenue Management',
					'intro'        => 'Hotels often lose revenue through inconsistent pricing, weak forecasting and limited data. We implement revenue-management systems, pricing models and demand-based decisions specific to your property.',
					'deliverables' => array(
						'Daily / weekly / monthly pricing strategy',
						'Forecasting & demand analysis',
						'OTA & competitor benchmarking',
						'Segmentation & channel-mix optimisation',
						'RevPAR and profitability reporting',
					),
				);
			case 'online-sales-distribution':
				return array(
					'title'        => 'Online Sales & B2B Distribution',
					'intro'        => 'Many hotels rely too heavily on OTAs while leaving B2B contracts, wholesalers and niche partners untapped. We build a distribution mix that cuts OTA dependency and improves margin.',
					'deliverables' => array(
						'OTA profile optimisation and content scoring',
						'New B2B partnership sourcing',
						'Wholesaler contracts & dynamic rate setups',
						'Rate parity monitoring',
						'Channel manager & PMS optimisation',
					),
				);
			case 'digital-marketing':
				return array(
					'title'        => 'E-Commerce & Digital Marketing',
					'intro'        => 'Your website and social channels can drive direct bookings and reduce OTA costs. We build digital strategies that convert.',
					'deliverables' => array(
						'Website audit & booking engine optimisation',
						'SEO (search optimisation) & SEM (paid ads)',
						'Social media content strategy',
						'Email marketing & guest-journey automation',
						'Analytics dashboards & conversion tracking',
					),
				);
			case 'tour-operator-contracting':
				return array(
					'title'        => 'Contracting & Negotiations (Tour Operators)',
					'intro'        => 'We represent your hotel in negotiations — securing better margins, tighter allotment terms and competitive agreements with tour operators.',
					'deliverables' => array(
						'Contract benchmarking & performance evaluation',
						'New tour-operator network development',
						'Rate strategy & allotment planning',
						'Negotiation support and final handover',
						'Ongoing monitoring of production & terms',
					),
				);
			default:
				return null;
		}
	}

	/**
	 * @return array{title: string, intro: string, deliverables: string[]}|null
	 */
	private static function greek_row( string $slug ): ?array {
		switch ( $slug ) {
			case 'revenue-management':
				return array(
					'title'        => 'Yield & Revenue Management για Ξενοδοχεία',
					'intro'        => 'Πολλά ξενοδοχεία χάνουν σημαντικά έσοδα λόγω λανθασμένης τιμολόγησης, ανεπαρκούς πρόβλεψης ζήτησης και περιορισμένης αξιοποίησης δεδομένων αγοράς. Η 360 Hotelier Consulting εφαρμόζει επαγγελματικές πρακτικές Revenue Management για ξενοδοχεία, βασισμένες σε πραγματικά δεδομένα αγοράς, ανταγωνιστική ανάλυση και σύγχρονες στρατηγικές τιμολόγησης. Στόχος μας είναι η αύξηση του RevPAR, της πληρότητας και της συνολικής κερδοφορίας του ξενοδοχείου σας.',
					'deliverables' => array(
						'Στρατηγική τιμολόγησης σε καθημερινή, εβδομαδιαία και μηνιαία βάση',
						'Forecasting και ανάλυση ζήτησης αγοράς',
						'Benchmarking OTA και ανταγωνιστικών ξενοδοχείων',
						'Βελτιστοποίηση segmentation και channel mix',
						'Αναφορές RevPAR, ADR και profitability',
					),
				);
			case 'online-sales-distribution':
				return array(
					'title'        => 'Online Sales & B2B Distribution για Ξενοδοχεία',
					'intro'        => 'Πολλά ξενοδοχεία εξαρτώνται υπερβολικά από OTA πλατφόρμες, χάνοντας ευκαιρίες από B2B συνεργασίες, wholesalers και εξειδικευμένα travel partners. Σχεδιάζουμε μια ολοκληρωμένη στρατηγική distribution management, που βοηθά το ξενοδοχείο σας να αυξήσει την παρουσία του στις διεθνείς αγορές και να δημιουργήσει πιο αποδοτικά κανάλια πωλήσεων.',
					'deliverables' => array(
						'Βελτιστοποίηση OTA προφίλ και περιεχομένου',
						'Ανάπτυξη νέων B2B συνεργασιών',
						'Συμβόλαια με wholesalers και dynamic rate setups',
						'Παρακολούθηση rate parity',
						'Βελτιστοποίηση Channel Manager και PMS',
					),
				);
			case 'digital-marketing':
				return array(
					'title'        => 'E-Commerce & Digital Marketing για Ξενοδοχεία',
					'intro'        => 'Η ιστοσελίδα του ξενοδοχείου σας πρέπει να αποτελεί ένα ισχυρό εργαλείο πωλήσεων και όχι απλώς μια online παρουσία. Σχεδιάζουμε και υλοποιούμε στρατηγικές digital marketing για ξενοδοχεία, που αυξάνουν την επισκεψιμότητα, ενισχύουν το brand και οδηγούν σε περισσότερες απευθείας κρατήσεις.',
					'deliverables' => array(
						'Έλεγχος ιστοσελίδας (website audit) και βελτιστοποίηση booking engine',
						'SEO για ξενοδοχεία (βελτιστοποίηση στις μηχανές αναζήτησης)',
						'SEM και Google Ads καμπάνιες (πληρωμένες διαφημίσεις)',
						'Στρατηγική περιεχομένου για social media, email marketing και αυτοματοποίηση guest journey',
						'Analytics dashboards και παρακολούθηση conversion rates',
					),
				);
			case 'tour-operator-contracting':
				return array(
					'title'        => 'Contracting & Διαπραγματεύσεις με Tour Operators',
					'intro'        => 'Η σωστή διαχείριση συμβολαίων με tour operators και ταξιδιωτικούς οργανισμούς είναι κρίσιμη για τη μακροχρόνια ανάπτυξη ενός ξενοδοχείου. Η ομάδα μας εκπροσωπεί το ξενοδοχείο σας στις διαπραγματεύσεις, εξασφαλίζοντας ανταγωνιστικές τιμές, σωστό σχεδιασμό allotments και ισορροπημένες συνεργασίες.',
					'deliverables' => array(
						'Benchmarking συμβολαίων και αξιολόγηση απόδοσης συνεργασιών',
						'Ανάπτυξη νέου δικτύου tour operators',
						'Στρατηγική τιμολόγησης και σχεδιασμός allotments',
						'Υποστήριξη διαπραγματεύσεων μέχρι την τελική συμφωνία',
						'Συνεχής παρακολούθηση παραγωγής και όρων συνεργασίας',
					),
				);
			default:
				return null;
		}
	}
}
