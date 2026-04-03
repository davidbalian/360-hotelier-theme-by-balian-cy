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

    <?php
	$h_site = Hotelier_Site_Content_Options::get();
	$tb_tel = preg_replace( '/\s+/', '', (string) $h_site['topbar_phone_href'] );
	if ( $tb_tel !== '' && strpos( $tb_tel, 'tel:' ) !== 0 ) {
		$tb_tel = 'tel:' . $tb_tel;
	}
	?>
    <div class="top-bar">
        <div class="site-container top-bar__inner">
            <a href="<?php echo esc_url( 'mailto:' . antispambot( $h_site['topbar_email'] ) ); ?>" class="top-bar__email"><?php echo esc_html( $h_site['topbar_email'] ); ?></a>
            <a href="<?php echo esc_url( $tb_tel ); ?>" class="top-bar__phone"><?php echo esc_html( $h_site['topbar_phone_display'] ); ?></a>
        </div>
    </div>

    <header id="masthead" class="site-header">
        <div class="site-container header-inner">

            <div class="site-branding">
                <?php if ( has_custom_logo() ) : ?>
                    <?php hotelier_output_custom_logo_link(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url( hotelier_get_localized_home_url() ); ?>" class="site-title-link site-logo-fallback" rel="home">
                        <img src="<?php echo esc_url( Hotelier_Site_Content_Options::footer_logo_url() ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="180" height="50">
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
                    'walker'         => new Hotelier_Primary_Nav_Walker(),
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
                    'walker'         => new Hotelier_Primary_Nav_Walker(),
                ) ); ?>
            </nav>
        </div>
    </div>

