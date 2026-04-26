<?php
/**
 * 404 Not Found template.
 *
 * @package 360-hotelier
 */

get_header();

$ctx     = 'error_404';
$page_id = 0;
if ( class_exists( 'Hotelier_Context_Page_Text_Acf_Field' ) ) {
	$ids = Hotelier_Context_Page_Text_Acf_Field::page_ids_for_context( $ctx );
	if ( isset( $ids[0] ) && (int) $ids[0] > 0 ) {
		$page_id = (int) $ids[0];
	}
}
$hero_bg = Hotelier_Page_Content::get_image_url( $page_id, $ctx, 'error_hero_bg' );
?>

<main id="main" class="site-main error-page-main">

	<section class="error-page__hero card-border" style="background-image: url('<?php echo esc_url( $hero_bg ); ?>');">
		<div class="section-overlay" aria-hidden="true"></div>
		<div class="site-container error-page__hero-inner">
			<h1 class="error-page__hero-title"><?php echo esc_html__( '404', '360-hotelier' ); ?></h1>
		</div>
	</section>

	<section class="error-page__panel front-services-overview card-border">
		<div class="site-container">
			<section class="error-404 not-found">
				<header class="page-header">
					<h2 class="error-page__panel-title front-section__title"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'error_title' ) ); ?></h2>
				</header>

				<div class="page-content">
					<p class="text-body"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'error_text' ) ); ?></p>
					<p class="error-page__cta">
						<a class="btn btn--primary" href="<?php echo esc_url( hotelier_get_localized_home_url() ); ?>"><?php echo esc_html( Hotelier_Page_Content::get_text( $page_id, $ctx, 'error_btn' ) ); ?></a>
					</p>
				</div>
			</section>
		</div>
	</section>

</main>

<?php
get_footer();
