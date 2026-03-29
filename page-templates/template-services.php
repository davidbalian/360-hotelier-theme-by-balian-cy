<?php
/**
 * Template Name: Services
 *
 * @package 360-hotelier
 */

$page_hero_title    = __( 'Our Core Services', '360-hotelier' );
$page_hero_subtitle = __( 'Revenue, distribution and digital growth for hotels in Cyprus. We act as your external commercial team.', '360-hotelier' );
$page_hero_image    = content_url( '/uploads/2026/03/360-hotelier-consulting-cyprus-hero.webp' );

$services_offer = array(
	array(
		'title'    => __( 'Yield & Revenue Management', '360-hotelier' ),
		'text'     => __( 'Dynamic pricing, forecasting, segmentation and performance analysis to maximise RevPAR and increase revenue.', '360-hotelier' ),
		'url_slug' => 'revenue-management',
		'image'    => content_url( '/uploads/2026/03/service-yield-revenue-management.webp' ),
		'alt'      => __( 'Yield & Revenue Management', '360-hotelier' ),
	),
	array(
		'title'    => __( 'Online Sales & B2B Distribution', '360-hotelier' ),
		'text'     => __( 'OTA optimisation, B2B partnerships, channel-mix strategy and distribution management across global and regional markets.', '360-hotelier' ),
		'url_slug' => 'online-sales-distribution',
		'image'    => content_url( '/uploads/2026/03/service-online-sales-b2b-distribution.webp' ),
		'alt'      => __( 'Online Sales & B2B Distribution', '360-hotelier' ),
	),
	array(
		'title'    => __( 'E-Commerce & Digital Marketing', '360-hotelier' ),
		'text'     => __( 'Direct booking strategy, SEO/SEM campaigns, social media management and digital performance tracking.', '360-hotelier' ),
		'url_slug' => 'digital-marketing',
		'image'    => content_url( '/uploads/2026/03/service-ecommerce-digital-marketing.webp' ),
		'alt'      => __( 'E-Commerce & Digital Marketing', '360-hotelier' ),
	),
	array(
		'title'    => __( 'Contracting & Negotiations (Tour Operators)', '360-hotelier' ),
		'text'     => __( 'Full contracting services, benchmarking, negotiation support and relationship management with key tour operators & travel partners.', '360-hotelier' ),
		'url_slug' => 'tour-operator-contracting',
		'image'    => content_url( '/uploads/2026/03/service-contracting-negotiations.webp' ),
		'alt'      => __( 'Contracting & Negotiations', '360-hotelier' ),
	),
);

get_header();
get_template_part( 'template-parts/page/page-hero' );
?>

<main id="main" class="site-main page-services">

    <!-- Services Grid -->
    <section id="services" class="page-section page-section--gray">
        <div class="site-container">
            <div class="page-section__heading page-section__heading--center fade-in fade-in-delay-0">
                <h2 class="page-section__title"><?php esc_html_e( 'What We Offer', '360-hotelier' ); ?></h2>
                <p class="page-section__subtitle"><?php esc_html_e( 'We help hotels drive direct bookings, optimise channel mix and negotiate stronger tour-operator & B2B agreements.', '360-hotelier' ); ?></p>
            </div>

            <div class="page-services__rows">
                <?php foreach ( $services_offer as $index => $service ) : ?>
                    <?php
                    $row_class = 'page-services__row fade-in fade-in-delay-' . min( $index + 1, 10 );
                    if ( 1 === ( $index % 2 ) ) {
                        $row_class .= ' page-services__row--flip';
                    }
                    ?>
                    <div class="<?php echo esc_attr( $row_class ); ?>">
                        <div class="page-services__offer-card card-border">
                            <h3 class="page-services__offer-title"><?php echo esc_html( $service['title'] ); ?></h3>
                            <p class="page-services__offer-text text-body"><?php echo esc_html( $service['text'] ); ?></p>
                            <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( $service['url_slug'] ) ); ?>" class="btn btn--secondary btn--sm"><?php esc_html_e( 'Learn more', '360-hotelier' ); ?></a>
                        </div>
                        <div class="page-services__row-media">
                            <img
                                src="<?php echo esc_url( $service['image'] ); ?>"
                                alt="<?php echo esc_attr( $service['alt'] ); ?>"
                                width="1920"
                                height="1081"
                                loading="lazy"
                                sizes="(max-width: 768px) calc(100vw - 64px), 480px"
                            />
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- CTA Banner -->
    <section class="front-featured-banner card-border" style="background-image: url('<?php echo esc_url( content_url( '/uploads/2026/03/featured-360-hotelier.webp' ) ); ?>');">
        <div class="front-featured-banner__overlay section-overlay"></div>
        <div class="site-container front-featured-banner__content fade-in fade-in-delay-0">
            <h2 class="front-featured-banner__title"><?php esc_html_e( "Grow Your Hotel's Revenue.", '360-hotelier' ); ?></h2>
            <p class="front-featured-banner__text"><?php esc_html_e( "We'll build a commercial strategy around your property, market and goals.", '360-hotelier' ); ?></p>
            <div class="front-featured-banner__actions">
                <a href="<?php echo esc_url( hotelier_get_page_url_by_slug( 'contact' ) ); ?>" class="btn btn--primary"><?php esc_html_e( 'Book a Free Consultation', '360-hotelier' ); ?></a>
            </div>
        </div>
    </section>

</main>

<?php get_footer();
