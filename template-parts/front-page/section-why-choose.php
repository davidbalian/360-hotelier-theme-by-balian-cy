<?php
/**
 * Front page "Why Choose Us" section.
 *
 * @package 360-hotelier
 */

$hctx  = 'home';
$hpage = (int) get_queried_object_id();
$side  = Hotelier_Page_Content::get_image_url( $hpage, $hctx, 'why_side_img' );
?>
<section class="front-why-choose">
    <div class="site-container">
        <h2 class="front-section__title fade-in fade-in-delay-0"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'why_title' ) ); ?></h2>
        <p class="front-section__subtitle fade-in fade-in-delay-1"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'why_subtitle' ) ); ?></p>
        <div class="front-why-choose__layout">
            <div class="front-why-choose__grid">
                <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
                <div class="front-why-choose__box card-border fade-in fade-in-delay-<?php echo esc_attr( (string) ( $i + 1 ) ); ?>">
                    <div class="front-why-choose__box-icon" aria-hidden="true">
                        <?php
						$icons = array( 1 => 'map-pin', 2 => 'clock', 3 => 'briefcase', 4 => 'users' );
						Hotelier_Lucide_Icon::render( $icons[ $i ] );
						?>
                    </div>
                    <h3 class="front-why-choose__box-title"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'why_' . $i . '_title' ) ); ?></h3>
                    <p class="front-why-choose__box-text text-body"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'why_' . $i . '_text' ) ); ?></p>
                </div>
                <?php endfor; ?>
            </div>
            <div class="front-why-choose__image fade-in fade-in-delay-3" aria-hidden="true" style="background-image: url('<?php echo esc_url( $side ); ?>');"></div>
        </div>
    </div>
</section>
