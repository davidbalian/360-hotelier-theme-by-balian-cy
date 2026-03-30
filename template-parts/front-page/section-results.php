<?php
/**
 * Front page results / trust indicators section.
 *
 * @package 360-hotelier
 */

$hctx  = 'home';
$hpage = (int) get_queried_object_id();

$pendeli_id = Hotelier_Page_Content::get_attachment_id( $hpage, $hctx, 'results_pendeli_svg' );
$pendeli_svg = Hotelier_Page_Content::get_svg_inline( $pendeli_id, 'uploads/2026/03/pendeli-resort-hotel-cyprus-logo-white.svg' );
$pendeli_label = Hotelier_Page_Content::get_text( $hpage, $hctx, 'results_pendeli_label' );
?>
<section class="front-results card-border">
    <div class="site-container">
        <h2 class="front-section__title fade-in fade-in-delay-0"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'results_title' ) ); ?></h2>
        <ul class="front-results__list">
            <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
            <li class="fade-in fade-in-delay-<?php echo esc_attr( (string) $i ); ?>">
                <span class="front-results__stat"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'results_stat_' . $i ) ); ?></span>
                <span class="front-results__label"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'results_label_' . $i ) ); ?></span>
            </li>
            <?php endfor; ?>
        </ul>
        <p class="front-results__trust fade-in fade-in-delay-5"><?php echo esc_html( Hotelier_Page_Content::get_text( $hpage, $hctx, 'results_trust' ) ); ?></p>
        <div class="front-results__ticker fade-in fade-in-delay-6">
            <div class="front-results__ticker-track">
                <span class="ticker-logo ticker-logo--pendeli" role="img" aria-label="<?php echo esc_attr( $pendeli_label ); ?>"><?php echo $pendeli_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- inline trusted SVG ?></span>
                <?php for ( $t = 1; $t <= 6; $t++ ) : ?>
                <img src="<?php echo esc_url( Hotelier_Page_Content::get_image_url( $hpage, $hctx, 'results_tick_' . $t ) ); ?>" alt="<?php echo esc_attr( Hotelier_Page_Content::get_text( $hpage, $hctx, 'results_tick_' . $t . '_alt' ) ); ?>" loading="lazy" />
                <?php endfor; ?>
                <!-- Duplicate set for seamless loop -->
                <span class="ticker-logo ticker-logo--pendeli" aria-hidden="true"><?php echo $pendeli_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                <?php for ( $t = 1; $t <= 6; $t++ ) : ?>
                <img src="<?php echo esc_url( Hotelier_Page_Content::get_image_url( $hpage, $hctx, 'results_tick_' . $t ) ); ?>" alt="" loading="lazy" aria-hidden="true" />
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>
