<?php
/**
 * Template Name: About Us
 *
 * @package 360-hotelier
 */

$page_id = get_the_ID();
$ctx     = 'about';

$page_hero_title    = Hotelier_Page_Content::get_text( $page_id, $ctx, 'hero_title' );
$page_hero_tagline  = Hotelier_Page_Content::get_text( $page_id, $ctx, 'hero_tagline' );
$page_hero_subtitle = Hotelier_Page_Content::get_text( $page_id, $ctx, 'hero_subtitle' );
$page_hero_image    = Hotelier_Page_Content::get_image_url( $page_id, $ctx, 'hero_bg' );

get_header();
get_template_part(
	'template-parts/page/page-hero',
	null,
	array(
		'page_hero_title'    => $page_hero_title,
		'page_hero_tagline'  => $page_hero_tagline,
		'page_hero_subtitle' => $page_hero_subtitle,
		'page_hero_image'    => $page_hero_image,
	)
);
?>

<main id="main" class="site-main page-about">

    <section class="page-section page-section--white">
        <div class="site-container">
            <div class="page-about__intro-grid">
                <div class="page-about__intro-text fade-in fade-in-delay-0">
                    <h2 class="page-section__title"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'intro_h2' ) ); ?></h2>
                    <p><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'intro_p1' ) ); ?></p>
                    <p><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'intro_p2' ) ); ?></p>
                    <p><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'intro_p3' ) ); ?></p>
                </div>
                <div class="page-about__intro-image fade-in fade-in-delay-1" style="background-image: url('<?php echo esc_url( Hotelier_Page_Content::get_image_url( $page_id, $ctx, 'intro_side_img' ) ); ?>');" aria-hidden="true"></div>
            </div>
        </div>
    </section>

    <section class="page-section page-section--gray">
        <div class="site-container">
            <div class="page-section__heading page-section__heading--center fade-in fade-in-delay-0">
                <h2 class="page-section__title"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'what_title' ) ); ?></h2>
                <p class="page-section__subtitle"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'what_subtitle' ) ); ?></p>
            </div>
            <div class="page-about__services-grid">
                <?php
				$what_icons = array( 1 => 'euro', 2 => 'globe', 3 => 'monitor', 4 => 'users' );
				for ( $i = 1; $i <= 4; $i++ ) :
					?>
                <div class="front-why-choose__box card-border fade-in fade-in-delay-<?php echo esc_attr( (string) $i ); ?>">
                    <div class="front-why-choose__box-icon" aria-hidden="true">
						<?php Hotelier_Lucide_Icon::render( $what_icons[ $i ] ); ?>
                    </div>
                    <h3 class="front-why-choose__box-title"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'what_' . $i . '_title' ) ); ?></h3>
                    <p class="front-why-choose__box-text text-body"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'what_' . $i . '_text' ) ); ?></p>
                </div>
				<?php endfor; ?>
				<?php
				$what_banner_id = Hotelier_Page_Content::get_attachment_id( $page_id, $ctx, 'what_banner_img' );
				if ( $what_banner_id > 0 ) :
					$what_banner_alt = Hotelier_Page_Content::get_text( $page_id, $ctx, 'what_banner_alt' );
					if ( '' === $what_banner_alt ) {
						$what_banner_alt = (string) get_post_meta( $what_banner_id, '_wp_attachment_image_alt', true );
					}
					$what_banner_markup = wp_get_attachment_image(
						$what_banner_id,
						'large',
						false,
						array(
							'alt'      => $what_banner_alt,
							'loading'  => 'lazy',
							'decoding' => 'async',
							'class'    => 'page-about__what-banner-img',
						)
					);
					if ( $what_banner_markup !== '' ) :
						?>
                <figure class="page-about__what-banner fade-in fade-in-delay-5">
						<?php echo $what_banner_markup; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </figure>
						<?php
					endif;
				endif;
				?>
            </div>
            <p class="front-services-overview__cta fade-in fade-in-delay-5">
                <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( 'services' ) . '#services' ); ?>" class="btn btn--primary"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'what_cta_text' ) ); ?></a>
            </p>
        </div>
    </section>

    <?php
	$GLOBALS['hotelier_section_founder_hide_about_cta'] = true;
	get_template_part(
		'template-parts/front-page/section',
		'founder',
		array(
			'hide_about_cta'            => true,
			'founder_content_post_id'   => Hotelier_Page_Content::front_page_id(),
		)
	);
	unset( $GLOBALS['hotelier_section_founder_hide_about_cta'] );
	?>

    <section class="front-featured-banner card-border">
        <?php Hotelier_Cta_Band_Image::render( Hotelier_Page_Content::get_image_url( $page_id, $ctx, 'cta_feat_img' ) ); ?>
        <div class="front-featured-banner__overlay section-overlay"></div>
        <div class="site-container front-featured-banner__content fade-in fade-in-delay-0">
            <h2 class="front-featured-banner__title"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'cta_feat_title' ) ); ?></h2>
            <p class="front-featured-banner__text"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'cta_feat_text' ) ); ?></p>
            <div class="front-featured-banner__actions">
                <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( 'contact' ) ); ?>" class="btn btn--primary"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'cta_feat_primary' ) ); ?></a>
                <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( 'services' ) ); ?>" class="btn btn--ghost"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'cta_feat_secondary' ) ); ?></a>
            </div>
        </div>
    </section>

</main>

<?php get_footer();
