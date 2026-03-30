<?php
/**
 * Template Name: Service Single
 *
 * For service sub-pages: Revenue Management, Online Sales, Digital Marketing, Tour Operator Contracting.
 *
 * @package 360-hotelier
 */

get_header();

$post_id = get_the_ID();
$slug    = get_post_field( 'post_name', get_post() );
$content = hotelier_get_service_page_content( $post_id, $slug );

if ( ! $content ) {
	get_template_part( 'template-parts/content/content', 'page' );
	get_footer();
	return;
}

$page_hero_title    = $content['title'];
$page_hero_subtitle = $content['hero_subtitle'];
$page_hero_image    = $content['hero_image_url'];

get_template_part( 'template-parts/page/page-hero' );
?>

<main id="main" class="site-main page-service-single">
    <div class="site-container">
        <div class="page-service-single__body">

            <div class="fade-in fade-in-delay-0">
                <h2 class="page-section__title"><?php echo esc_html( $content['overview_heading'] ); ?></h2>
                <p class="page-service-single__lead"><?php echo esc_html( $content['intro'] ); ?></p>
            </div>

            <div class="page-service-single__deliverables-card card-border fade-in fade-in-delay-1">
                <h2><?php echo esc_html( $content['deliver_heading'] ); ?></h2>
                <ul class="page-service-single__deliverables">
                    <?php foreach ( $content['deliverables'] as $item ) : ?>
                        <li>
                            <?php Hotelier_Lucide_Icon::render( 'check', 'page-service-single__deliverable-icon' ); ?>
                            <span class="page-service-single__deliverable-text"><?php echo esc_html( $item ); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>
    </div>

    <section class="front-featured-banner card-border">
        <?php Hotelier_Cta_Band_Image::render( $content['cta_img'] ); ?>
        <div class="front-featured-banner__overlay section-overlay"></div>
        <div class="site-container front-featured-banner__content fade-in fade-in-delay-0">
            <h2 class="front-featured-banner__title"><?php echo esc_html( $content['cta_title'] ); ?></h2>
            <p class="front-featured-banner__text"><?php echo esc_html( $content['cta_text'] ); ?></p>
            <div class="front-featured-banner__actions">
                <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( 'contact' ) ); ?>" class="btn btn--primary"><?php echo esc_html( $content['cta_primary'] ); ?></a>
                <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( 'services' ) ); ?>" class="btn btn--ghost"><?php echo esc_html( $content['cta_secondary'] ); ?></a>
            </div>
        </div>
    </section>

</main>

<?php get_footer();
