<?php
/**
 * Front page featured banner section.
 *
 * @package 360-hotelier
 */

$hctx  = 'home';
$hpage = (int) get_queried_object_id();
$feat  = Hotelier_Page_Content::get_image_url( $hpage, $hctx, 'feat_img' );
?>
<section class="front-featured-banner card-border">
    <?php Hotelier_Cta_Band_Image::render( $feat ); ?>
    <div class="front-featured-banner__overlay section-overlay"></div>
    <div class="site-container front-featured-banner__content fade-in fade-in-delay-0">
        <h2 class="front-featured-banner__title"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'feat_title' ) ); ?></h2>
        <p class="front-featured-banner__text"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'feat_text' ) ); ?></p>
        <div class="front-featured-banner__actions">
            <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( 'contact' ) ); ?>" class="btn btn--primary"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'feat_cta_text' ) ); ?></a>
        </div>
    </div>
</section>
