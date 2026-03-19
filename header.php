<?php
/**
 * Site header template.
 *
 * @package 360-hotelier
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', '360-hotelier' ); ?></a>

    <div class="top-bar">
        <div class="site-container top-bar__inner">
            <a href="mailto:info@360hotelier.com" class="top-bar__email">info@360hotelier.com</a>
            <a href="tel:+35770001818" class="top-bar__phone">7000 1818</a>
        </div>
    </div>

    <header id="masthead" class="site-header">
        <div class="site-container header-inner">

            <div class="site-branding">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-title-link site-logo-fallback" rel="home">
                        <img src="<?php echo esc_url( home_url( '/wp-content/uploads/2026/03/360-hotelier-logo-hd.svg' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                    </a>
                <?php endif; ?>
            </div>

            <nav id="primary-navigation" class="primary-navigation" aria-label="<?php esc_attr_e( 'Primary Menu', '360-hotelier' ); ?>">
                <?php wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'nav-menu text-body',
                    'container'      => false,
                    'fallback_cb'    => 'hotelier_default_nav_fallback',
                ) ); ?>

                <button
                    type="button"
                    class="mobile-nav-toggle"
                    aria-label="<?php esc_attr_e( 'Open menu', '360-hotelier' ); ?>"
                    aria-expanded="false"
                    aria-controls="mobile-nav"
                >
                    <span class="mobile-nav-toggle__line"></span>
                    <span class="mobile-nav-toggle__line"></span>
                    <span class="mobile-nav-toggle__line"></span>
                </button>
            </nav>

        </div>
    </header>

    <div id="mobile-nav" class="mobile-nav-overlay" aria-hidden="true">
        <div class="mobile-nav__content">
            <nav class="mobile-nav__menu" aria-label="<?php esc_attr_e( 'Mobile Menu', '360-hotelier' ); ?>">
                <?php wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'mobile-primary-menu',
                    'menu_class'     => 'mobile-nav__links',
                    'container'      => false,
                    'fallback_cb'    => 'hotelier_default_nav_fallback',
                ) ); ?>
            </nav>
        </div>
    </div>

