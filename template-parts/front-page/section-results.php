<?php
/**
 * Front page results / trust indicators section.
 *
 * @package 360-hotelier
 */

$hctx  = 'home';
$hpage = (int) get_queried_object_id();

$pendeli_id    = Hotelier_Page_Content::get_attachment_id( $hpage, $hctx, 'results_pendeli_svg' );
$pendeli_svg   = Hotelier_Page_Content::get_svg_inline( $pendeli_id, 'uploads/2026/03/pendeli-resort-hotel-cyprus-logo-white.svg' );
$pendeli_label = Hotelier_Page_Content::get_text( $hpage, $hctx, 'results_pendeli_label' );

// Same order as portfolio page hotels 1–8 (Pendeli is inline SVG between Tsanotel and Petit Palais).
$ticker_slots = array(
	array( 'kind' => 'img', 'n' => 1 ),
	array( 'kind' => 'img', 'n' => 2 ),
	array( 'kind' => 'img', 'n' => 3 ),
	array( 'kind' => 'img', 'n' => 4 ),
	array( 'kind' => 'pendeli' ),
	array( 'kind' => 'img', 'n' => 5 ),
	array( 'kind' => 'img', 'n' => 6 ),
	array( 'kind' => 'img', 'n' => 7 ),
);
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
                <?php foreach ( array( false, true ) as $ticker_is_duplicate ) : ?>
                    <?php foreach ( $ticker_slots as $slot ) : ?>
                        <?php if ( 'pendeli' === $slot['kind'] ) : ?>
                            <?php if ( ! $ticker_is_duplicate ) : ?>
                                <span class="ticker-logo ticker-logo--pendeli" role="img" aria-label="<?php echo esc_attr( $pendeli_label ); ?>"><?php echo $pendeli_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- inline trusted SVG ?></span>
                            <?php else : ?>
                                <span class="ticker-logo ticker-logo--pendeli" aria-hidden="true"><?php echo $pendeli_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                            <?php endif; ?>
                        <?php else : ?>
                            <?php
                            $n   = (int) $slot['n'];
                            $url = Hotelier_Page_Content::get_image_url( $hpage, $hctx, 'results_tick_' . $n );
                            ?>
                            <?php if ( ! $ticker_is_duplicate ) : ?>
                                <img src="<?php echo esc_url( $url ); ?>" alt="<?php echo esc_attr( Hotelier_Page_Content::get_text( $hpage, $hctx, 'results_tick_' . $n . '_alt' ) ); ?>" loading="lazy" />
                            <?php else : ?>
                                <img src="<?php echo esc_url( $url ); ?>" alt="" loading="lazy" aria-hidden="true" />
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
