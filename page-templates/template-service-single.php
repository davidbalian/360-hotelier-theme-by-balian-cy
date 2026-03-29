<?php
/**
 * Template Name: Service Single
 *
 * For service sub-pages: Revenue Management, Online Sales, Digital Marketing, Tour Operator Contracting.
 *
 * @package 360-hotelier
 */

get_header();

$slug    = get_post_field( 'post_name', get_post() );
$content = hotelier_get_service_content( $slug );

if ( ! $content ) {
    get_template_part( 'template-parts/content/content', 'page' );
    get_footer();
    return;
}

// Split intro into two sentences for hero subtitle vs body use.
$intro_sentences = explode( '. ', $content['intro'], 2 );
$hero_subtitle   = isset( $intro_sentences[0] ) ? $intro_sentences[0] . '.' : '';

$page_hero_title    = $content['title'];
$page_hero_subtitle = $hero_subtitle;
$page_hero_image    = content_url( '/uploads/2026/03/featured-360-hotelier.webp' );

get_template_part( 'template-parts/page/page-hero' );
?>

<main id="main" class="site-main page-service-single">
    <div class="site-container">
        <div class="page-service-single__body">

            <!-- Intro / lead text -->
            <div class="fade-in fade-in-delay-0">
                <h2 class="page-section__title"><?php esc_html_e( 'Overview', '360-hotelier' ); ?></h2>
                <p class="page-service-single__lead"><?php echo esc_html( $content['intro'] ); ?></p>
            </div>

            <!-- Deliverables card -->
            <div class="page-service-single__deliverables-card card-border fade-in fade-in-delay-1">
                <h2><?php esc_html_e( 'What We Deliver', '360-hotelier' ); ?></h2>
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

    <!-- CTA Banner -->
    <section class="front-featured-banner card-border" style="background-image: url('<?php echo esc_url( content_url( '/uploads/2026/03/featured-360-hotelier.webp' ) ); ?>');">
        <div class="front-featured-banner__overlay section-overlay"></div>
        <div class="site-container front-featured-banner__content fade-in fade-in-delay-0">
            <h2 class="front-featured-banner__title text-4xl"><?php esc_html_e( "Let's Build Your Hotel's Commercial Strategy", '360-hotelier' ); ?></h2>
            <p class="front-featured-banner__text"><?php esc_html_e( "Book a free strategy session and let's discuss how we can help your hotel grow.", '360-hotelier' ); ?></p>
            <div class="front-featured-banner__actions">
                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'Get in Touch', '360-hotelier' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="btn btn--ghost"><?php esc_html_e( 'All Services', '360-hotelier' ); ?></a>
            </div>
        </div>
    </section>

</main>

<?php get_footer();
