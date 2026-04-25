<?php
/**
 * Inner page hero section.
 *
 * Pass these via get_template_part( ..., null, array( ... ) ) (WP 5.5+). WordPress
 * load_template() does not extract() the $args array into variables — only
 * $wp_query->query_vars are extracted. This file extracts $args at the top; see
 * template-parts/page/portfolio-section-gallery.php.
 *
 *   H1 is always the current page's WordPress title (get_the_title); do not pass
 *   page_hero_title (ignored for singular pages). Homepage uses section-hero, not this.
 *
 *   page_hero_image   (string) — Background image URL
 *   page_hero_bg_fit  (string) — Optional: pass 'contain' for background-size: contain (default: cover)
 *   page_hero_square  (bool)   — Optional: 1:1 aspect ratio box (founder photo hero)
 *   page_hero_context (string) — Optional: schema context for hero debug HTML comment
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

$hero_queried_id = (int) get_queried_object_id();
if ( $hero_queried_id > 0 && is_singular( 'page' ) ) {
	$page_hero_title = get_the_title( $hero_queried_id );
} else {
	$page_hero_title = isset( $page_hero_title ) ? (string) $page_hero_title : '';
	if ( '' === $page_hero_title && $hero_queried_id > 0 && is_singular() ) {
		$page_hero_title = get_the_title( $hero_queried_id );
	}
	if ( '' === $page_hero_title ) {
		$page_hero_title = __( '360° Hotelier', '360-hotelier' );
	}
}

$page_hero_bg_fit  = isset( $page_hero_bg_fit ) && 'contain' === $page_hero_bg_fit ? 'contain' : 'cover';
$page_hero_class    = 'page-hero' . ( 'contain' === $page_hero_bg_fit ? ' page-hero--bg-contain' : '' );
$page_hero_square   = ! empty( $page_hero_square );
if ( $page_hero_square ) {
	$page_hero_class .= ' page-hero--square';
}
?>
<section class="<?php echo esc_attr( $page_hero_class ); ?>" style="background-image: url('<?php echo esc_url( $page_hero_image ); ?>');">
    <div class="section-overlay section-overlay--strong" aria-hidden="true"></div>
    <div class="site-container page-hero__content">
        <h1 class="page-hero__title"><?php echo esc_html( $page_hero_title ); ?></h1>
    </div>
</section>
<?php
if ( class_exists( 'Hotelier_Hero_Image_Field' ) ) {
	$hotelier_hero_dbg_id  = isset( $page_hero_debug_page_id ) ? (int) $page_hero_debug_page_id : (int) get_queried_object_id();
	$hotelier_hero_dbg_ctx = isset( $page_hero_context ) ? (string) $page_hero_context : '';
	Hotelier_Hero_Image_Field::print_hero_debug_html_comment( $hotelier_hero_dbg_id, $hotelier_hero_dbg_ctx, (string) $page_hero_image );
}
?>
