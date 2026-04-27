<?php
/**
 * Template Name: Founder
 *
 * @package 360-hotelier
 */

$page_id = get_the_ID();
$ctx     = 'founder';

$page_hero_image = Hotelier_Hero_Image_Field::resolve_url( $page_id, $ctx );

get_header();
get_template_part(
	'template-parts/page/page-hero',
	null,
	array(
		'page_hero_image'   => $page_hero_image,
		'page_hero_bg_fit'  => 'contain',
		'page_hero_context' => $ctx,
	)
);
?>

<main id="main" class="site-main page-founder">

    <section class="page-founder__bio-section">
        <div class="site-container">
            <div class="page-founder__bio-grid">

                <div class="page-founder__photo-wrap">
                    <div class="page-founder__photo-frame fade-in fade-in-delay-0">
                        <img
                            class="page-founder__photo"
                            src="<?php echo esc_url( Hotelier_Page_Content::get_image_url( $page_id, $ctx, 'bio_photo' ) ); ?>"
                            alt="<?php echo esc_attr( Hotelier_Page_Content::get_text( $page_id, $ctx, 'bio_photo_alt' ) ); ?>"
                            loading="lazy"
                        />
                    </div>
                </div>

                <div class="page-founder__bio-card card-border fade-in fade-in-delay-1">
                    <h2><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'bio_h2' ) ); ?></h2>
                    <p class="page-founder__role"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'bio_role' ) ); ?></p>
                    <p><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'bio_p1' ) ); ?></p>
                    <p><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'bio_p2' ) ); ?></p>
                    <p><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'bio_p3' ) ); ?></p>

                    <div class="page-founder__experience">
                        <p class="page-founder__experience-lead text-body"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'tl_subtitle' ) ); ?></p>
                        <div class="page-founder__experience-items">
                            <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
                            <div class="page-founder__experience-item">
                                <h3 class="page-founder__experience-heading"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'tl_' . $i . '_title' ) ); ?></h3>
                                <p class="page-founder__experience-body text-body"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'tl_' . $i . '_text' ) ); ?></p>
                            </div>
                            <?php if ( $i < 3 ) : ?>
                            <hr class="page-founder__experience-divider" />
                            <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <?php Hotelier_Founder_Card_Contact::render(); ?>

                    <div class="page-founder__bio-actions">
                        <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( 'contact' ) ); ?>" class="btn btn--primary"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'bio_cta_primary' ) ); ?></a>
                        <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( 'about' ) ); ?>" class="btn btn--outline"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'bio_cta_secondary' ) ); ?></a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="front-featured-banner card-border">
        <?php Hotelier_Cta_Band_Image::render( Hotelier_Cta_Feat_Image_Field::resolve_url( $page_id, $ctx ) ); ?>
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
