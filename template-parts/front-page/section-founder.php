<?php
/**
 * Front page "Meet the Founder" section.
 *
 * @package 360-hotelier
 */
$about_url = home_url( '/about-us/' );
?>
<section class="front-founder">
    <div class="site-container front-founder__inner">
        <div class="front-founder__image">
            <img class="front-founder__photo" src="<?php echo esc_url( content_url( '/uploads/2026/03/george-peyiazis-hotel-revenue-consultant-360-hotelier-cyprus.webp' ) ); ?>" alt="<?php esc_attr_e( 'Giorgos Peyiazis, Founder of 360 Hotelier Consulting', '360-hotelier' ); ?>" loading="lazy" />
        </div>
        <div class="front-founder__content">
            <h2 class="front-section__title"><?php esc_html_e( 'Meet the Founder - Giorgos Peyiazis', '360-hotelier' ); ?></h2>
            <p><?php esc_html_e( 'With over 15 years of experience in hotel revenue management, digital marketing, online sales and tour-operator contracting, Giorgos brings international expertise and local market understanding to independent and boutique hotels in Cyprus.', '360-hotelier' ); ?></p>
            <p><strong><?php esc_html_e( 'His mission is simple:', '360-hotelier' ); ?></strong></p>
            <p><?php esc_html_e( 'Help Cyprus hotels grow sustainably through smarter commercial strategies.', '360-hotelier' ); ?></p>
            <ul class="front-founder__points">
                <li><?php esc_html_e( 'Extensive experience in hospitality sales & distribution', '360-hotelier' ); ?></li>
                <li><?php esc_html_e( 'Deep knowledge of Cyprus hotel market', '360-hotelier' ); ?></li>
                <li><?php esc_html_e( 'Proven track record in driving RevPAR and direct bookings', '360-hotelier' ); ?></li>
                <li><?php esc_html_e( 'Trusted advisor to boutique, resort and independent hotels', '360-hotelier' ); ?></li>
            </ul>
            <a href="<?php echo esc_url( $about_url ); ?>" class="btn btn--primary"><?php esc_html_e( 'About 360° Hotelier Consulting', '360-hotelier' ); ?></a>
        </div>
    </div>
</section>
