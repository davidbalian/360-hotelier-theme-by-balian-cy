<?php
/**
 * Front page hero section.
 *
 * @package 360-hotelier
 */
?>
<section class="front-hero card-border" style="background-image: url('<?php echo esc_url( content_url( '/uploads/2026/03/360-hotelier-consulting-cyprus-hero.webp' ) ); ?>');">
    <div class="front-hero__overlay"></div>
    <div class="site-container front-hero__content">
        <h1 class="front-hero__title text-5xl"><?php esc_html_e( 'Revenue, Distribution &', '360-hotelier' ); ?><br><?php esc_html_e( 'Digital Growth for Hotels in Cyprus', '360-hotelier' ); ?></h1>
        <p class="front-hero__subheadline text-lg"><?php esc_html_e( 'Expert revenue management and B2B distribution for hotels in Cyprus, your extended commercial team, driving performance and unlocking profit potential.', '360-hotelier' ); ?></p>
        <div class="front-hero__ctas">
            <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--primary btn--lg"><?php esc_html_e( 'Start Your Free Hotel Strategy Session', '360-hotelier' ); ?></a>
        </div>
    </div>
</section>
