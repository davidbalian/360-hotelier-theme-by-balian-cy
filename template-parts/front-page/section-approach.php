<?php
/**
 * Front page "How We Work" section.
 *
 * @package 360-hotelier
 */

$hctx  = 'home';
$hpage = (int) get_queried_object_id();
?>
<section class="front-approach">
    <div class="site-container">

        <div class="front-approach__heading fade-in fade-in-delay-0">
            <h2 class="front-section__title"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'approach_title' ) ); ?></h2>
            <p class="front-section__subtitle"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'approach_subtitle' ) ); ?></p>
        </div>

        <div class="front-approach__bento">

            <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
            <?php
            $approach_step_img = Hotelier_Page_Content::get_image_url( $hpage, $hctx, 'approach_' . $i . '_img' );
            ?>
            <div class="front-approach__bento-card card-border fade-in fade-in-delay-<?php echo esc_attr( (string) $i ); ?>">
                <?php if ( $approach_step_img !== '' ) : ?>
                <div class="front-approach__bento-card-thumb">
                    <img
                        src="<?php echo esc_url( $approach_step_img ); ?>"
                        alt="<?php echo esc_attr( Hotelier_Page_Content::get_text( $hpage, $hctx, 'approach_' . $i . '_img_alt' ) ); ?>"
                        loading="lazy"
                        decoding="async"
                        sizes="(max-width: 768px) calc(100vw - 64px), (max-width: 1200px) 45vw, 560px"
                    />
                </div>
                <?php endif; ?>
                <span class="front-approach__step-number"><?php echo esc_html( str_pad( (string) $i, 2, '0', STR_PAD_LEFT ) ); ?></span>
                <h3 class="front-approach__step-title"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'approach_' . $i . '_title' ) ); ?></h3>
                <p class="front-approach__step-text text-body"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'approach_' . $i . '_text' ) ); ?></p>
            </div>
            <?php endfor; ?>

        </div>

        <div class="front-approach__bento-cta fade-in fade-in-delay-5">
            <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( 'contact' ) ); ?>" class="btn btn--primary"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'approach_cta_text' ) ); ?></a>
        </div>

    </div>
</section>
