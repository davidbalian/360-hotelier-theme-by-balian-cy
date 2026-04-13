<?php
/**
 * Front page "Meet the Founder" section.
 *
 * Optional: hide_about_cta via get_template_part( …, array( 'hide_about_cta' => true ) ),
 * or global $hotelier_section_founder_hide_about_cta (e.g. About page). When hidden, a
 * link to the Founder page is shown instead (label: founder_profile_cta_text on the home context).
 * Optional: founder_content_post_id — post ID whose home-context founder fields to use (default: static front page).
 *
 * @package 360-hotelier
 */

global $hotelier_section_founder_hide_about_cta;
$hide_about_cta = ( isset( $hide_about_cta ) ? (bool) $hide_about_cta : false )
	|| ! empty( $hotelier_section_founder_hide_about_cta );

$founder_pid = isset( $founder_content_post_id ) ? (int) $founder_content_post_id : Hotelier_Page_Content::front_page_id();
if ( $founder_pid <= 0 ) {
	$founder_pid = (int) get_queried_object_id();
}

$hctx         = 'home';
$about_url    = hotelier_get_page_url_by_slug( 'about-us' );
$founder_url  = hotelier_get_page_url_by_slug( 'founder' );
$photo        = Hotelier_Page_Content::get_image_url( $founder_pid, $hctx, 'founder_photo' );
$profile_cta  = Hotelier_Page_Content::get_text( $founder_pid, $hctx, 'founder_profile_cta_text' );
?>
<section class="front-founder">
    <div class="site-container front-founder__inner">
        <div class="front-founder__image fade-in fade-in-delay-0">
            <img class="front-founder__photo" src="<?php echo esc_url( $photo ); ?>" alt="<?php echo esc_attr( Hotelier_Page_Content::get_text( $founder_pid, $hctx, 'founder_photo_alt' ) ); ?>" loading="lazy" />
        </div>
        <div class="front-founder__card card-border">
        <div class="front-founder__content">
            <h2 class="front-founder__heading fade-in fade-in-delay-1"><?php echo esc_html( Hotelier_Page_Content::get_text( $founder_pid, $hctx, 'founder_heading' ) ); ?></h2>
            <h3 class="front-founder__name fade-in fade-in-delay-2"><?php echo esc_html( Hotelier_Page_Content::get_text( $founder_pid, $hctx, 'founder_name' ) ); ?></h3>
            <p class="fade-in fade-in-delay-3"><?php echo esc_html( Hotelier_Page_Content::get_text( $founder_pid, $hctx, 'founder_p1' ) ); ?></p>
            <p class="fade-in fade-in-delay-4"><?php echo esc_html( Hotelier_Page_Content::get_text( $founder_pid, $hctx, 'founder_p2' ) ); ?></p>
            <ul class="front-founder__points">
                <?php for ( $i = 1; $i <= 4; $i++ ) : ?>
                <li class="fade-in fade-in-delay-<?php echo esc_attr( (string) ( $i + 4 ) ); ?>">
                    <?php Hotelier_Lucide_Icon::render( 'check', 'front-founder__point-icon' ); ?>
                    <span class="front-founder__point-text"><?php echo esc_html( Hotelier_Page_Content::get_text( $founder_pid, $hctx, 'founder_pt_' . $i ) ); ?></span>
                </li>
                <?php endfor; ?>
            </ul>
            <?php Hotelier_Founder_Card_Contact::render(); ?>
            <?php if ( ! $hide_about_cta ) : ?>
            <a href="<?php echo esc_url( $about_url ); ?>" class="btn btn--primary front-founder__cta fade-in fade-in-delay-9"><?php echo esc_html( Hotelier_Page_Content::get_text( $founder_pid, $hctx, 'founder_cta_text' ) ); ?></a>
            <?php elseif ( $founder_url !== '' ) : ?>
            <a href="<?php echo esc_url( $founder_url ); ?>" class="btn btn--primary front-founder__cta fade-in fade-in-delay-9"><?php echo esc_html( $profile_cta ); ?></a>
            <?php endif; ?>
        </div>
        </div>
    </div>
</section>
