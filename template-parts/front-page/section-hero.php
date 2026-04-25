<?php
/**
 * Front page hero section.
 *
 * @package 360-hotelier
 */

$hctx  = 'home';
$hpage = (int) get_queried_object_id();
$hero  = Hotelier_Hero_Image_Field::resolve_url( $hpage, $hctx );
$line_2 = Hotelier_Page_Content::get_text( $hpage, $hctx, 'hero_title_line2' );
?>
<section class="front-hero card-border" style="background-image: url('<?php echo esc_url( $hero ); ?>');">
    <div class="front-hero__overlay section-overlay"></div>
    <div class="site-container front-hero__content">
        <h1 class="front-hero__title fade-in fade-in-delay-0"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'hero_title_line1' ) ); ?><br> <?php
            if ( function_exists( 'hotelier_get_current_lang' ) && 'el' === hotelier_get_current_lang() && class_exists( 'Hotelier_El_Page_Defaults' ) ) {
                $el_tail = Hotelier_El_Page_Defaults::FRONT_HERO_HOME_LINE2_TAIL;
                $pos     = function_exists( 'mb_strpos' ) ? mb_strpos( $line_2, $el_tail ) : strpos( $line_2, $el_tail );
                if ( false !== $pos ) {
                    $before = function_exists( 'mb_substr' ) ? mb_substr( $line_2, 0, $pos ) : substr( $line_2, 0, $pos );
                    echo esc_html( $before );
                    ?><span class="front-hero__title-el-tail"><?php echo esc_html( $el_tail ); ?></span><?php
                } else {
                    echo esc_html( $line_2 );
                }
            } else {
                echo esc_html( $line_2 );
            }
            ?></h1>
        <p class="front-hero__subheadline fade-in fade-in-delay-1"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'hero_subheadline' ) ); ?></p>
        <div class="front-hero__ctas fade-in fade-in-delay-2">
            <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( 'contact' ) ); ?>" class="btn btn--primary btn--lg"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'hero_cta_text' ) ); ?></a>
        </div>
    </div>
</section>
