<?php
/**
 * Template Name: About Us
 *
 * @package 360-hotelier
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="site-container page-about">

        <article class="page-about__content">
            <h1 class="page-about__title"><?php esc_html_e( 'Your Trusted Hotel Consultant in Cyprus', '360-hotelier' ); ?></h1>

            <p><?php esc_html_e( '360° Hotelier Consulting is a Cyprus-based hotel consultancy providing strategic commercial support to independent hotels, boutique properties and resorts across the island.', '360-hotelier' ); ?></p>

            <p><?php esc_html_e( 'As an experienced hotel consultant in Cyprus, we specialize in hotel revenue management, online sales & B2B distribution, e-commerce, digital marketing and tour-operator contracting, helping hotels increase revenue, improve profitability and strengthen their market positioning.', '360-hotelier' ); ?></p>

            <p><?php esc_html_e( "With more than 15 years of experience in the hospitality and travel industry, we support hotels in navigating today's complex commercial environment through data-driven strategies, digital expertise and hands-on execution.", '360-hotelier' ); ?></p>

            <h2><?php esc_html_e( 'What We Do', '360-hotelier' ); ?></h2>
            <p><?php esc_html_e( 'We provide end-to-end commercial consulting services for hotels in Cyprus, tailored to each property\'s size, concept and market dynamics.', '360-hotelier' ); ?></p>
            <p><?php esc_html_e( 'Our core services include:', '360-hotelier' ); ?></p>
            <ul>
                <li><strong><?php esc_html_e( 'Yield & Revenue Management', '360-hotelier' ); ?></strong> — <?php esc_html_e( 'Strategic pricing, demand forecasting and segmentation designed to maximize RevPAR and revenue performance.', '360-hotelier' ); ?></li>
                <li><strong><?php esc_html_e( 'Online Sales & B2B Distribution', '360-hotelier' ); ?></strong> — <?php esc_html_e( 'OTA optimization, channel-mix strategy and development of profitable B2B partnerships.', '360-hotelier' ); ?></li>
                <li><strong><?php esc_html_e( 'E-Commerce & Digital Marketing', '360-hotelier' ); ?></strong> — <?php esc_html_e( 'Direct booking optimization, SEO & SEM, social media marketing and digital performance analysis.', '360-hotelier' ); ?></li>
                <li><strong><?php esc_html_e( 'Contracting & Tour Operator Negotiations', '360-hotelier' ); ?></strong> — <?php esc_html_e( 'Professional representation and negotiation with tour operators and wholesalers, acting in the hotel\'s best commercial interest.', '360-hotelier' ); ?></li>
            </ul>
            <p><?php esc_html_e( 'As a dedicated hotel consultant in Cyprus, we ensure that every strategy is aligned with local seasonality, demand patterns and the Cyprus tourism landscape.', '360-hotelier' ); ?></p>

            <h2><?php esc_html_e( 'How We Work', '360-hotelier' ); ?></h2>
            <p><?php esc_html_e( 'Our approach is practical, transparent and results-oriented.', '360-hotelier' ); ?></p>
            <p><?php esc_html_e( 'We begin with a comprehensive commercial audit of your hotel, analyzing pricing strategy, online distribution, digital presence and existing contracts. Based on these insights, we develop a customized commercial strategy that supports both short-term revenue growth and long-term sustainability.', '360-hotelier' ); ?></p>
            <p><?php esc_html_e( 'Throughout the collaboration, we work as an extension of your internal team, providing hands-on management, regular reporting and continuous optimization.', '360-hotelier' ); ?></p>

            <h2><?php esc_html_e( 'Meet the Founder', '360-hotelier' ); ?></h2>
            <p><strong><?php esc_html_e( 'Giorgos Peyiazis — Founder & Hotel Consultant', '360-hotelier' ); ?></strong></p>
            <p><?php esc_html_e( 'Giorgos Peyiazis is the Founder of 360° Hotelier Consulting and an experienced hotel consultant in Cyprus, with a professional background spanning more than 15 years in hotel revenue management, online distribution, digital marketing and commercial strategy.', '360-hotelier' ); ?></p>
            <p><?php esc_html_e( 'Giorgos has worked closely with independent hotels, boutique properties and international hospitality platforms, supporting hotels in improving revenue performance, strengthening online sales channels and negotiating effective B2B and tour-operator agreements.', '360-hotelier' ); ?></p>
            <p><a href="<?php echo esc_url( home_url( '/founder/' ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'Read Full Bio', '360-hotelier' ); ?></a></p>

            <h2><?php esc_html_e( 'Our Philosophy', '360-hotelier' ); ?></h2>
            <p><?php esc_html_e( 'At 360° Hotelier Consulting, we believe that successful hotel consulting is built on partnership, trust and long-term collaboration.', '360-hotelier' ); ?></p>
            <p><?php esc_html_e( 'We work with a select number of hotels in Cyprus, allowing us to remain fully engaged, responsive and accountable. Our goal is not simply to advise, but to actively support hotels in improving performance and achieving sustainable commercial growth.', '360-hotelier' ); ?></p>
            <p><?php esc_html_e( 'By combining local expertise, international best practices and modern digital tools, we help hotels remain competitive in an evolving hospitality landscape.', '360-hotelier' ); ?></p>

            <h2><?php esc_html_e( 'Why Choose 360° Hotelier Consulting', '360-hotelier' ); ?></h2>
            <ul>
                <li><?php esc_html_e( 'Experienced hotel consultant in Cyprus with proven results', '360-hotelier' ); ?></li>
                <li><?php esc_html_e( '15+ years of hospitality sales, revenue and digital expertise', '360-hotelier' ); ?></li>
                <li><?php esc_html_e( 'Strong understanding of the Cyprus tourism and hotel market', '360-hotelier' ); ?></li>
                <li><?php esc_html_e( 'Data-driven strategies with measurable KPIs', '360-hotelier' ); ?></li>
                <li><?php esc_html_e( 'Hands-on support, not generic consultancy', '360-hotelier' ); ?></li>
            </ul>

            <div class="page-about__cta">
                <h2><?php esc_html_e( 'Looking for a Reliable Hotel Consultant in Cyprus?', '360-hotelier' ); ?></h2>
                <p><?php esc_html_e( "Let's discuss how 360° Hotelier Consulting can support your hotel's revenue, distribution and digital growth.", '360-hotelier' ); ?></p>
                <p>
                    <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'Book a Free Consultation', '360-hotelier' ); ?></a>
                    <a href="<?php echo esc_url( home_url( '/services/' ) ); ?>" class="btn btn--outline"><?php esc_html_e( 'Explore Our Services', '360-hotelier' ); ?></a>
                </p>
            </div>
        </article>

    </div>
</main>

<?php get_footer();
