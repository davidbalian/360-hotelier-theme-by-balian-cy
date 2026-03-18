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
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="screen-reader-text"><?php esc_html_e( 'Menu', '360-hotelier' ); ?></span>
                    <span class="menu-toggle-bar"></span>
                    <span class="menu-toggle-bar"></span>
                    <span class="menu-toggle-bar"></span>
                </button>

                <?php wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'menu_class'     => 'nav-menu text-body',
                    'container'      => false,
                    'fallback_cb'    => 'hotelier_default_nav_fallback',
                ) ); ?>
            </nav>

        </div>
    </header>
