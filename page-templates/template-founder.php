<?php
/**
 * Template Name: Founder
 *
 * @package 360-hotelier
 */

$page_id = get_the_ID();
$ctx     = 'founder';

$page_hero_title    = Hotelier_Page_Content::get_text( $page_id, $ctx, 'hero_title' );
$page_hero_subtitle = Hotelier_Page_Content::get_text( $page_id, $ctx, 'hero_subtitle' );
$page_hero_image    = Hotelier_Page_Content::get_image_url( $page_id, $ctx, 'hero_bg' );

get_header();
get_template_part(
	'template-parts/page/page-hero',
	null,
	array(
		'page_hero_title'    => $page_hero_title,
		'page_hero_subtitle' => $page_hero_subtitle,
		'page_hero_image'    => $page_hero_image,
		'page_hero_bg_fit'   => 'contain',
		'page_hero_square'   => true,
	)
);
?>

<main id="main" class="site-main page-founder">

    <section class="page-founder__bio-section">
        <div class="site-container">
            <div class="page-founder__bio-grid">

                <div class="page-founder__photo-wrap fade-in fade-in-delay-0">
                    <img
                        class="page-founder__photo"
                        src="<?php echo esc_url( Hotelier_Page_Content::get_image_url( $page_id, $ctx, 'bio_photo' ) ); ?>"
                        alt="<?php echo esc_attr( Hotelier_Page_Content::get_text( $page_id, $ctx, 'bio_photo_alt' ) ); ?>"
                        loading="lazy"
                    />
                </div>

                <div class="page-founder__bio-card card-border fade-in fade-in-delay-1">
                    <h2><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'bio_h2' ) ); ?></h2>
                    <p class="page-founder__role"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'bio_role' ) ); ?></p>
                    <p><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'bio_p1' ) ); ?></p>
                    <p><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'bio_p2' ) ); ?></p>
                    <p><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'bio_p3' ) ); ?></p>
                    <div class="page-founder__bio-actions">
                        <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( 'contact' ) ); ?>" class="btn btn--primary"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'bio_cta_primary' ) ); ?></a>
                        <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( 'about-us' ) ); ?>" class="btn btn--outline"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'bio_cta_secondary' ) ); ?></a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="page-founder__timeline">
        <div class="site-container">

            <div class="front-approach__heading fade-in fade-in-delay-0">
                <h2 class="front-section__title"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'tl_title' ) ); ?></h2>
                <p class="front-section__subtitle"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'tl_subtitle' ) ); ?></p>
            </div>

            <div class="front-approach__inner">

                <div class="front-approach__image fade-in fade-in-delay-1">
                    <img src="<?php echo esc_url( Hotelier_Page_Content::get_image_url( $page_id, $ctx, 'tl_image' ) ); ?>" alt="<?php echo esc_attr( Hotelier_Page_Content::get_text( $page_id, $ctx, 'tl_image_alt' ) ); ?>" class="front-approach__img">
                </div>

                <div class="front-approach__content front-approach__card card-border">
                    <div class="front-approach__steps">

                        <?php for ( $i = 1; $i <= 3; $i++ ) : ?>
                        <div class="front-approach__step fade-in fade-in-delay-<?php echo esc_attr( (string) ( $i + 1 ) ); ?>">
                            <span class="front-approach__step-number"><?php echo esc_html( str_pad( (string) $i, 2, '0', STR_PAD_LEFT ) ); ?></span>
                            <div class="front-approach__step-body">
                                <h3 class="front-approach__step-title"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'tl_' . $i . '_title' ) ); ?></h3>
                                <p class="front-approach__step-text text-body"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'tl_' . $i . '_text' ) ); ?></p>
                            </div>
                        </div>
                        <?php if ( $i < 3 ) : ?>
                        <hr class="front-approach__divider">
                        <?php endif; ?>
                        <?php endfor; ?>

                    </div>
                </div>

            </div>
        </div>
    </section>

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
