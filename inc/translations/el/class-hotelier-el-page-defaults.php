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
			'home.contact_band_title'     => 'Γινόμαστε η εξωτερική εμπορική ομάδα του ξενοδοχείου σας',
			'home.contact_band_text'      => 'Τιμολόγηση, διανομή, συμβόλαια και ψηφιακό μάρκετινγκ — όλα σε ένα χέρι.',
			'home.contact_band_cta'       => 'Κλείστε δωρεάν συμβουλευτική',

			// About.
			'about.hero_kicker'           => 'Σχετικά με εμάς',
			'about.hero_title'            => 'Η εξωτερική εμπορική ομάδα για ξενοδοχεία στην Κύπρο',
			'about.hero_tagline'          => '',
			'about.hero_subtitle'         => '',
			'about.intro_h2'              => 'Σχετικά με την 360° Hotelier Consulting',
			'about.intro_p1'              => 'Η 360° Hotelier Consulting είναι μια εταιρεία συμβουλευτικών υπηρεσιών για ξενοδοχεία με έδρα την Κύπρο, η οποία παρέχει στρατηγική εμπορική υποστήριξη σε ανεξάρτητα ξενοδοχεία, boutique ξενοδοχεία και τουριστικά θέρετρα σε όλο το νησί.',
			'about.intro_p2'              => 'Εξειδικευόμαστε στο hotel revenue management, τις online πωλήσεις & B2B distribution, το e-commerce, το digital marketing και τη διαχείριση συμβολαίων με tour operators, βοηθώντας τα ξενοδοχεία να αυξήσουν τα έσοδά τους, να βελτιώσουν την κερδοφορία τους και να ενισχύσουν τη θέση τους στην αγορά.',
			'about.intro_p3'              => 'Με πάνω από 15 χρόνια εμπειρίας στον ξενοδοχειακό κλάδο, υποστηρίζουμε τα ξενοδοχεία μέσα από στρατηγικές βασισμένες σε δεδομένα, ψηφιακή τεχνογνωσία και πρακτική εφαρμογή. Διατηρούμε μικρό κατάλογο πελατών ώστε να είμαστε πλήρως αφοσιωμένοι σε κάθε ξενοδοχείο.',
			'about.what_title'            => 'Τι κάνουμε',
			'about.what_subtitle'         => 'Ολοκληρωμένη εμπορική συμβουλευτική προσαρμοσμένη στην αγορά και τους στόχους κάθε ξενοδοχείου.',
			'about.what_1_title'          => 'Yield & Revenue Management',
			'about.what_1_text'           => 'Στρατηγική τιμολόγησης, πρόβλεψη ζήτησης και τμηματοποίηση αγοράς με στόχο τη μεγιστοποίηση του RevPAR και τη βελτίωση της συνολικής απόδοσης εσόδων.',
			'about.what_2_title'          => 'Online Sales & B2B Distribution',
			'about.what_2_text'           => 'Βελτιστοποίηση OTA, στρατηγική διαχείρισης καναλιών πώλησης και ανάπτυξη κερδοφόρων B2B συνεργασιών.',
			'about.what_3_title'          => 'E-Commerce & Digital Marketing',
			'about.what_3_text'           => 'Βελτιστοποίηση απευθείας κρατήσεων, SEO & SEM, στρατηγική social media και ανάλυση ψηφιακής απόδοσης.',
			'about.what_4_title'          => 'Contracting & Διαπραγματεύσεις με Tour Operators',
			'about.what_4_text'           => 'Επαγγελματική εκπροσώπηση και διαπραγμάτευση με tour operators και wholesalers, πάντα με γνώμονα το εμπορικό συμφέρον του ξενοδοχείου.',
			'about.what_cta_text'         => 'Δείτε τις Υπηρεσίες μας',
			'about.cta_feat_title'        => 'Συνεργαστείτε με έναν Σύμβουλο Ξενοδοχείων στην Κύπρο.',
			'about.cta_feat_text'         => 'Η 360° Hotelier Consulting καλύπτει έσοδα, διανομή και ψηφιακά για ξενοδοχεία σε όλη την Κύπρο. Ας μιλήσουμε.',
			'about.cta_feat_primary'      => 'Επικοινωνία',
			'about.cta_feat_secondary'    => 'Υπηρεσίες',

			// Contact.
			'contact.hero_title'          => 'Επικοινωνία',
			'contact.hero_tagline'        => 'Αυξήστε τα Έσοδα & τη Διανομή του Ξενοδοχείου σας.',
			'contact.hero_subtitle'       => 'Πείτε μας για το ξενοδοχείο σας. Θα εντοπίσουμε πού βρίσκεται η ευκαιρία εσόδων.',
			'contact.card_title'          => 'Επικοινωνήστε Μαζί μας',
			'contact.form_title'          => 'Στείλτε μας μήνυμα',
			'contact.form_success'        => 'Ευχαριστούμε — το μήνυμά σας στάλθηκε. Θα επικοινωνήσουμε σύντομα.',
			'contact.form_error'          => 'Κάτι πήγε στραβά ή λείπουν υποχρεωτικά πεδία. Παρακαλώ δοκιμάστε ξανά.',
			'contact.form_hp_label'       => 'Αφήστε κενό',
			'contact.form_name_label'     => 'Όνομα',
			'contact.form_name_ph'        => 'Το πλήρες όνομά σας',
			'contact.form_email_label'    => 'Email',
			'contact.form_subject_label'  => 'Θέμα',
			'contact.form_subject_ph'     => 'π.χ., Συμβουλευτική στρατηγικής εσόδων',
			'contact.form_message_label'  => 'Μήνυμα',
			'contact.form_message_ph'     => 'Πείτε μας για το ξενοδοχείο σας, τους στόχους σας και πώς μπορούμε να βοηθήσουμε…',
			'contact.form_submit'         => 'Αποστολή μηνύματος',
			'contact.cta_feat_title'      => 'Κλείστε μια Δωρεάν Στρατηγική Συνάντηση',
			'contact.cta_feat_text'       => 'Πείτε μας για το ξενοδοχείο σας. Θα σας δείξουμε πού βρίσκεται η ευκαιρία εσόδων — χωρίς κόστος, χωρίς δέσμευση.',
			'contact.cta_feat_primary'    => 'Κλείστε δωρεάν στρατηγική συνάντηση',

			// Services hub.
			'services.hero_title'         => 'Υπηρεσίες',
			'services.hero_subtitle'      => 'Έσοδα, διανομή και ψηφιακή ανάπτυξη για ξενοδοχεία στην Κύπρο. Λειτουργούμε ως εξωτερική εμπορική ομάδα.',
			'services.offer_title'        => 'Οι Υπηρεσίες μας',
			'services.offer_subtitle'     => 'Βοηθάμε τα ξενοδοχεία να αυξήσουν τις απευθείας κρατήσεις, να βελτιστοποιήσουν το μίγμα καναλιών και να διαπραγματευτούν ισχυρότερες συμφωνίες με tour operators & B2B συνεργάτες.',
			'services.row_1_title'        => 'Yield & Revenue Management',
			'services.row_1_text'         => 'Δυναμική τιμολόγηση, πρόβλεψη ζήτησης, segmentation και ανάλυση απόδοσης για μεγιστοποίηση RevPAR και αύξηση εσόδων.',
			'services.row_1_alt'          => 'Yield & Revenue Management',
			'services.row_2_title'        => 'Online Sales & B2B Distribution',
			'services.row_2_text'         => 'Βελτιστοποίηση OTA, B2B συνεργασίες, στρατηγική channel mix και διαχείριση distribution σε παγκόσμιες και περιφερειακές αγορές.',
			'services.row_2_alt'          => 'Online Sales & B2B Distribution',
			'services.row_3_title'        => 'E-Commerce & Digital Marketing',
			'services.row_3_text'         => 'Στρατηγική άμεσων κρατήσεων, καμπάνιες SEO/SEM, διαχείριση social media και παρακολούθηση ψηφιακής απόδοσης.',
			'services.row_3_alt'          => 'E-Commerce & Digital Marketing',
			'services.row_4_title'        => 'Contracting & Διαπραγματεύσεις (Tour Operators)',
			'services.row_4_text'         => 'Πλήρεις υπηρεσίες contracting, benchmarking, υποστήριξη διαπραγματεύσεων και διαχείριση σχέσεων με tour operators & ταξιδιωτικούς συνεργάτες.',
			'services.row_4_alt'          => 'Contracting & Διαπραγματεύσεις',
			'services.learn_more_text'    => 'Μάθετε περισσότερα',
			'services.cta_feat_title'     => 'Αυξήστε τα έσοδα του ξενοδοχείου σας.',
			'services.cta_feat_text'      => 'Θα χτίσουμε εμπορική στρατηγική γύρω από το ξενοδοχείο σας, την αγορά και τους στόχους σας.',
			'services.cta_feat_primary'   => 'Επικοινωνία',

			// Portfolio.
			'portfolio.hero_title'        => 'Χαρτοφυλάκιο',
			'portfolio.hero_subtitle'     => 'Boutique, ανεξάρτητα και resort ξενοδοχεία σε Κύπρο και εξωτερικό, με μετρήσιμα αποτελέσματα.',
			'portfolio.intro_h2'          => 'Ξενοδοχεία που Συνεργαζόμαστε',
			'portfolio.intro_p1'          => 'Στην 360° Hotelier Consulting συνεργαζόμαστε με ανεξάρτητα ξενοδοχεία, boutique μονάδες και τουριστικά θέρετρα στην Κύπρο, παρέχοντας υπηρεσίες revenue management, online πωλήσεων & B2B distribution, digital marketing και διαπραγμάτευσης συμβολαίων με tour operators.',
			'portfolio.intro_p2'          => 'Κάθε συνεργασία είναι προσαρμοσμένη στη θέση του ξενοδοχείου στην αγορά, την εποχικότητα και τους εμπορικούς του στόχους.',
			'portfolio.partners_title'    => 'Ξενοδοχεία & Συνεργάτες',
			'portfolio.partners_subtitle' => 'Ανεξάρτητα, boutique και resort ξενοδοχεία που υποστηρίζουμε με στρατηγική εσόδων, διανομής και digital.',
			'portfolio.gallery_title'     => 'Μέσα στα Ξενοδοχεία μας',
			'portfolio.gallery_subtitle'  => 'Μια ματιά στα δωμάτια, τις σουίτες και τους χώρους των ξενοδοχείων με τα οποία συνεργαζόμαστε σε Κύπρο και Ελλάδα.',
			'portfolio.hotel_1_tagline'   => 'Η πιο πολυτελής παραλιακή ξενοδοχειακή μονάδα της Κύπρου με εκπληκτική θέα στη θάλασσα.',
			'portfolio.hotel_2_tagline'   => 'Νεόδμητο boutique πολυτελές ξενοδοχείο στην Πάφο με κομψό design.',
			'portfolio.hotel_3_tagline'   => 'Αποκλειστικές παραλιακές κατοικίες στην Πάφο με πανοραμική θέα στη θάλασσα.',
			'portfolio.hotel_4_tagline'   => 'Ξενοδοχείο στη ζωντανή τουριστική περιοχή της Λεμεσού με σύγχρονες ανέσεις.',
			'portfolio.hotel_5_tagline'   => 'Εμβληματικό ιστορικό ορεινό θέρετρο στις Πλάτρες, περιτριγυρισμένο από μοναδική φυσική ομορφιά.',
			'portfolio.hotel_6_tagline'   => 'Γοητευτικό ιστορικό boutique ξενοδοχείο στις Πλάτρες με ζεστή κομψότητα.',
			'portfolio.hotel_7_tagline'   => 'Προσιτό ξενοδοχείο κοντά στα κορυφαία αξιοθέατα και τη νυχτερινή ζωή της Αγίας Νάπας.',
			'portfolio.hotel_8_tagline'   => 'Κομψές σουίτες στο κέντρο της Αθήνας, πρωτεύουσας της Ελλάδας, ιδανικές για αστικές διαμονές.',
			'portfolio.testimonials_title'    => 'Τι λένε οι συνεργάτες μας',
			'portfolio.testimonials_subtitle' => 'Σχόλια ξενοδοχειακών στελεχών για έσοδα, διανομή και τη συνεργασία με την ομάδα μας.',
			'portfolio.testimonials_closing'  => 'Η 360 Hotelier Consulting συνεργάζεται με boutique ξενοδοχεία, ανεξάρτητα ξενοδοχεία και συνεργάτες φιλοξενίας σε Κύπρο και Ελλάδα, βοηθώντας τα να αυξήσουν την πληρότητα, να βελτιστοποιήσουν την απόδοση στα OTAs και να ενισχύσουν τη στρατηγική εσόδων.',
			'portfolio.testimonial_1_quote'   => 'Η συνεργασία μας με την 360 Hotelier Consulting ήταν επαγγελματική και παραγωγική. Η άμεση εμπλοκή στη στρατηγική εσόδων, το contracting και τον εμπορικό σχεδιασμό μάς προσέφερε πολύτιμες γνώσεις και πρακτικές λύσεις που στήριξαν το θέρετρό μας. Ισχυρή γνώση του κλάδου, στρατηγική σκέψη και στενή συνεργασία καθιστούν αυτή τη συνεργασία ιδιαίτερα αποτελεσματική.',
			'portfolio.testimonial_1_name'    => 'Παναγιώτης Μάρκου',
			'portfolio.testimonial_1_role'    => 'Διευθυντής Πωλήσεων & Μάρκετινγκ · Cap St. Georges Hotel & Resort · Πάφος, Κύπρος',
			'portfolio.testimonial_2_quote'   => 'Η προ-λειτουργική υποστήριξη από την 360 Hotelier Consulting ήταν καθοριστική για την ανάπτυξη του ξενοδοχείου μας. Ο Γιώργος μάς στήριξε ουσιαστικά στην οικοδόμηση της εμπορικής μας στρατηγικής και της στρατηγικής εσόδων. Οι κατευθύνσεις σε τιμολόγηση, δομή OTA και θέση στην αγορά μάς βοήθησαν να διαμορφώσουμε μια σαφή και ανταγωνιστική προσέγγιση. Η συνεργασία είναι επαγγελματική, διαφανής και εστιασμένη σε μακροπρόθεσμα αποτελέσματα.',
			'portfolio.testimonial_2_name'    => 'Μάριος Βασιλείου',
			'portfolio.testimonial_2_role'    => 'Γενικός Διευθυντής · Serbellas Boutique Hotel · Πάφος, Κύπρος',
			'portfolio.testimonial_3_quote'   => 'Η 360 Hotelier Consulting έδειξε πρακτική προσέγγιση στην υποστήριξη της εμπορικής μας στρατηγικής και της στρατηγικής εσόδων. Η συνεργασία ήταν εστιασμένη, δομημένη και προσανατολισμένη σε αποτέλεσμα, με ισχυρή προσοχή στην απόδοση OTA, τη στρατηγική τιμολόγησης και τη θέση στην αγορά. Ένας αξιόπιστος συνεργάτης που κατανοεί τις ανάγκες της αγοράς και εργάζεται ενεργά δίπλα στην ομάδα για τη βελτίωση της απόδοσης.',
			'portfolio.testimonial_3_name'    => 'Σταύρος Γ. Τσάνος',
			'portfolio.testimonial_3_role'    => 'Διευθυντής · George Tsanos Hotels Group (TSANotel, Pendeli Resort & Petit Palais Platres Boutique Hotel) · Λεμεσός, Κύπρος',
			'portfolio.testimonial_4_quote'   => 'Η συνεργασία με την 360 Hotelier Consulting βελτίωσε σημαντικά την online παρουσία του ξενοδοχείου μας και τη στρατηγική τιμολόγησης. Η δομημένη προσέγγιση στη διαχείριση OTA και στον σχεδιασμό εσόδων αύξησε την ορατότητά μας και ενίσχυσε τη θέση μας στην αγορά. Μέσα στον πρώτο χρόνο συνεργασίας, τα έσοδα από OTAs και απευθείας κρατήσεις αυξήθηκαν πάνω από 45%.',
			'portfolio.testimonial_4_name'    => 'Ζαχαρίας Παπαδόπουλος',
			'portfolio.testimonial_4_role'    => 'Γενικός Διευθυντής · Napa Jay Hotel · Αγία Νάπα, Κύπρος',
			'portfolio.testimonial_5_quote'   => 'Η συνεργασία με τον Γιώργο ήταν απαραίτητη λόγω της εκτεταμένης γνώσης του για την αγορά της Αθήνας μέσω της εμπειρίας του στη Booking.com, που έφερε πολύτιμες πληροφορίες και σαφή στρατηγική κατεύθυνση. Ένας αξιόπιστος και επαγγελματίας συνεργάτης για την ανάπτυξη της επιχείρησης.',
			'portfolio.testimonial_5_name'    => 'Μιράντα Γιάτρου-Γραμματικοπούλου',
			'portfolio.testimonial_5_role'    => 'Διευθύνουσα Σύμβουλος · Όμιλος Γιάτρου · Chic Centre Suites Athens · Αθήνα, Ελλάδα',
			'portfolio.testimonial_6_quote'   => 'Ο Γιώργος φέρνει βαθιά γνώση της κυπριακής αγοράς φιλοξενίας και ισχυρή εμπειρία στη διαχείριση εσόδων και στη στρατηγική OTA. Η συνεργασία μάς βοήθησε να κατανοήσουμε καλύτερα τη δομή τιμολόγησής μας και να βελτιώσουμε τις εμπορικές μας αποφάσεις. Ένας πολύτιμος συνεργάτης για κάθε ξενοδοχείο που θέλει να αναπτυχθεί.',
			'portfolio.testimonial_6_name'    => 'Κωνσταντίνος Δρουσιώτης',
			'portfolio.testimonial_6_role'    => 'Γενικός Διευθυντής · Alinea Hospitality Group · Λεμεσός, Κύπρος',
			'portfolio.testimonial_7_quote'   => 'Υψηλός επαγγελματισμός, δομημένη προσέγγιση και πολυετής εμπειρία στο contracting ξενοδοχείων και στην εμπορική στρατηγική. Ο Γιώργος δείχνει ισχυρή γνώση του κλάδου και εξαιρετική επικοινωνία, με αποτέλεσμα η συνεργασία να είναι ομαλή και αποτελεσματική. Ένας αξιόπιστος συνεργάτης στον κλάδο της φιλοξενίας.',
			'portfolio.testimonial_7_name'    => 'Κρατίνος Σωκράτους',
			'portfolio.testimonial_7_role'    => 'Γενικός Διευθυντής · Capo Bay Hotel · Πρωταράς, Κύπρος',
			'portfolio.testimonial_8_quote'   => 'Ένας επαγγελματίας ξενοδοχείων με μεγάλη εμπειρία και βαθιά κατανόηση της διαχείρισης εσόδων, της απόδοσης OTA και της δυναμικής των αγορών στην Κύπρο και την Ελλάδα. Η στρατηγική προσέγγιση και το εμπορικό μυαλό του Γιώργου καθιστούν την 360 Hotelier Consulting ισχυρό συνεργάτη για ξενοδοχεία που στοχεύουν στη βελτίωση της πληρότητας και των εσόδων.',
			'portfolio.testimonial_8_name'    => 'Όμηρος Ομήρου',
			'portfolio.testimonial_8_role'    => 'Διευθυντής Ανάπτυξης Επιχειρήσεων · STADEMOS HOTELS LTD · Λεμεσός, Κύπρος',
			'portfolio.visit_website_text' => 'Επίσκεψη ιστοσελίδας',
			'portfolio.pendeli_aria'      => 'Pendeli Resort Hotel Κύπρος',
			'portfolio.cta_feat_title'    => 'Προσθέστε το Ξενοδοχείο σας στο Portfolio μας.',
			'portfolio.cta_feat_text'     => 'Κρατάμε μικρό τον κατάλογο πελατών. Κάθε ξενοδοχείο έχει άμεση πρόσβαση στον Γιώργο και πλήρη εμπορική υποστήριξη.',
			'portfolio.cta_feat_primary'  => 'Κλείστε δωρεάν στρατηγική συνάντηση',

			// Founder page.
			'founder.hero_subtitle'       => 'Ιδρυτής & σύμβουλος φιλοξενίας · 15+ χρόνια σε έσοδα ξενοδοχείων, online πωλήσεις και ψηφιακή στρατηγική.',
			'founder.bio_h2'              => 'Σχετικά με τον Γιώργο',
			'founder.bio_photo_alt'       => 'Γιώργος Πεγιαζής, ιδρυτής της 360 Hotelier Consulting',
			'founder.bio_role'            => 'Ιδρυτής & Σύμβουλος Ξενοδοχείων — 360° Hotelier Consulting',
			'founder.bio_p1'              => 'Ο Γιώργος Πεγιάζης είναι ο ιδρυτής της 360° Hotelier Consulting, μιας εταιρείας συμβουλευτικών υπηρεσιών πωλήσεων και ηλεκτρονικού εμπορίου για ξενοδοχεία με έδρα την Κύπρο. Με περισσότερα από δεκαπέντε χρόνια εμπειρίας στις πωλήσεις ξενοδοχείων, τη σύναψη συμβολαίων και τη διαχείριση διαδικτυακής διανομής, ειδικεύεται στο να βοηθά ξενοδοχεία να μεγιστοποιούν την απόδοση και την κερδοφορία τους.',
			'founder.bio_p2'              => 'Μετά τις μεταπτυχιακές σπουδές στη Διοίκηση Επιχειρήσεων (Marketing) στο Les Roches International School of Hotel Management στην Ελβετία, απέκτησε εκτεταμένη εμπειρία σε διάφορους τομείς της ξενοδοχειακής βιομηχανίας, τόσο στην Κύπρο όσο και στο εξωτερικό.',
			'founder.bio_p3'              => 'Η 360° Hotelier Consulting εστιάζει στη βελτιστοποίηση εσόδων, το e-commerce και το digital marketing για ανεξάρτητα και boutique ξενοδοχεία. Βοηθά τους ξενοδόχους να βελτιώσουν το channel mix, να αυξήσουν τις απευθείας κρατήσεις και να ενισχύσουν το RevPAR.',
			'founder.bio_cta_primary'     => 'Επικοινωνία',
			'founder.bio_cta_secondary'   => 'Σχετικά με εμάς',
			'founder.tl_title'            => 'Επαγγελματική Εμπειρία',
			'founder.tl_subtitle'         => 'Προηγούμενη εμπειρία',
			'founder.tl_image_alt'        => 'Σύμβουλος ξενοδοχείων στη δουλειά',
			'founder.tl_1_title'          => 'Booking.com · 2013–2021',
			'founder.tl_1_text'           => 'Στρατηγική πωλήσεων, διαχείριση διανομής και ανάπτυξη συνεργατών. Υλοποίηση workshops και εκπροσώπηση της Booking.com σε διεθνή συνέδρια και εκδηλώσεις.',
			'founder.tl_2_title'          => 'Tour Operators & Wholesalers · 2022–2024',
			'founder.tl_2_text'           => 'Διαχείριση συμβολαίων, τακτικές προώθησης και στρατηγική τιμολόγησης για DERTOUR Group, EasyJet Holidays, Sunweb Group, Love Holidays, ITAKA, Grecos Holidays και άλλους.',
			'founder.tl_3_title'          => '360° Hotelier Consulting · 2024–Σήμερα',
			'founder.tl_3_text'           => 'Εξωτερικός σύμβουλος e-commerce και pre-opening για boutique, μεσαίας και ανώτερης κατηγορίας ξενοδοχεία στην Κύπρο και το εξωτερικό. Πλήρης εμπορική υποστήριξη από έσοδα έως digital.',
			'founder.cta_feat_title'      => 'Συνεργαστείτε με τον Γιώργο',
			'founder.cta_feat_text'       => 'Αυξήστε τα έσοδα και τη διανομή του ξενοδοχείου σας. Επικοινωνήστε σήμερα.',
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
