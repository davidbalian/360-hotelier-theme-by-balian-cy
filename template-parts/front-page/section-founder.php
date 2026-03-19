<?php
/**
 * Front page "Meet the Founder" section.
 *
 * @package 360-hotelier
 */
$about_url = '#';
?>
<section class="front-founder">
    <div class="site-container front-founder__inner">
        <div class="front-founder__image fade-in fade-in-delay-0">
            <img class="front-founder__photo" src="<?php echo esc_url( content_url( '/uploads/2026/03/george-peyiazis-hotel-revenue-consultant-360-hotelier-cyprus.webp' ) ); ?>" alt="<?php esc_attr_e( 'Giorgos Peyiazis, Founder of 360 Hotelier Consulting', '360-hotelier' ); ?>" loading="lazy" />
        </div>
        <div class="front-founder__card card-border">
        <div class="front-founder__content">
            <h2 class="front-founder__heading text-2xl fade-in fade-in-delay-1"><?php esc_html_e( 'Meet the Founder', '360-hotelier' ); ?></h2>
            <h3 class="front-founder__name fade-in fade-in-delay-2"><?php esc_html_e( 'Giorgos Peyiazis', '360-hotelier' ); ?></h3>
            <p class="fade-in fade-in-delay-3"><?php esc_html_e( 'Giorgos has 15+ years in hotel revenue management, digital marketing, online sales and tour-operator contracting. He works with independent and boutique hotels across Cyprus.', '360-hotelier' ); ?></p>
            <p class="fade-in fade-in-delay-4"><?php esc_html_e( 'His goal: help Cyprus hotels grow through smarter commercial decisions.', '360-hotelier' ); ?></p>
            <ul class="front-founder__points">
                <li class="fade-in fade-in-delay-5"><?php esc_html_e( '15+ years in hospitality sales & distribution', '360-hotelier' ); ?></li>
                <li class="fade-in fade-in-delay-6"><?php esc_html_e( 'Hands-on knowledge of the Cyprus hotel market', '360-hotelier' ); ?></li>
                <li class="fade-in fade-in-delay-7"><?php esc_html_e( 'Track record in growing RevPAR and direct bookings', '360-hotelier' ); ?></li>
                <li class="fade-in fade-in-delay-8"><?php esc_html_e( 'Trusted advisor to boutique, resort and independent hotels', '360-hotelier' ); ?></li>
            </ul>
            <a href="<?php echo esc_url( $about_url ); ?>" class="btn btn--primary front-founder__cta fade-in fade-in-delay-9"><?php esc_html_e( 'About Us', '360-hotelier' ); ?></a>
        </div>
        </div>
    </div>
</section>
