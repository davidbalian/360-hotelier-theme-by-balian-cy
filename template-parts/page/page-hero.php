<?php
/**
 * Inner page hero section.
 *
 * Pass these via get_template_part( ..., null, array( ... ) ) (WP 5.5+). Parent template
 * variables are not in scope here because the partial loads inside load_template().
 *
 *   page_hero_title    (string) — H1: short document title (e.g. About Us, Contact)
 *   page_hero_tagline  (string) — Optional marketing line below the H1
 *   page_hero_subtitle (string) — Optional supporting paragraph
 *   page_hero_image    (string) — Background image URL
 *   page_hero_bg_fit   (string) — Optional: pass 'contain' for background-size: contain (default: cover)
 *   page_hero_label    (string) — Optional small kicker above the H1
 *
 * Do not use .fade-in here: hero copy sits low in the viewport and scroll observers
 * often never reveal it (opacity stays 0).
 *
 * @package 360-hotelier
 */

if ( ! isset( $page_hero_image ) || '' === $page_hero_image ) {
    $page_hero_image = content_url( '/uploads/2026/03/featured-360-hotelier.webp' );
}

$page_hero_title = isset( $page_hero_title ) ? $page_hero_title : '';
if ( '' === $page_hero_title && is_singular() ) {
    $page_hero_title = get_the_title( get_queried_object_id() );
}
if ( '' === $page_hero_title ) {
    $page_hero_title = __( '360° Hotelier', '360-hotelier' );
}

$page_hero_tagline  = isset( $page_hero_tagline ) ? $page_hero_tagline : '';
$page_hero_subtitle = isset( $page_hero_subtitle ) ? $page_hero_subtitle : '';
$page_hero_label    = isset( $page_hero_label ) ? $page_hero_label : '';
$page_hero_bg_fit   = isset( $page_hero_bg_fit ) && 'contain' === $page_hero_bg_fit ? 'contain' : 'cover';
$page_hero_class    = 'page-hero' . ( 'contain' === $page_hero_bg_fit ? ' page-hero--bg-contain' : '' );
?>
<section class="<?php echo esc_attr( $page_hero_class ); ?>" style="background-image: url('<?php echo esc_url( $page_hero_image ); ?>');">
    <div class="section-overlay section-overlay--strong" aria-hidden="true"></div>
    <div class="site-container page-hero__content">
        <?php if ( '' !== $page_hero_label ) : ?>
            <p class="page-hero__label"><?php echo esc_html( $page_hero_label ); ?></p>
        <?php endif; ?>
        <h1 class="page-hero__title"><?php echo esc_html( $page_hero_title ); ?></h1>
        <?php if ( '' !== $page_hero_tagline ) : ?>
            <p class="page-hero__tagline"><?php echo esc_html( $page_hero_tagline ); ?></p>
        <?php endif; ?>
        <?php if ( '' !== $page_hero_subtitle ) : ?>
            <p class="page-hero__subtitle"><?php echo esc_html( $page_hero_subtitle ); ?></p>
        <?php endif; ?>
    </div>
</section>
