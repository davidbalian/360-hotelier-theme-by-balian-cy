<?php
/**
 * Portfolio page: testimonials carousel (dummy/schema-driven copy; Greek via El defaults).
 *
 * Expects {@see get_template_part()} args: `page_id` (int).
 *
 * @package 360-hotelier
 */

$page_id = isset( $page_id ) ? (int) $page_id : get_the_ID();
$ctx     = 'portfolio';

$title    = Hotelier_Page_Content::get_text( $page_id, $ctx, 'testimonials_title' );
$subtitle = Hotelier_Page_Content::get_text( $page_id, $ctx, 'testimonials_subtitle' );

$slides = array();
for ( $i = 1; $i <= 8; $i++ ) {
	$slides[] = array(
		'quote' => Hotelier_Page_Content::get_text( $page_id, $ctx, 'testimonial_' . $i . '_quote' ),
		'name'  => Hotelier_Page_Content::get_text( $page_id, $ctx, 'testimonial_' . $i . '_name' ),
		'role'  => Hotelier_Page_Content::get_text( $page_id, $ctx, 'testimonial_' . $i . '_role' ),
	);
}

$carousel_label = $title !== '' ? $title : __( 'Testimonials', '360-hotelier' );
?>
<section class="page-section page-section--white page-portfolio-testimonials" aria-labelledby="portfolio-testimonials-heading">
	<div class="site-container">
		<div class="page-section__heading page-section__heading--center fade-in fade-in-delay-0">
			<?php if ( $title !== '' ) : ?>
				<h2 id="portfolio-testimonials-heading" class="page-section__title"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>
			<?php if ( $subtitle !== '' ) : ?>
				<p class="page-section__subtitle"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>
		</div>
	</div>

	<div
		class="page-portfolio-testimonials__carousel"
		data-testimonial-carousel
		role="region"
		aria-roledescription="<?php echo esc_attr__( 'carousel', '360-hotelier' ); ?>"
		aria-label="<?php echo esc_attr( $carousel_label ); ?>"
	>
		<div class="site-container page-portfolio-testimonials__carousel-inner">
			<div class="page-portfolio-testimonials__chrome">
				<button
					type="button"
					class="page-portfolio-testimonials__arrow page-portfolio-testimonials__arrow--prev"
					data-testimonial-prev
					aria-controls="page-portfolio-testimonials-track"
					aria-label="<?php echo esc_attr__( 'Previous testimonial', '360-hotelier' ); ?>"
				>
					<?php Hotelier_Lucide_Icon::render( 'chevron-left', 'page-portfolio-testimonials__arrow-icon' ); ?>
				</button>

				<div
					class="page-portfolio-testimonials__viewport"
					data-testimonial-viewport
					tabindex="0"
				>
					<div
						id="page-portfolio-testimonials-track"
						class="page-portfolio-testimonials__track"
						data-testimonial-track
					>
						<?php foreach ( $slides as $idx => $slide ) : ?>
							<?php
							$slide_num = $idx + 1;
							$slide_id = 'portfolio-testimonial-slide-' . $slide_num;
							$label_parts = array_filter( array( $slide['name'], $slide['role'] ) );
							$slide_label = $label_parts ? implode( ', ', $label_parts ) : sprintf( /* translators: %d: slide number */ __( 'Testimonial %d', '360-hotelier' ), $slide_num );
							?>
							<div
								id="<?php echo esc_attr( $slide_id ); ?>"
								class="page-portfolio-testimonials__slide"
								data-testimonial-slide
								data-testimonial-index="<?php echo esc_attr( (string) $idx ); ?>"
								role="group"
								aria-roledescription="<?php echo esc_attr__( 'slide', '360-hotelier' ); ?>"
								aria-label="<?php echo esc_attr( $slide_label ); ?>"
							>
								<blockquote class="page-portfolio-testimonials__card card-border">
									<?php Hotelier_Lucide_Icon::render( 'quote', 'page-portfolio-testimonials__quote-icon' ); ?>
									<?php if ( $slide['quote'] !== '' ) : ?>
										<p class="page-portfolio-testimonials__quote"><?php echo esc_html( $slide['quote'] ); ?></p>
									<?php endif; ?>
									<footer class="page-portfolio-testimonials__footer">
										<?php if ( $slide['name'] !== '' ) : ?>
											<cite class="page-portfolio-testimonials__name"><?php echo esc_html( $slide['name'] ); ?></cite>
										<?php endif; ?>
										<?php if ( $slide['role'] !== '' ) : ?>
											<span class="page-portfolio-testimonials__role"><?php echo esc_html( $slide['role'] ); ?></span>
										<?php endif; ?>
									</footer>
								</blockquote>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<button
					type="button"
					class="page-portfolio-testimonials__arrow page-portfolio-testimonials__arrow--next"
					data-testimonial-next
					aria-controls="page-portfolio-testimonials-track"
					aria-label="<?php echo esc_attr__( 'Next testimonial', '360-hotelier' ); ?>"
				>
					<?php Hotelier_Lucide_Icon::render( 'chevron-right', 'page-portfolio-testimonials__arrow-icon' ); ?>
				</button>
			</div>

			<div class="page-portfolio-testimonials__dots" data-testimonial-dots role="tablist" aria-label="<?php echo esc_attr__( 'Choose testimonial', '360-hotelier' ); ?>">
				<?php foreach ( $slides as $idx => $slide ) : ?>
					<?php $n = $idx + 1; ?>
					<button
						type="button"
						class="page-portfolio-testimonials__dot"
						data-testimonial-dot="<?php echo esc_attr( (string) $idx ); ?>"
						role="tab"
						aria-selected="<?php echo 0 === $idx ? 'true' : 'false'; ?>"
						aria-controls="portfolio-testimonial-slide-<?php echo esc_attr( (string) $n ); ?>"
						aria-label="<?php echo esc_attr( sprintf( __( 'Go to testimonial %d', '360-hotelier' ), $n ) ); ?>"
					></button>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
