<?php
/**
 * Portfolio page: two-row image marquee, fed by postmeta-backed gallery picker.
 *
 * Splits the picked images in half: first half → top row, second half → bottom row.
 * Each row's <img> tags are emitted twice (originals + aria-hidden clones) so a
 * pure-CSS `translateX(-50%)` keyframe loops seamlessly.
 *
 * Expects {@see get_template_part()} args: `page_id` (int).
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$page_id = isset( $page_id ) ? (int) $page_id : get_the_ID();
$ctx     = 'portfolio';

$ids = Hotelier_Portfolio_Gallery_Store::get_attachment_ids( $page_id );
if ( empty( $ids ) ) {
	return;
}

$title    = Hotelier_Page_Content::get_text( $page_id, $ctx, 'gallery_title' );
$subtitle = Hotelier_Page_Content::get_text( $page_id, $ctx, 'gallery_subtitle' );

$total       = count( $ids );
$split       = (int) ceil( $total / 2 );
$row_top_ids = array_slice( $ids, 0, $split );
$row_bot_ids = array_slice( $ids, $split );

if ( empty( $row_bot_ids ) ) {
	$row_bot_ids = $row_top_ids;
}

/**
 * Render one marquee row: its images twice (originals + aria-hidden clones)
 * so `translateX(-50%)` produces a seamless infinite loop.
 *
 * @param int[]  $row_ids   Attachment IDs for the row.
 * @param string $modifier  Row modifier ('top' | 'bottom').
 */
$render_row = static function ( array $row_ids, string $modifier ): void {
	if ( empty( $row_ids ) ) {
		return;
	}
	$row_class = 'portfolio-gallery-marquee__row portfolio-gallery-marquee__row--' . $modifier;
	?>
	<div class="portfolio-gallery-marquee__rail">
		<ul class="<?php echo esc_attr( $row_class ); ?>">
			<?php foreach ( $row_ids as $id ) : ?>
				<li class="portfolio-gallery-marquee__item">
					<?php
					echo wp_get_attachment_image(
						(int) $id,
						'large',
						false,
						array(
							'class'    => 'portfolio-gallery-marquee__image',
							'loading'  => 'lazy',
							'decoding' => 'async',
						)
					);
					?>
				</li>
			<?php endforeach; ?>
			<?php foreach ( $row_ids as $id ) : ?>
				<li class="portfolio-gallery-marquee__item" aria-hidden="true">
					<?php
					echo wp_get_attachment_image(
						(int) $id,
						'large',
						false,
						array(
							'class'    => 'portfolio-gallery-marquee__image',
							'loading'  => 'lazy',
							'decoding' => 'async',
							'alt'      => '',
						)
					);
					?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
	<?php
};
?>
<section class="page-section page-section--white page-portfolio-gallery" aria-labelledby="portfolio-gallery-heading">
	<?php if ( $title !== '' || $subtitle !== '' ) : ?>
		<div class="site-container">
			<div class="page-section__heading page-section__heading--center fade-in fade-in-delay-0">
				<?php if ( $title !== '' ) : ?>
					<h2 id="portfolio-gallery-heading" class="page-section__title"><?php echo esc_html( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $subtitle !== '' ) : ?>
					<p class="page-section__subtitle"><?php echo esc_html( $subtitle ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	<?php endif; ?>

	<div class="portfolio-gallery-marquee" data-portfolio-gallery-marquee>
		<?php $render_row( $row_top_ids, 'top' ); ?>
		<?php $render_row( $row_bot_ids, 'bottom' ); ?>
	</div>
</section>
