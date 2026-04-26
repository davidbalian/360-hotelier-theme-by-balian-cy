<?php
/**
 * Front page services overview section.
 *
 * @package 360-hotelier
 */

$hctx  = 'home';
$hpage = (int) get_queried_object_id();
$services_url = hotelier_get_page_url_by_slug( 'services' );
?>
<section class="front-services-overview card-border">
    <div class="site-container">
        <h2 class="front-section__title fade-in fade-in-delay-0"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'services_title' ) ); ?></h2>
        <p class="front-section__subtitle fade-in fade-in-delay-1"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'services_subtitle' ) ); ?></p>
        <div class="front-services-overview__grid">

            <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
            <div class="front-services-overview__card card-border fade-in fade-in-delay-<?php echo esc_attr( (string) ( $i + 1 ) ); ?>">
                <div class="front-services-overview__card-image">
                    <?php Hotelier_Front_Service_Card_Image::render( $hpage, $hctx, $i ); ?>
                </div>
                <div class="front-services-overview__card-content">
                    <h3 class="front-services-overview__card-title"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'svc_' . $i . '_title' ) ); ?></h3>
                    <p class="front-services-overview__card-text text-body"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'svc_' . $i . '_text' ) ); ?></p>
                </div>
            </div>
            <?php endfor; ?>

        </div>
        <p class="front-services-overview__cta fade-in fade-in-delay-6">
            <a href="<?php echo esc_url( $services_url ); ?>" class="btn btn--primary"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'services_cta_text' ) ); ?></a>
        </p>
    </div>
</section>
