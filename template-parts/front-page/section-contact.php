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
<section class="front-contact">
    <?php Hotelier_Cta_Band_Image::render( $band ); ?>
    <div class="front-contact__overlay section-overlay"></div>
    <div class="site-container front-contact__content">
        <h2 class="front-contact__title fade-in fade-in-delay-0"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'contact_band_title' ) ); ?></h2>
        <p class="front-contact__text fade-in fade-in-delay-1"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'contact_band_text' ) ); ?></p>
        <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( 'contact' ) ); ?>" class="btn btn--primary front-contact__cta fade-in fade-in-delay-2"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'contact_band_cta' ) ); ?></a>
    </div>
</section>
