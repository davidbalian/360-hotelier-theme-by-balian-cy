<?php
/**
 * Front page hero section.
 *
 * @package 360-hotelier
 */
?>
<section class="front-hero card-border" style="background-image: url('<?php echo esc_url( content_url( '/uploads/2026/03/360-hotelier-consulting-cyprus-hero.webp' ) ); ?>');">
    <div class="front-hero__overlay section-overlay"></div>
    <div class="site-container front-hero__content">
        <h1 class="front-hero__title text-5xl fade-in fade-in-delay-0"><?php esc_html_e( 'Revenue, Distribution & ', '360-hotelier' ); ?><br><?php esc_html_e( 'Digital Growth for Hotels in Cyprus', '360-hotelier' ); ?></h1>
        <p class="front-hero__subheadline text-lg fade-in fade-in-delay-1"><?php esc_html_e( 'Revenue management and B2B distribution for hotels in Cyprus. Your external commercial team, built around measurable results.', '360-hotelier' ); ?></p>
        <div class="front-hero__ctas fade-in fade-in-delay-2">
            <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--primary btn--lg"><?php esc_html_e( 'Book a Free Strategy Session', '360-hotelier' ); ?></a>
        </div>
    </div>
</section>
