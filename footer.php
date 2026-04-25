<?php
/**
 * Site footer template.
 *
 * @package 360-hotelier
 */

$h_opt = Hotelier_Site_Content_Options::get();
$ft_tel = preg_replace( '/\s+/', '', (string) $h_opt['contact_phone_href'] );
if ( $ft_tel !== '' && strpos( $ft_tel, 'tel:' ) !== 0 ) {
	$ft_tel = 'tel:' . $ft_tel;
}

$hotelier_social = apply_filters(
	'hotelier_footer_social_links',
	array(
		'facebook'  => $h_opt['social_facebook'],
		'linkedin'  => $h_opt['social_linkedin'],
		'instagram' => $h_opt['social_instagram'],
	)
);
$hotelier_legal  = hotelier_get_footer_legal_urls();
$footer_icon_url = static function ( $file ) {
	return content_url( '/uploads/2026/04/' . ltrim( $file, '/' ) );
};
$fb_href  = ! empty( $hotelier_social['facebook'] ) ? $hotelier_social['facebook'] : '#';
$ig_href  = ! empty( $hotelier_social['instagram'] ) ? $hotelier_social['instagram'] : '#';
$li_href  = ! empty( $hotelier_social['linkedin'] ) ? $hotelier_social['linkedin'] : '#';
?>

    <footer id="colophon" class="site-footer">
        <div class="site-container">

            <div class="footer-cols">

                <div class="footer-col">
                    <p class="footer-col__heading text-xs fade-in fade-in-delay-0"><?php echo esc_html( $h_opt['footer_heading_nav'] ); ?></p>
                    <nav class="fade-in fade-in-delay-1" aria-label="<?php esc_attr_e( 'Footer Menu', '360-hotelier' ); ?>">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'footer',
                                'menu_id'        => 'footer-menu',
                                'menu_class'     => 'footer-nav-menu text-base-sm',
                                'container'      => false,
                                'depth'          => 1,
                                'fallback_cb'    => 'hotelier_default_nav_fallback',
                            )
                        );
                        ?>
                    </nav>
                </div>

                <div class="footer-col">
                    <p class="footer-col__heading text-xs fade-in fade-in-delay-0"><?php echo esc_html( $h_opt['footer_heading_legal'] ); ?></p>
                    <ul class="footer-legal text-base-sm">
                        <li class="fade-in fade-in-delay-1"><a href="<?php echo esc_url( $hotelier_legal['privacy'] ); ?>"><?php esc_html_e( 'Privacy Policy', '360-hotelier' ); ?></a></li>
                        <li class="fade-in fade-in-delay-2"><a href="<?php echo esc_url( $hotelier_legal['cookie'] ); ?>"><?php esc_html_e( 'Cookie Policy', '360-hotelier' ); ?></a></li>
                        <li class="fade-in fade-in-delay-3"><a href="<?php echo esc_url( $hotelier_legal['terms'] ); ?>"><?php esc_html_e( 'Terms', '360-hotelier' ); ?></a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <p class="footer-col__heading text-xs fade-in fade-in-delay-0"><?php echo esc_html( $h_opt['footer_heading_contact'] ); ?></p>
                    <ul class="footer-contact-details text-base-sm">
                        <li class="fade-in fade-in-delay-1"><a href="<?php echo esc_url( $ft_tel ); ?>"><?php echo esc_html( $h_opt['contact_phone_display'] ); ?></a></li>
                        <li class="fade-in fade-in-delay-2"><a href="<?php echo esc_url( 'mailto:' . antispambot( $h_opt['contact_email'] ) ); ?>"><?php echo esc_html( $h_opt['contact_email'] ); ?></a></li>
                        <li class="fade-in fade-in-delay-3"><?php echo esc_html( $h_opt['contact_address'] ); ?></li>
                    </ul>
                </div>

                <div class="footer-col footer-col--social-bubbles">
                    <p class="footer-col__heading text-xs fade-in fade-in-delay-0"><?php echo esc_html( $h_opt['footer_heading_follow'] ); ?></p>
                    <ul class="footer-social-bubbles" role="list">
                        <li class="fade-in fade-in-delay-1">
                            <a
                                class="footer-social-bubble"
                                href="<?php echo esc_url( $li_href ); ?>"
                                rel="noopener noreferrer"
                                target="_blank"
                            >
                                <span class="footer-social-bubble__icon" style="<?php echo esc_attr( '--footer-social-ico: url( ' . esc_url( $footer_icon_url( 'linkedin-icon.svg' ) ) . ' )' ); ?>"></span>
                                <span class="screen-reader-text"><?php esc_html_e( 'LinkedIn', '360-hotelier' ); ?></span>
                            </a>
                        </li>
                        <li class="fade-in fade-in-delay-2">
                            <a
                                class="footer-social-bubble"
                                href="<?php echo esc_url( $fb_href ); ?>"
                                rel="noopener noreferrer"
                                target="_blank"
                            >
                                <span class="footer-social-bubble__icon" style="<?php echo esc_attr( '--footer-social-ico: url( ' . esc_url( $footer_icon_url( 'facebook-icon.svg' ) ) . ' )' ); ?>"></span>
                                <span class="screen-reader-text"><?php esc_html_e( 'Facebook', '360-hotelier' ); ?></span>
                            </a>
                        </li>
                        <li class="fade-in fade-in-delay-3">
                            <a
                                class="footer-social-bubble"
                                href="<?php echo esc_url( $ig_href ); ?>"
                                rel="noopener noreferrer"
                                target="_blank"
                            >
                                <span class="footer-social-bubble__icon" style="<?php echo esc_attr( '--footer-social-ico: url( ' . esc_url( $footer_icon_url( 'instagram-icon.svg' ) ) . ' )' ); ?>"></span>
                                <span class="screen-reader-text"><?php esc_html_e( 'Instagram', '360-hotelier' ); ?></span>
                            </a>
                        </li>
                    </ul>
                </div>

            </div><!-- .footer-cols -->

            <div class="footer-logo fade-in fade-in-delay-0">
                <img src="<?php echo esc_url( Hotelier_Site_Content_Options::footer_logo_url() ); ?>" alt="<?php echo esc_attr( $h_opt['footer_copyright_name'] ); ?>" height="50" loading="eager" decoding="async">
            </div><!-- .footer-logo -->

            <div class="footer-bottom text-sm fade-in fade-in-delay-0">
                <span class="footer-copyright">
                    &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( $h_opt['footer_copyright_name'] ); ?> <?php echo esc_html( $h_opt['footer_rights'] ); ?>
                </span>
                <span class="footer-credit">
                    <?php echo wp_kses_post( $h_opt['footer_credit_html'] ); ?>
                </span>
            </div><!-- .footer-bottom -->

        </div><!-- .site-container -->
    </footer>

</div><!-- #page -->

<?php get_template_part( 'template-parts/components/cookie-banner' ); ?>

<?php wp_footer(); ?>
</body>
</html>
