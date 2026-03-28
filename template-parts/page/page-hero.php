<?php
/**
 * Inner page hero section.
 *
 * Set these variables before calling get_template_part():
 *   $page_hero_title    (string) — H1 heading text
 *   $page_hero_subtitle (string) — Optional subtitle paragraph
 *   $page_hero_image    (string) — Background image URL
 *
 * @package 360-hotelier
 */
?>
<section class="page-hero" style="background-image: url('<?php echo esc_url( $page_hero_image ); ?>');">
    <div class="section-overlay section-overlay--strong" aria-hidden="true"></div>
    <div class="site-container page-hero__content">
        <?php if ( ! empty( $page_hero_label ) ) : ?>
            <p class="page-hero__label fade-in fade-in-delay-0"><?php echo esc_html( $page_hero_label ); ?></p>
        <?php endif; ?>
        <h1 class="page-hero__title text-5xl fade-in fade-in-delay-1"><?php echo esc_html( $page_hero_title ); ?></h1>
        <?php if ( ! empty( $page_hero_subtitle ) ) : ?>
            <p class="page-hero__subtitle text-lg fade-in fade-in-delay-2"><?php echo esc_html( $page_hero_subtitle ); ?></p>
        <?php endif; ?>
    </div>
</section>
