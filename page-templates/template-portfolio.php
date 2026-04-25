<?php
/**
 * Template Name: Portfolio
 *
 * @package 360-hotelier
 */

$page_id = get_the_ID();
$ctx     = 'portfolio';

$page_hero_image = Hotelier_Hero_Image_Field::resolve_url( $page_id, $ctx );

$pendeli_id  = Hotelier_Page_Content::get_attachment_id( $page_id, $ctx, 'pendeli_svg' );
$pendeli_svg = Hotelier_Page_Content::get_svg_inline( $pendeli_id, 'uploads/2026/03/pendeli-resort-hotel-cyprus-logo-white.svg' );

$hotels = array();
for ( $i = 1; $i <= 8; $i++ ) {
	$mode = Hotelier_Page_Content::get_select( $page_id, $ctx, 'hotel_' . $i . '_mode' );
	$logo = array();
	if ( 'pendeli' === $mode ) {
		$logo['type'] = 'pendeli';
		$alt          = Hotelier_Page_Content::get_text( $page_id, $ctx, 'hotel_' . $i . '_alt' );
		$logo['aria'] = $alt !== '' ? $alt : Hotelier_Page_Content::get_text( $page_id, $ctx, 'pendeli_aria' );
	} else {
		$logo['type'] = 'img';
		$logo['src']  = Hotelier_Page_Content::get_image_url( $page_id, $ctx, 'hotel_' . $i . '_logo' );
		$logo['alt']  = Hotelier_Page_Content::get_text( $page_id, $ctx, 'hotel_' . $i . '_alt' );
		$variant      = Hotelier_Page_Content::get_text( $page_id, $ctx, 'hotel_' . $i . '_variant' );
		if ( $variant !== '' ) {
			$logo['variant'] = $variant;
		}
	}
	$hotels[] = array(
		'name'      => Hotelier_Page_Content::get_text( $page_id, $ctx, 'hotel_' . $i . '_name' ),
		'tagline'   => Hotelier_Page_Content::get_text( $page_id, $ctx, 'hotel_' . $i . '_tagline' ),
		'location'  => Hotelier_Page_Content::get_text( $page_id, $ctx, 'hotel_' . $i . '_location' ),
		'url'       => Hotelier_Page_Content::get_text( $page_id, $ctx, 'hotel_' . $i . '_url' ),
		'logo'      => $logo,
		'photo_url' => Hotelier_Page_Content::get_image_url( $page_id, $ctx, 'hotel_' . $i . '_photo' ),
	);
}

$visit_label = Hotelier_Page_Content::get_text( $page_id, $ctx, 'visit_website_text' );

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

<main id="main" class="site-main page-portfolio">

    <section class="page-section page-section--white">
        <div class="site-container">
            <div class="page-about__intro-grid">
                <div class="page-about__intro-text fade-in fade-in-delay-0">
                    <h2 class="page-section__title"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'intro_h2' ) ); ?></h2>
                    <p><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'intro_p1' ) ); ?></p>
                    <p><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'intro_p2' ) ); ?></p>
                </div>
                <div class="page-about__intro-image fade-in fade-in-delay-1" style="background-image: url('<?php echo esc_url( Hotelier_Page_Content::get_image_url( $page_id, $ctx, 'intro_side_img' ) ); ?>');" aria-hidden="true"></div>
            </div>
        </div>
    </section>

    <section class="page-section page-section--gray">
        <div class="site-container">
            <div class="page-section__heading page-section__heading--center fade-in fade-in-delay-0">
                <h2 class="page-section__title"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'partners_title' ) ); ?></h2>
                <p class="page-section__subtitle"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'partners_subtitle' ) ); ?></p>
            </div>
            <div class="page-portfolio__rows">
                <?php foreach ( $hotels as $index => $hotel ) : ?>
                    <?php
					$logo      = $hotel['logo'];
					$logo_mods = array( 'page-portfolio__hotel-logo' );
					if ( ! empty( $logo['variant'] ) ) {
						$logo_mods[] = 'page-portfolio__hotel-logo--' . $logo['variant'];
					}
					if ( isset( $logo['type'] ) && 'pendeli' === $logo['type'] ) {
						$logo_mods[] = 'page-portfolio__hotel-logo--pendeli';
					}
					$logo_class = implode( ' ', $logo_mods );
					$row_class  = 'page-portfolio__row fade-in fade-in-delay-0';
					if ( 1 === ( $index % 2 ) ) {
						$row_class .= ' page-portfolio__row--flip';
					}
					?>
                    <div class="<?php echo esc_attr( $row_class ); ?>">
                        <div class="page-portfolio__hotel-card card-border">
                            <?php if ( isset( $logo['type'] ) && 'pendeli' === $logo['type'] && $pendeli_svg ) : ?>
                                <div class="<?php echo esc_attr( $logo_class ); ?>" role="img" aria-label="<?php echo esc_attr( isset( $logo['aria'] ) ? $logo['aria'] : '' ); ?>">
                                    <?php echo $pendeli_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                                </div>
                            <?php elseif ( isset( $logo['type'] ) && 'img' === $logo['type'] ) : ?>
                                <div class="<?php echo esc_attr( $logo_class ); ?>">
                                    <img src="<?php echo esc_url( $logo['src'] ); ?>" alt="<?php echo esc_attr( isset( $logo['alt'] ) ? $logo['alt'] : '' ); ?>" loading="lazy" />
                                </div>
                            <?php endif; ?>
                            <h3 class="page-portfolio__hotel-name"><?php echo esc_html( $hotel['name'] ); ?></h3>
                            <?php if ( $hotel['tagline'] !== '' ) : ?>
                                <p class="page-portfolio__hotel-tagline"><?php echo esc_html( $hotel['tagline'] ); ?></p>
                            <?php endif; ?>
                            <span class="page-portfolio__hotel-location">
                                <?php Hotelier_Lucide_Icon::render( 'map-pin', 'page-portfolio__location-icon' ); ?>
                                <?php echo esc_html( $hotel['location'] ); ?>
                            </span>
                            <a href="<?php echo esc_url( $hotel['url'] ); ?>" target="_blank" rel="noopener noreferrer" class="btn btn--outline btn--sm page-portfolio__hotel-link"><?php echo esc_html( $visit_label ); ?></a>
                        </div>
                        <?php
						$photo_url = isset( $hotel['photo_url'] ) ? $hotel['photo_url'] : '';
						$photo_alt = $hotel['name'] !== '' ? $hotel['name'] : __( 'Partner hotel', '360-hotelier' );
						?>
                        <div class="page-portfolio__row-media"<?php echo $photo_url === '' ? ' aria-hidden="true"' : ''; ?>>
                            <?php if ( $photo_url !== '' ) : ?>
                                <img src="<?php echo esc_url( $photo_url ); ?>" alt="<?php echo esc_attr( $photo_alt ); ?>" loading="lazy" width="800" height="600" />
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php
    get_template_part(
        'template-parts/page/portfolio-section-gallery',
        null,
        array(
            'page_id' => $page_id,
        )
    );
    ?>

    <?php
    get_template_part(
        'template-parts/page/portfolio-section-testimonials',
        null,
        array(
            'page_id' => $page_id,
        )
    );
    ?>

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
