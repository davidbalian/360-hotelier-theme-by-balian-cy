<?php
/**
 * Site footer template.
 *
 * @package 360-hotelier
 */
?>

    <footer id="colophon" class="site-footer">
        <div class="site-container footer-inner">

            <nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Menu', '360-hotelier' ); ?>">
                <?php
                if ( has_nav_menu( 'footer' ) ) {
                    wp_nav_menu( array(
                        'theme_location' => 'footer',
                        'menu_id'        => 'footer-menu',
                        'menu_class'     => 'footer-nav-menu',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ) );
                } else {
                    hotelier_default_nav_fallback( array(
                        'menu_class' => 'footer-nav-menu',
                        'menu_id'   => 'footer-menu',
                    ) );
                }
                ?>
            </nav>

            <div class="footer-social">
                <a href="#" rel="noopener noreferrer" target="_blank" aria-label="<?php esc_attr_e( 'Facebook', '360-hotelier' ); ?>"><?php esc_html_e( 'Facebook', '360-hotelier' ); ?></a>
                <a href="#" rel="noopener noreferrer" target="_blank" aria-label="<?php esc_attr_e( 'LinkedIn', '360-hotelier' ); ?>"><?php esc_html_e( 'LinkedIn', '360-hotelier' ); ?></a>
                <a href="#" rel="noopener noreferrer" target="_blank" aria-label="<?php esc_attr_e( 'Instagram', '360-hotelier' ); ?>"><?php esc_html_e( 'Instagram', '360-hotelier' ); ?></a>
            </div>

            <div class="footer-legal">
                <a href="#"><?php esc_html_e( 'Privacy Policy', '360-hotelier' ); ?></a>
                <a href="#"><?php esc_html_e( 'Cookie Policy', '360-hotelier' ); ?></a>
                <a href="#"><?php esc_html_e( 'Terms', '360-hotelier' ); ?></a>
            </div>

            <div class="site-info">
                <span class="copyright">
                    &copy; 2026 360° Hotelier Consulting. <?php esc_html_e( 'All Rights Reserved.', '360-hotelier' ); ?>
                </span>
                <span class="credit">
                    <?php
                    printf(
                        /* translators: %s: agency link */
                        esc_html__( 'Designed by %s', '360-hotelier' ),
                        '<a href="https://balian.cy/" rel="noopener noreferrer" target="_blank">Balian Web Development Co.</a>'
                    );
                    ?>
                </span>
            </div>

        </div>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
