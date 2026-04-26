<?php
/**
 * Page template: holds ACF fields for the public 404 template.
 *
 * Create one page in WordPress, assign this template, set visibility to Private,
 * and edit the 404 text (EN/EL) and hero image here. The page is not the public 404 URL.
 *
 * Template Name: 404 content (ACF)
 *
 * @package 360-hotelier
 */

get_header();
?>
<main id="main" class="site-main">
	<div class="site-container" style="padding:3rem 0;max-width:720px;">
		<p class="text-body"><?php esc_html_e( 'This page stores content for the website 404 error screen. It is not meant for visitors — keep it private or out of menus.', '360-hotelier' ); ?></p>
		<?php
		if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				the_content();
			}
		}
		?>
	</div>
</main>
<?php
get_footer();
