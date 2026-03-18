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
                    <h4 class="footer-col__heading text-xs"><?php esc_html_e( 'Navigation', '360-hotelier' ); ?></h4>
                    <nav aria-label="<?php esc_attr_e( 'Footer Menu', '360-hotelier' ); ?>">
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
                                'menu_id'   => 'footer-menu',
                            ) );
                        }
                        ?>
                    </nav>
                </div>

                <div class="footer-col">
                    <h4 class="footer-col__heading text-xs"><?php esc_html_e( 'Follow Us', '360-hotelier' ); ?></h4>
                    <ul class="footer-social text-base-sm">
                        <li><a href="#" rel="noopener noreferrer" target="_blank"><?php esc_html_e( 'Facebook', '360-hotelier' ); ?></a></li>
                        <li><a href="#" rel="noopener noreferrer" target="_blank"><?php esc_html_e( 'LinkedIn', '360-hotelier' ); ?></a></li>
                        <li><a href="#" rel="noopener noreferrer" target="_blank"><?php esc_html_e( 'Instagram', '360-hotelier' ); ?></a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4 class="footer-col__heading text-xs"><?php esc_html_e( 'Legal', '360-hotelier' ); ?></h4>
                    <ul class="footer-legal text-base-sm">
                        <li><a href="#"><?php esc_html_e( 'Privacy Policy', '360-hotelier' ); ?></a></li>
                        <li><a href="#"><?php esc_html_e( 'Cookie Policy', '360-hotelier' ); ?></a></li>
                        <li><a href="#"><?php esc_html_e( 'Terms', '360-hotelier' ); ?></a></li>
                    </ul>
                </div>

                <div class="footer-col">
                    <h4 class="footer-col__heading text-xs"><?php esc_html_e( 'Contact', '360-hotelier' ); ?></h4>
                    <ul class="footer-contact-details text-base-sm">
                        <li><a href="tel:+35770001818">7000 1818</a></li>
                        <li><a href="mailto:info@360hotelier.com">info@360hotelier.com</a></li>
                        <li>9, Epaminondou street, 3075, Limassol, Cyprus</li>
                    </ul>
                </div>

            </div><!-- .footer-cols -->

            <div class="footer-logo">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                    <img src="<?php echo esc_url( home_url( '/wp-content/uploads/2026/03/360-hotelier-logo-hd.svg' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                </a>
            </div><!-- .footer-logo -->

            <div class="footer-bottom text-sm">
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

        </div><!-- .site-container -->
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
