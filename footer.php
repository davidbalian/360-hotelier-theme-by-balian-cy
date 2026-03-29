<?php
/**
 * Site footer template.
 *
 * @package 360-hotelier
 */
?>

    <footer id="colophon" class="site-footer">
        <div class="site-container">

            <div class="footer-cols">

                <div class="footer-col">
                    <p class="footer-col__heading text-xs fade-in fade-in-delay-0"><?php esc_html_e( 'Navigation', '360-hotelier' ); ?></p>
                    <nav class="fade-in fade-in-delay-1" aria-label="<?php esc_attr_e( 'Footer Menu', '360-hotelier' ); ?>">
                        <?php
                        if ( has_nav_menu( 'footer' ) ) {
                            wp_nav_menu( array(
                                'theme_location' => 'footer',
                                'menu_id'        => 'footer-menu',
                                'menu_class'     => 'footer-nav-menu text-base-sm',
                                'container'      => false,
                                'depth'          => 1,
                                'fallback_cb'    => false,
                            ) );
                        } else {
                            hotelier_default_nav_fallback( array(
                                'menu_class' => 'footer-nav-menu text-base-sm',
                                'menu_id'    => 'footer-menu',
                                'depth'      => 1,
                            ) );
                        }
                        ?>
                    </nav>
                </div>

                <?php
                $hotelier_social = apply_filters(
                    'hotelier_footer_social_links',
                    array(
                        'facebook'  => '',
                        'linkedin'  => '',
                        'instagram' => '',
                    )
                );
                $hotelier_legal = hotelier_get_footer_legal_urls();
                ?>
                <div class="footer-col">
                    <p class="footer-col__heading text-xs fade-in fade-in-delay-0"><?php esc_html_e( 'Follow Us', '360-hotelier' ); ?></p>
                    <ul class="footer-social text-base-sm">
                        <li class="fade-in fade-in-delay-1"><a href="<?php echo esc_url( ! empty( $hotelier_social['facebook'] ) ? $hotelier_social['facebook'] : '#' ); ?>" rel="noopener noreferrer" target="_blank"><?php esc_html_e( 'Facebook', '360-hotelier' ); ?></a></li>
                        <li class="fade-in fade-in-delay-2"><a href="<?php echo esc_url( ! empty( $hotelier_social['linkedin'] ) ? $hotelier_social['linkedin'] : '#' ); ?>" rel="noopener noreferrer" target="_blank"><?php esc_html_e( 'LinkedIn', '360-hotelier' ); ?></a></li>
                        <li class="fade-in fade-in-delay-3"><a href="<?php echo esc_url( ! empty( $hotelier_social['instagram'] ) ? $hotelier_social['instagram'] : '#' ); ?>" rel="noopener noreferrer" target="_blank"><?php esc_html_e( 'Instagram', '360-hotelier' ); ?></a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <p class="footer-col__heading text-xs fade-in fade-in-delay-0"><?php esc_html_e( 'Legal', '360-hotelier' ); ?></p>
                    <ul class="footer-legal text-base-sm">
                        <li class="fade-in fade-in-delay-1"><a href="<?php echo esc_url( $hotelier_legal['privacy'] ); ?>"><?php esc_html_e( 'Privacy Policy', '360-hotelier' ); ?></a></li>
                        <li class="fade-in fade-in-delay-2"><a href="<?php echo esc_url( $hotelier_legal['cookie'] ); ?>"><?php esc_html_e( 'Cookie Policy', '360-hotelier' ); ?></a></li>
                        <li class="fade-in fade-in-delay-3"><a href="<?php echo esc_url( $hotelier_legal['terms'] ); ?>"><?php esc_html_e( 'Terms', '360-hotelier' ); ?></a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <p class="footer-col__heading text-xs fade-in fade-in-delay-0"><?php esc_html_e( 'Contact', '360-hotelier' ); ?></p>
                    <ul class="footer-contact-details text-base-sm">
                        <li class="fade-in fade-in-delay-1"><a href="tel:+35770001818">7000 1818</a></li>
                        <li class="fade-in fade-in-delay-2"><a href="mailto:info@360hotelier.com">info@360hotelier.com</a></li>
                        <li class="fade-in fade-in-delay-3">9, Epaminondou street, 3075, Limassol, Cyprus</li>
                    </ul>
                </div>

            </div><!-- .footer-cols -->

            <div class="footer-bottom text-sm fade-in fade-in-delay-0">
                <span class="footer-copyright">
                    &copy; <?php echo esc_html( date( 'Y' ) ); ?> 360&deg; Hotelier Consulting. <?php esc_html_e( 'All Rights Reserved.', '360-hotelier' ); ?>
                </span>
                <span class="footer-credit">
                    <?php
                    printf(
                        /* translators: %s: agency link */
                        esc_html__( 'Designed by %s', '360-hotelier' ),
                        '<a href="https://balian.cy/" rel="noopener noreferrer" target="_blank">Balian Web Development Co.</a>'
                    );
                    ?>
                </span>
            </div><!-- .footer-bottom -->

            <div class="footer-logo fade-in fade-in-delay-1" aria-hidden="true">
                <img src="<?php echo esc_url( content_url( '/uploads/2026/03/360-hotelier-logo-hd.svg' ) ); ?>" alt="" width="180" height="50">
            </div><!-- .footer-logo -->

        </div><!-- .site-container -->
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
