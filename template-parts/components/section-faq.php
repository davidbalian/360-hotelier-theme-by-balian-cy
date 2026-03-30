<?php
/**
 * Reusable FAQ accordion section.
 *
 * @package 360-hotelier
 *
 * WordPress passes the third argument to get_template_part() via extract(); use one array key.
 *
 * @var array $hotelier_section_faq {
 *     @type string $context          Hotelier_Faq_Content context constant value.
 *     @type string $heading          Section heading.
 *     @type string $intro            Optional intro paragraph below heading.
 *     @type string $section_modifier Optional BEM modifier for section (e.g. front-page).
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$defaults = array(
	'context'          => Hotelier_Faq_Content::CONTEXT_SERVICES,
	'heading'          => __( 'Frequently asked questions', '360-hotelier' ),
	'intro'            => '',
	'section_modifier' => '',
);

$args = isset( $hotelier_section_faq ) && is_array( $hotelier_section_faq )
	? array_merge( $defaults, $hotelier_section_faq )
	: $defaults;

$items = Hotelier_Faq_Content::get_items_for_context( $args['context'] );
if ( $items === array() ) {
	return;
}

$section_classes = array( 'hotel-faq-section', 'page-section' );
if ( $args['section_modifier'] !== '' ) {
	$section_classes[] = 'hotel-faq-section--' . sanitize_html_class( $args['section_modifier'] );
}

$section_id = 'hotel-faq-' . sanitize_title( $args['context'] );
?>
<section class="<?php echo esc_attr( implode( ' ', $section_classes ) ); ?>" id="<?php echo esc_attr( $section_id ); ?>" aria-labelledby="<?php echo esc_attr( $section_id ); ?>-heading">
	<div class="site-container">
		<div class="hotel-faq-section__heading page-section__heading page-section__heading--center fade-in fade-in-delay-0">
			<h2 class="page-section__title" id="<?php echo esc_attr( $section_id ); ?>-heading"><?php echo esc_html( $args['heading'] ); ?></h2>
			<?php if ( $args['intro'] !== '' ) : ?>
				<p class="page-section__subtitle hotel-faq-section__intro"><?php echo esc_html( $args['intro'] ); ?></p>
			<?php endif; ?>
		</div>

		<div class="hotel-faq card-border fade-in fade-in-delay-1" data-hotel-faq>
			<?php foreach ( $items as $index => $item ) : ?>
				<?php
				$uid     = wp_unique_id( 'hf-' );
				$btn_id  = 'hotel-faq-trigger-' . $uid;
				$panel_id = 'hotel-faq-panel-' . $uid;
				?>
				<div class="hotel-faq__item" data-hotel-faq-item data-faq-id="<?php echo esc_attr( $item['id'] ); ?>">
					<h3 class="hotel-faq__question">
						<button
							type="button"
							class="hotel-faq__trigger"
							id="<?php echo esc_attr( $btn_id ); ?>"
							aria-expanded="false"
							aria-controls="<?php echo esc_attr( $panel_id ); ?>"
						>
							<span class="hotel-faq__trigger-text"><?php echo esc_html( $item['question'] ); ?></span>
							<span class="hotel-faq__trigger-icon" aria-hidden="true">
								<?php Hotelier_Lucide_Icon::render( 'chevron-down', 'hotel-faq__chevron' ); ?>
							</span>
						</button>
					</h3>
					<div
						class="hotel-faq__panel"
						id="<?php echo esc_attr( $panel_id ); ?>"
						role="region"
						aria-labelledby="<?php echo esc_attr( $btn_id ); ?>"
						aria-hidden="true"
					>
						<div class="hotel-faq__panel-inner">
							<div class="hotel-faq__answer-inner">
								<?php foreach ( $item['blocks'] as $block ) : ?>
									<?php if ( isset( $block['p'] ) ) : ?>
										<p class="hotel-faq__p text-body"><?php echo esc_html( $block['p'] ); ?></p>
									<?php elseif ( isset( $block['ul'] ) && is_array( $block['ul'] ) ) : ?>
										<ul class="hotel-faq__list">
											<?php foreach ( $block['ul'] as $li ) : ?>
												<li class="hotel-faq__li text-body"><?php echo esc_html( $li ); ?></li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>
								<?php endforeach; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
