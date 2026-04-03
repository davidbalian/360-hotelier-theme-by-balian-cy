<?php
/**
 * Greek fallbacks for page meta schema defaults (empty saved meta, locale el).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Map of "context.field" => Greek string.
 */
final class Hotelier_El_Page_Defaults {

	/**
	 * Suffix of home hero title line 2 (broken to its own row on desktop via CSS).
	 */
	public const FRONT_HERO_HOME_LINE2_TAIL = 'Ξενοδοχεία στην Κύπρο';

	/** @var array<string, string>|null */
	private static $map = null;

	/**
	 * @return array<string, string>
	 */
	private static function load_map(): array {
		return array(
			// Front page (home).
			'home.hero_title_line1'       => 'Έσοδα, Διανομή & ',
			'home.hero_title_line2'       => 'Ψηφιακή Ανάπτυξη για ' . self::FRONT_HERO_HOME_LINE2_TAIL,
			'home.hero_subheadline'       => 'Διαχείριση εσόδων και B2B διανομή για ξενοδοχεία στην Κύπρο. Λειτουργούμε ως εξωτερική εμπορική ομάδα.',
			'home.hero_cta_text'          => 'Κλείστε δωρεάν στρατηγική συνάντηση',
			'home.services_title'         => 'Οι βασικές μας υπηρεσίες',
			'home.services_subtitle'      => 'Πλήρης εμπορική υποστήριξη σε έσοδα, διανομή και ψηφιακά.',
			'home.services_cta_text'      => 'Δείτε τις υπηρεσίες μας',
			'home.svc_1_title'            => 'Διαχείριση απόδοσης & εσόδων',
			'home.svc_1_text'             => 'Δυναμική τιμολόγηση, πρόβλεψη ζήτησης και βελτιστοποίηση RevPAR προσαρμοσμένη στην απόδοση του ξενοδοχείου σας.',
			'home.svc_1_alt'              => 'Διαχείριση απόδοσης & εσόδων',
			'home.svc_2_title'            => 'Online πωλήσεις & B2B διανομή',
			'home.svc_2_text'             => 'Βελτιστοποίηση OTA, μίγμα καναλιών και νέες στρατηγικές B2B συνεργασίες.',
			'home.svc_2_alt'              => 'Online πωλήσεις & B2B διανομή',
			'home.svc_3_title'            => 'E-commerce & ψηφιακό μάρκετινγκ',
			'home.svc_3_text'             => 'Στρατηγική άμεσων κρατήσεων, SEO/SEM, social media και παρακολούθηση απόδοσης.',
			'home.svc_3_alt'              => 'E-commerce & ψηφιακό μάρκετινγκ',
			'home.svc_4_title'            => 'Συμβάσεις & διαπραγματεύσεις (τουριστικοί πράκτορες)',
			'home.svc_4_text'             => 'Υποστήριξη διαπραγμάτευσης και συμβάσεων με τουριστικούς πράκτορες και χονδρεμπόρους.',
			'home.svc_4_alt'              => 'Συμβάσεις & διαπραγματεύσεις',
			'home.why_title'              => 'Γιατί τα ξενοδοχεία επιλέγουν τη 360° Hotelier Consulting',
			'home.why_subtitle'           => 'Τοπική γνώση αγοράς. Εμπειρία στην Κύπρο. Μετρήσιμα αποτελέσματα.',
			'home.why_1_title'            => 'Γνώση της αγοράς Κύπρου',
			'home.why_1_text'             => 'Εποχικότητα, δίκτυα tour operators και ζήτηση αγορών-προέλευσης. Δουλεύουμε αυτή την αγορά δεκαπέντε χρόνια.',
			'home.why_2_title'            => 'Εμπειρία',
			'home.why_2_text'             => '15+ χρόνια σε πωλήσεις ξενοδοχείων, έσοδα, μάρκετινγκ και OTA.',
			'home.why_3_title'            => 'Πλήρης εμπορική υποστήριξη',
			'home.why_3_text'             => 'Καλύπτουμε όλο τον κύκλο εσόδων: συμβάσεις, τιμολόγηση, διανομή και ψηφιακά.',
			'home.why_4_title'            => 'Αξιόπιστες συνεργασίες',
			'home.why_4_text'             => 'Κρατάμε μικρό τον κατάλογο πελατών. Κάθε ξενοδοχείο έχει πλήρη προσοχή.',
			'home.results_title'          => 'Αποτελέσματα για ξενοδοχεία στην Κύπρο & την Ελλάδα',
			'home.results_label_1'        => 'αύξηση online κρατήσεων',
			'home.results_label_2'        => 'βελτίωση RevPAR',
			'home.results_label_3'        => 'Ισχυρότερα χαρτοφυλάκια και καλύτεροι όροι συμβάσεων',
			'home.results_label_4'        => 'Ισχυρότερη ψηφιακή απόδοση',
			'home.results_trust'          => 'Συνεργασία με ξενοδοχεία σε Κύπρο & Ελλάδα.',
			'home.approach_title'         => 'Πώς δουλεύουμε',
			'home.approach_subtitle'      => 'Τέσσερα βήματα, ξεκάθαρα.',
			'home.approach_1_title'       => 'Έλεγχος & εικόνα',
			'home.approach_1_text'        => 'Αναλύουμε την τρέχουσα απόδοση, κανάλια, ιστότοπο, τιμολόγηση και συμβάσεις.',
			'home.approach_2_title'       => 'Στρατηγική & σχεδιασμός',
			'home.approach_2_text'        => 'Χτίζουμε εμπορική στρατηγική γύρω από τους στόχους και τη θέση του ξενοδοχείου σας στην αγορά.',
			'home.approach_3_title'       => 'Υλοποίηση & διαχείριση',
			'home.approach_3_text'        => 'Υποστήριξη σε πωλήσεις, τιμολόγηση, ψηφιακά και συμβάσεις.',
			'home.approach_4_title'       => 'Αξιολόγηση & βελτιστοποίηση',
			'home.approach_4_text'        => 'Μηνιαίες αναφορές, KPI και συνεχείς προσαρμογές.',
			'home.approach_cta_text'      => 'Κλείστε δωρεάν συμβουλευτική',
			'home.feat_title'             => 'Γινόμαστε η εξωτερική εμπορική ομάδα του ξενοδοχείου σας',
			'home.feat_text'              => 'Τιμολόγηση, διανομή, συμβάσεις και ψηφιακό μάρκετινγκ — όλα σε ένα.',
			'home.feat_cta_text'          => 'Κλείστε δωρεάν συμβουλευτική',
			'home.founder_heading'        => 'Γνωρίστε τον ιδρυτή',
			'home.founder_photo_alt'      => 'Γιώργος Πεγιαζής, ιδρυτής της 360 Hotelier Consulting',
			'home.founder_p1'             => 'Ο Γιώργος έχει 15+ χρόνια σε διαχείριση εσόδων, ψηφιακό μάρκετινγκ, online πωλήσεις και συμβάσεις tour operators. Συνεργάζεται με ανεξάρτητα και boutique ξενοδοχεία στην Κύπρο.',
			'home.founder_p2'             => 'Εστίαση: να βοηθήσει τα κυπριακά ξενοδοχεία να κερδίσουν περισσότερα με καλύτερη τιμολόγηση, διανομή και ψηφιακά.',
			'home.founder_pt_1'           => '15+ χρόνια σε πωλήσεις φιλοξενίας & διανομή',
			'home.founder_pt_2'           => 'Πρακτική γνώση της αγοράς ξενοδοχείων Κύπρου',
			'home.founder_pt_3'           => 'Ιστορικό ανάπτυξης RevPAR και άμεσων κρατήσεων',
			'home.founder_pt_4'           => 'Σύμβουλος για boutique, resort και ανεξάρτητα ξενοδοχεία',
			'home.founder_cta_text'       => 'Σχετικά με εμάς',
			'home.founder_profile_cta_text' => 'Προφίλ ιδρυτή',
			'home.contact_band_title'     => 'Αυξήστε τα έσοδα του ξενοδοχείου σας.',
			'home.contact_band_text'      => 'Πείτε μας για την ιδιοκτησία σας. Θα εντοπίσουμε πού χάνετε έσοδα.',
			'home.contact_band_cta'       => 'Κλείστε δωρεάν στρατηγική συνάντηση',

			// About (subset — extend in same class if needed).
			'about.hero_kicker'           => 'Σχετικά με εμάς',
			'about.hero_title'            => 'Η εξωτερική εμπορική ομάδα για ξενοδοχεία στην Κύπρο',
			'about.what_title'            => 'Τι κάνουμε',
			'about.cta_feat_primary'      => 'Επικοινωνία',
			'about.cta_feat_secondary'    => 'Υπηρεσίες',

			// Contact.
			'contact.hero_title'          => 'Επικοινωνία',
			'contact.form_submit'         => 'Αποστολή μηνύματος',

			// Services hub.
			'services.hero_title'         => 'Υπηρεσίες',
			'services.cta_feat_primary'   => 'Επικοινωνία',

			// Portfolio.
			'portfolio.hero_title'        => 'Χαρτοφυλάκιο',

			// Founder page (subset).
			'founder.hero_subtitle'       => 'Ιδρυτής & σύμβουλος φιλοξενίας · 15+ χρόνια σε έσοδα ξενοδοχείων, online πωλήσεις και ψηφιακή στρατηγική.',
			'founder.bio_h2'              => 'Σχετικά με τον Γιώργο',
			'founder.cta_feat_primary'    => 'Επικοινωνία',
		);
	}

	public static function get( string $context, string $field ): ?string {
		if ( null === self::$map ) {
			self::$map = self::load_map();
		}
		$key = $context . '.' . $field;

		return isset( self::$map[ $key ] ) ? self::$map[ $key ] : null;
	}
}
