<?php
/**
 * Template Name: Contact
 *
 * @package 360-hotelier
 */

$page_id = get_the_ID();
$ctx     = 'contact';
$opt     = Hotelier_Site_Content_Options::get();

$page_hero_title    = Hotelier_Page_Content::get_text( $page_id, $ctx, 'hero_title' );
$page_hero_tagline  = Hotelier_Page_Content::get_text( $page_id, $ctx, 'hero_tagline' );
$page_hero_subtitle = Hotelier_Page_Content::get_text( $page_id, $ctx, 'hero_subtitle' );
$page_hero_image    = Hotelier_Hero_Image_Field::resolve_url( $page_id, $ctx );

$contact_street_address  = $opt['contact_address'];
$contact_map_place_query = $opt['contact_map_query'];
$contact_map_embed_url   = 'https://maps.google.com/maps?q=' . rawurlencode( $contact_map_place_query ) . '&z=16&ie=UTF8&iwloc=&output=embed';
$contact_map_iframe_title = sprintf(
	/* translators: %s: Business name / place searched on the map */
	__( 'Map: %s', '360-hotelier' ),
	$contact_map_place_query
);

$tel_href = $opt['contact_phone_href'];
$tel_href = preg_replace( '/\s+/', '', $tel_href );
if ( $tel_href !== '' && strpos( $tel_href, 'tel:' ) !== 0 ) {
	$tel_href = 'tel:' . $tel_href;
}

get_header();
get_template_part(
	'template-parts/page/page-hero',
	null,
	array(
		'page_hero_title'    => $page_hero_title,
		'page_hero_tagline'  => $page_hero_tagline,
		'page_hero_subtitle' => $page_hero_subtitle,
		'page_hero_image'    => $page_hero_image,
		'page_hero_context'  => $ctx,
	)
);
?>

<main id="main" class="site-main page-contact">

    <section class="page-contact__section">
        <div class="site-container">
            <div class="page-contact__grid">

                <div class="page-contact__card card-border fade-in fade-in-delay-0">
                    <h2 class="page-contact__card-title"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'card_title' ) ); ?></h2>

                    <div class="page-contact__detail">
                        <?php Hotelier_Lucide_Icon::render( 'phone', 'page-contact__detail-icon' ); ?>
                        <div class="page-contact__detail-text">
                            <strong><?php echo esc_html( $opt['label_phone'] ); ?></strong>
                            <a href="<?php echo esc_url( $tel_href ); ?>"><?php echo esc_html( $opt['contact_phone_display'] ); ?></a>
                        </div>
                    </div>

                    <div class="page-contact__detail">
                        <?php Hotelier_Lucide_Icon::render( 'mail', 'page-contact__detail-icon' ); ?>
                        <div class="page-contact__detail-text">
                            <strong><?php echo esc_html( $opt['label_email'] ); ?></strong>
                            <a href="<?php echo esc_url( 'mailto:' . antispambot( $opt['contact_email'] ) ); ?>"><?php echo esc_html( $opt['contact_email'] ); ?></a>
                        </div>
                    </div>

                    <div class="page-contact__detail">
                        <?php Hotelier_Lucide_Icon::render( 'map-pin', 'page-contact__detail-icon' ); ?>
                        <div class="page-contact__detail-text">
                            <strong><?php echo esc_html( $opt['label_address'] ); ?></strong>
                            <?php echo esc_html( $contact_street_address ); ?>
                        </div>
                    </div>

                    <div class="page-contact__map">
                        <iframe
                            class="page-contact__map-frame"
                            title="<?php echo esc_attr( $contact_map_iframe_title ); ?>"
                            src="<?php echo esc_url( $contact_map_embed_url ); ?>"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            allowfullscreen
                        ></iframe>
                    </div>
                </div>

                <?php get_template_part( 'template-parts/page/contact-form' ); ?>

            </div>
        </div>
    </section>

    <?php
    get_template_part(
        'template-parts/components/section-faq',
        null,
        array(
            'hotelier_section_faq' => array(
                'context' => Hotelier_Faq_Content::CONTEXT_CONTACT,
                'heading' => __( 'Frequently asked questions', '360-hotelier' ),
                'intro'   => __( 'Common questions before you reach out.', '360-hotelier' ),
            ),
        )
    );
    ?>

    <section class="front-featured-banner card-border">
        <?php Hotelier_Cta_Band_Image::render( Hotelier_Page_Content::get_image_url( $page_id, $ctx, 'cta_feat_img' ) ); ?>
        <div class="front-featured-banner__overlay section-overlay"></div>
        <div class="site-container front-featured-banner__content fade-in fade-in-delay-0">
            <h2 class="front-featured-banner__title"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'cta_feat_title' ) ); ?></h2>
            <p class="front-featured-banner__text"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'cta_feat_text' ) ); ?></p>
            <div class="front-featured-banner__actions">
                <a href="#page-contact-form" class="btn btn--primary"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'cta_feat_primary' ) ); ?></a>
            </div>
        </div>
    </section>

</main>

<?php get_footer();
