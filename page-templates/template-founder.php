<?php
/**
 * Template Name: Founder
 *
 * @package 360-hotelier
 */

$page_hero_title    = __( 'Giorgos Peyiazis', '360-hotelier' );
$page_hero_subtitle = __( 'Founder & Hospitality Consultant · 15+ years in hotel revenue management, online sales and digital strategy.', '360-hotelier' );
$page_hero_image    = content_url( '/uploads/2026/03/george-peyiazis-hotel-revenue-consultant-360-hotelier-cyprus.webp' );

get_header();
get_template_part( 'template-parts/page/page-hero' );
?>

<main id="main" class="site-main page-founder">

    <!-- Bio Section -->
    <section class="page-founder__bio-section">
        <div class="site-container">
            <div class="page-founder__bio-grid">

                <div class="fade-in fade-in-delay-0">
                    <img
                        class="page-founder__photo"
                        src="<?php echo esc_url( content_url( '/uploads/2026/03/george-peyiazis-hotel-revenue-consultant-360-hotelier-cyprus.webp' ) ); ?>"
                        alt="<?php esc_attr_e( 'Giorgos Peyiazis, Founder of 360 Hotelier Consulting', '360-hotelier' ); ?>"
                        loading="lazy"
                    />
                </div>

                <div class="page-founder__bio-card card-border fade-in fade-in-delay-1">
                    <h2><?php esc_html_e( 'About Giorgos', '360-hotelier' ); ?></h2>
                    <p class="page-founder__role"><?php esc_html_e( 'Founder & Hospitality Consultant — 360° Hotelier Consulting', '360-hotelier' ); ?></p>
                    <p><?php esc_html_e( 'Giorgos Peyiazis is the Founder of 360° Hotelier Consulting, a hospitality sales and e-commerce consultancy based in Cyprus. With over fifteen years of experience in hotel sales, contracting, and digital distribution, Giorgos specialises in helping hotels and tourism businesses maximise their online performance and profitability.', '360-hotelier' ); ?></p>
                    <p><?php esc_html_e( 'After completing his postgraduate studies in Business Administration with a specialization in Marketing at Les Roches International School of Hotel Management in Switzerland, Giorgos gained extensive experience across multiple sectors of the hospitality industry, both in Cyprus and abroad.', '360-hotelier' ); ?></p>
                    <p><?php esc_html_e( 'Through 360° Hotelier Consulting, Giorgos provides tailored consulting services focused on revenue optimisation, e-commerce management, and digital marketing for independent and boutique hotels. His goal is to help hoteliers increase visibility, drive direct bookings, and achieve sustainable revenue growth through strategic and practical solutions.', '360-hotelier' ); ?></p>
                    <div class="page-founder__bio-actions">
                        <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'Get in Touch', '360-hotelier' ); ?></a>
                        <a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>" class="btn btn--outline"><?php esc_html_e( 'About 360° Hotelier', '360-hotelier' ); ?></a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Experience Timeline -->
    <section class="page-founder__timeline">
        <div class="site-container">

            <div class="front-approach__heading fade-in fade-in-delay-0">
                <h2 class="front-section__title text-2xl"><?php esc_html_e( 'Professional Experience', '360-hotelier' ); ?></h2>
                <p class="front-section__subtitle"><?php esc_html_e( '15+ years building expertise across distribution, revenue and digital strategy.', '360-hotelier' ); ?></p>
            </div>

            <div class="front-approach__inner">

                <div class="front-approach__image fade-in fade-in-delay-1">
                    <img src="<?php echo esc_url( content_url( 'uploads/2026/03/person-at-hotel-reception-scaled.webp' ) ); ?>" alt="<?php esc_attr_e( 'Hotel consultant at work', '360-hotelier' ); ?>" class="front-approach__img">
                </div>

                <div class="front-approach__content front-approach__card card-border">
                    <div class="front-approach__steps">

                        <div class="front-approach__step fade-in fade-in-delay-2">
                            <span class="front-approach__step-number text-3xl">01</span>
                            <div class="front-approach__step-body">
                                <h3 class="front-approach__step-title text-base"><?php esc_html_e( 'Booking.com · 2013–2021', '360-hotelier' ); ?></h3>
                                <p class="front-approach__step-text text-body"><?php esc_html_e( 'Key roles in sales strategy, distribution management and hotel market competitiveness. Delivered workshops and represented Booking.com at international conferences.', '360-hotelier' ); ?></p>
                            </div>
                        </div>
                        <hr class="front-approach__divider">

                        <div class="front-approach__step fade-in fade-in-delay-3">
                            <span class="front-approach__step-number text-3xl">02</span>
                            <div class="front-approach__step-body">
                                <h3 class="front-approach__step-title text-base"><?php esc_html_e( 'Tour Operators & Wholesalers · 2022–2024', '360-hotelier' ); ?></h3>
                                <p class="front-approach__step-text text-body"><?php esc_html_e( 'Contracting management, tactical promotions and strategic pricing for DERTOUR Group, EasyJet Holidays, Sunweb Group, Love Holidays, ITAKA, Grecos Holidays and more.', '360-hotelier' ); ?></p>
                            </div>
                        </div>
                        <hr class="front-approach__divider">

                        <div class="front-approach__step fade-in fade-in-delay-4">
                            <span class="front-approach__step-number text-3xl">03</span>
                            <div class="front-approach__step-body">
                                <h3 class="front-approach__step-title text-base"><?php esc_html_e( '360° Hotelier Consulting · 2024–Present', '360-hotelier' ); ?></h3>
                                <p class="front-approach__step-text text-body"><?php esc_html_e( 'External e-commerce manager and pre-opening consultant for boutique, mid-scale and upscale hotels across Cyprus and abroad. Full commercial support from revenue to digital.', '360-hotelier' ); ?></p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="front-featured-banner card-border" style="background-image: url('<?php echo esc_url( content_url( '/uploads/2026/03/featured-360-hotelier.webp' ) ); ?>');">
        <div class="front-featured-banner__overlay section-overlay"></div>
        <div class="site-container front-featured-banner__content fade-in fade-in-delay-0">
            <h2 class="front-featured-banner__title text-4xl"><?php esc_html_e( 'Work With Giorgos', '360-hotelier' ); ?></h2>
            <p class="front-featured-banner__text"><?php esc_html_e( "Ready to grow your hotel's revenue and distribution? Let's have a conversation.", '360-hotelier' ); ?></p>
            <div class="front-featured-banner__actions">
                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'Get in Touch', '360-hotelier' ); ?></a>
            </div>
        </div>
    </section>

</main>

<?php get_footer();
