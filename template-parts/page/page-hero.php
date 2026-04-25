<?php
/**
 * Inner page hero section.
 *
 * Pass these via get_template_part( ..., null, array( ... ) ) (WP 5.5+). WordPress
 * load_template() does not extract() the $args array into variables — only
 * $wp_query->query_vars are extracted. This file extracts $args at the top; see
 * template-parts/page/portfolio-section-gallery.php.
 *
 *   page_hero_title    (string) — H1: short document title (e.g. About Us, Contact)
 *   page_hero_tagline  (string) — Optional marketing line below the H1
 *   page_hero_subtitle (string) — Optional supporting paragraph
 *   page_hero_image    (string) — Background image URL
 *   page_hero_bg_fit   (string) — Optional: pass 'contain' for background-size: contain (default: cover)
 *   page_hero_square   (bool)   — Optional: 1:1 aspect ratio box (founder photo hero)
 *   page_hero_label    (string) — Optional small kicker above the H1
 *   page_hero_context  (string) — Optional schema context for hero debug (e.g. about, contact); helps the HTML comment.
 *
 * Do not use .fade-in here: hero copy sits low in the viewport and scroll observers
 * often never reveal it (opacity stays 0).
 *
 * @package 360-hotelier
 */

if ( isset( $args ) && is_array( $args ) && $args !== array() ) {
	// phpcs:ignore WordPress.PHP.DontExtract.extract_extract
	extract( $args, EXTR_OVERWRITE );
}

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
$page_hero_square   = ! empty( $page_hero_square );
if ( $page_hero_square ) {
	$page_hero_class .= ' page-hero--square';
}
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
<?php
if ( class_exists( 'Hotelier_Hero_Image_Field' ) ) {
	$hotelier_hero_dbg_id  = isset( $page_hero_debug_page_id ) ? (int) $page_hero_debug_page_id : (int) get_queried_object_id();
	$hotelier_hero_dbg_ctx = isset( $page_hero_context ) ? (string) $page_hero_context : '';
	Hotelier_Hero_Image_Field::print_hero_debug_html_comment( $hotelier_hero_dbg_id, $hotelier_hero_dbg_ctx, (string) $page_hero_image );
}
?>
