<?php
/**
 * Template Name: Founder
 *
 * @package 360-hotelier
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="site-container page-founder">

        <article class="page-founder__content">
            <h1 class="page-founder__title"><?php esc_html_e( 'Giorgos Peyiazis', '360-hotelier' ); ?></h1>
            <p class="page-founder__subtitle text-md"><?php esc_html_e( 'Founder & Hospitality Consultant', '360-hotelier' ); ?></p>

            <div class="page-founder__image">
                <div class="page-founder__image-placeholder card-border" role="img" aria-label="<?php esc_attr_e( 'Giorgos Peyiazis, founder of 360 Hotelier Consulting', '360-hotelier' ); ?>"></div>
            </div>

            <p><?php esc_html_e( 'Giorgos Peyiazis is the Founder of 360° Hotelier Consulting, a hospitality sales and e-commerce consultancy based in Cyprus. With over fifteen years of experience in hotel sales, contracting, and digital distribution, Giorgos specialises in helping hotels and tourism businesses maximise their online performance and profitability.', '360-hotelier' ); ?></p>

            <p><?php esc_html_e( 'After completing his postgraduate studies in Business Administration with a specialization in Marketing at Les Roches International School of Hotel Management in Switzerland, Giorgos gained extensive experience across multiple sectors of the hospitality industry, both in Cyprus and abroad.', '360-hotelier' ); ?></p>

            <p><?php esc_html_e( 'From 2013 to 2021, he held key roles at Booking.com, collaborating with hundreds of hotel partners, delivering workshops, and representing the company at international conferences and industry events. His work focused on sales strategy, distribution management, and improving hotel market competitiveness.', '360-hotelier' ); ?></p>

            <p><?php esc_html_e( 'Between 2022 and 2024, Giorgos expanded his expertise in contracting management, tactical promotions, and strategic pricing, working closely with leading international travel companies such as DERTOUR Group, Schauinsland-Reisen, EasyJet Holidays, Love Holidays, Sunweb Group, ITAKA, and Grecos Holidays. These collaborations enhanced his understanding of global market trends and strengthened his ability to design effective, data-driven commercial strategies.', '360-hotelier' ); ?></p>

            <p><?php esc_html_e( 'Through 360° Hotelier Consulting, Giorgos now provides tailored consulting services focused on revenue optimisation, e-commerce management, and digital marketing for independent and boutique hotels. His goal is to help hoteliers increase visibility, drive direct bookings, and achieve sustainable revenue growth through strategic and practical solutions.', '360-hotelier' ); ?></p>

            <p><?php esc_html_e( 'Today, Giorgos works as an external e-commerce manager and pre-opening consultant for a variety of boutique, mid-scale, and upscale hotels, as well as tourism accommodations in Cyprus and abroad. His work continues to contribute to the growth and professionalisation of the hospitality sector, combining traditional hospitality values with innovative digital practices.', '360-hotelier' ); ?></p>

            <p class="page-founder__cta">
                <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'Get in Touch', '360-hotelier' ); ?></a>
                <a href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>" class="btn btn--outline"><?php esc_html_e( 'About 360° Hotelier Consulting', '360-hotelier' ); ?></a>
            </p>
        </article>

    </div>
</main>

<?php get_footer();
