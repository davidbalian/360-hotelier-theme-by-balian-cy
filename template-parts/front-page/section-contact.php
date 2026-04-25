<?php
/**
 * Front page contact / consultation section.
 *
 * @package 360-hotelier
 */

$hctx  = 'home';
$hpage = (int) get_queried_object_id();
$band  = Hotelier_Page_Content::get_image_url( $hpage, $hctx, 'contact_band_img' );
?>
<section class="front-featured-banner card-border">
    <?php Hotelier_Cta_Band_Image::render( $band ); ?>
    <div class="front-featured-banner__overlay section-overlay"></div>
    <div class="site-container front-featured-banner__content fade-in fade-in-delay-0">
        <h2 class="front-featured-banner__title"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'contact_band_title' ) ); ?></h2>
        <p class="front-featured-banner__text"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'contact_band_text' ) ); ?></p>
        <div class="front-featured-banner__actions">
            <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( 'contact' ) ); ?>" class="btn btn--primary"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'contact_band_cta' ) ); ?></a>
        </div>
    </div>
</section>
