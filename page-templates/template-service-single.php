<?php
/**
 * Template Name: Service Single
 *
 * For service sub-pages: Revenue Management, Online Sales, Digital Marketing, Tour Operator Contracting.
 *
 * @package 360-hotelier
 */

get_header();

$slug = get_post_field( 'post_name', get_post() );
$content = hotelier_get_service_content( $slug );

if ( ! $content ) {
    get_template_part( 'template-parts/content/content', 'page' );
    get_footer();
    return;
}
?>

<main id="main" class="site-main">
    <div class="site-container page-service-single">

        <article class="page-service-single__content">
            <h1 class="page-service-single__title"><?php echo esc_html( $content['title'] ); ?></h1>
            <p class="page-service-single__intro"><?php echo esc_html( $content['intro'] ); ?></p>

            <h2><?php esc_html_e( 'What we deliver:', '360-hotelier' ); ?></h2>
            <ul class="page-service-single__deliverables">
                <?php foreach ( $content['deliverables'] as $item ) : ?>
                    <li><?php echo esc_html( $item ); ?></li>
                <?php endforeach; ?>
            </ul>

            <p class="page-service-single__cta">
                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'Get in Touch', '360-hotelier' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="btn btn--outline"><?php esc_html_e( 'All Services', '360-hotelier' ); ?></a>
            </p>
        </article>

    </div>
</main>

<?php get_footer();
