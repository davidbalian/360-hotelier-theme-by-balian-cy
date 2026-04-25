<?php
/**
 * Template Name: Services
 *
 * @package 360-hotelier
 */

$page_id = get_the_ID();
$ctx     = 'services';

$page_hero_image = Hotelier_Hero_Image_Field::resolve_url( $page_id, $ctx );

$services_offer = array(
	array(
		'title'    => Hotelier_Page_Content::get_text( $page_id, $ctx, 'row_1_title' ),
		'text'     => Hotelier_Page_Content::get_text( $page_id, $ctx, 'row_1_text' ),
		'url_slug' => 'revenue-management',
		'image'    => Hotelier_Page_Content::get_image_url( $page_id, $ctx, 'row_1_img' ),
		'alt'      => Hotelier_Page_Content::get_text( $page_id, $ctx, 'row_1_alt' ),
	),
	array(
		'title'    => Hotelier_Page_Content::get_text( $page_id, $ctx, 'row_2_title' ),
		'text'     => Hotelier_Page_Content::get_text( $page_id, $ctx, 'row_2_text' ),
		'url_slug' => 'online-sales-distribution',
		'image'    => Hotelier_Page_Content::get_image_url( $page_id, $ctx, 'row_2_img' ),
		'alt'      => Hotelier_Page_Content::get_text( $page_id, $ctx, 'row_2_alt' ),
	),
	array(
		'title'    => Hotelier_Page_Content::get_text( $page_id, $ctx, 'row_3_title' ),
		'text'     => Hotelier_Page_Content::get_text( $page_id, $ctx, 'row_3_text' ),
		'url_slug' => 'digital-marketing',
		'image'    => Hotelier_Page_Content::get_image_url( $page_id, $ctx, 'row_3_img' ),
		'alt'      => Hotelier_Page_Content::get_text( $page_id, $ctx, 'row_3_alt' ),
	),
	array(
		'title'    => Hotelier_Page_Content::get_text( $page_id, $ctx, 'row_4_title' ),
		'text'     => Hotelier_Page_Content::get_text( $page_id, $ctx, 'row_4_text' ),
		'url_slug' => 'tour-operator-contracting',
		'image'    => Hotelier_Page_Content::get_image_url( $page_id, $ctx, 'row_4_img' ),
		'alt'      => Hotelier_Page_Content::get_text( $page_id, $ctx, 'row_4_alt' ),
	),
);

$learn_more = Hotelier_Page_Content::get_text( $page_id, $ctx, 'learn_more_text' );

get_header();
get_template_part(
	'template-parts/page/page-hero',
	null,
	array(
		'page_hero_image'   => $page_hero_image,
		'page_hero_context' => $ctx,
	)
);
?>

<main id="main" class="site-main page-services">

    <section id="services" class="page-section page-section--gray">
        <div class="site-container">
            <div class="page-section__heading page-section__heading--center fade-in fade-in-delay-0">
                <h2 class="page-section__title"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'offer_title' ) ); ?></h2>
                <p class="page-section__subtitle"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'offer_subtitle' ) ); ?></p>
            </div>

            <div class="page-services__rows">
                <?php foreach ( $services_offer as $index => $service ) : ?>
                    <?php
					$row_class = 'page-services__row fade-in fade-in-delay-' . min( $index + 1, 10 );
					if ( 1 === ( $index % 2 ) ) {
						$row_class .= ' page-services__row--flip';
					}
					?>
                    <div class="<?php echo esc_attr( $row_class ); ?>">
                        <div class="page-services__offer-card card-border">
                            <h3 class="page-services__offer-title"><?php echo esc_html( $service['title'] ); ?></h3>
                            <p class="page-services__offer-text text-body"><?php echo esc_html( $service['text'] ); ?></p>
                            <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( $service['url_slug'] ) ); ?>" class="btn btn--secondary btn--sm"><?php echo esc_html( $learn_more ); ?></a>
                        </div>
                        <div class="page-services__row-media">
                            <img
                                src="<?php echo esc_url( $service['image'] ); ?>"
                                alt="<?php echo esc_attr( $service['alt'] ); ?>"
                                width="1920"
                                height="1081"
                                loading="lazy"
                                sizes="(max-width: 768px) calc(100vw - 64px), 480px"
                            />
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php
    get_template_part(
        'template-parts/components/section-faq',
        null,
        array(
            'hotelier_section_faq' => array(
                'context' => Hotelier_Faq_Content::CONTEXT_SERVICES,
                'heading' => __( 'Frequently asked questions', '360-hotelier' ),
                'intro'   => __( 'How we support hotels with revenue, OTAs, and commercial strategy.', '360-hotelier' ),
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
                <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( 'contact' ) ); ?>" class="btn btn--primary"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'cta_feat_primary' ) ); ?></a>
            </div>
        </div>
    </section>

</main>

<?php get_footer();
