<?php
/**
 * Site footer template.
 *
 * @package 360-hotelier
 */
?>

    <footer id="colophon" class="site-footer">
        <div class="site-container footer-inner">

            <?php if ( has_nav_menu( 'footer' ) ) : ?>
                <nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer Menu', '360-hotelier' ); ?>">
                    <?php wp_nav_menu( array(
                        'theme_location' => 'footer',
                        'menu_id'        => 'footer-menu',
                        'menu_class'     => 'footer-nav-menu',
                        'container'      => false,
                        'depth'          => 1,
                        'fallback_cb'    => false,
                    ) ); ?>
                </nav>
            <?php endif; ?>

            <div class="site-info">
                <span class="copyright">
                    &copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                </span>
                <span class="credit">
                    <?php
                    printf(
                        /* translators: %s: agency link */
                        esc_html__( 'Designed by %s', '360-hotelier' ),
                        '<a href="https://balianwebdev.com" rel="noopener noreferrer" target="_blank">Balian Web Development Co.</a>'
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
