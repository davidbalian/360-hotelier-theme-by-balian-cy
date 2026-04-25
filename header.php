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

	$tb_current_lang   = Hotelier_Locale_Detector::current_lang();
	$tb_inactive_lang  = Hotelier_Locale_Registry::GREEK_LANG === $tb_current_lang
		? Hotelier_Locale_Registry::DEFAULT_LANG
		: Hotelier_Locale_Registry::GREEK_LANG;
	$tb_inactive_label = Hotelier_Locale_Registry::GREEK_LANG === $tb_inactive_lang ? 'ΕΛ' : 'EN';
	$tb_inactive_url   = esc_url( Hotelier_Local_Urls::lang_url( $tb_inactive_lang ) );
	$topbar_icon        = static function ( $file ) {
		return content_url( '/uploads/2026/04/' . ltrim( $file, '/' ) );
	};
	$tb_fb_href  = ! empty( $h_site['social_facebook'] ) ? $h_site['social_facebook'] : '#';
	$tb_ig_href  = ! empty( $h_site['social_instagram'] ) ? $h_site['social_instagram'] : '#';
	$tb_li_href  = ! empty( $h_site['social_linkedin'] ) ? $h_site['social_linkedin'] : '#';
	$tb_mail     = 'mailto:' . antispambot( $h_site['topbar_email'] );
	?>
    <div class="top-bar">
        <div class="site-container top-bar__inner">

            <div class="top-bar__left">
                <nav class="top-bar__icons" aria-label="<?php esc_attr_e( 'Contact and social links', '360-hotelier' ); ?>">
                    <a
                        class="top-bar__icon-link"
                        href="<?php echo esc_url( $tb_fb_href ); ?>"
                        rel="noopener noreferrer"
                        target="_blank"
                    >
                        <span class="top-bar__icon" style="<?php echo esc_attr( '--top-bar-ico: url( ' . esc_url( $topbar_icon( 'facebook-icon.svg' ) ) . ' )' ); ?>"></span>
                        <span class="screen-reader-text"><?php esc_html_e( 'Facebook', '360-hotelier' ); ?></span>
                    </a>
                    <a
                        class="top-bar__icon-link"
                        href="<?php echo esc_url( $tb_ig_href ); ?>"
                        rel="noopener noreferrer"
                        target="_blank"
                    >
                        <span class="top-bar__icon" style="<?php echo esc_attr( '--top-bar-ico: url( ' . esc_url( $topbar_icon( 'instagram-icon.svg' ) ) . ' )' ); ?>"></span>
                        <span class="screen-reader-text"><?php esc_html_e( 'Instagram', '360-hotelier' ); ?></span>
                    </a>
                    <a
                        class="top-bar__icon-link"
                        href="<?php echo esc_url( $tb_li_href ); ?>"
                        rel="noopener noreferrer"
                        target="_blank"
                    >
                        <span class="top-bar__icon" style="<?php echo esc_attr( '--top-bar-ico: url( ' . esc_url( $topbar_icon( 'linkedin-icon.svg' ) ) . ' )' ); ?>"></span>
                        <span class="screen-reader-text"><?php esc_html_e( 'LinkedIn', '360-hotelier' ); ?></span>
                    </a>
                    <a class="top-bar__icon-link" href="<?php echo esc_url( $tb_mail ); ?>">
                        <span class="top-bar__icon" style="<?php echo esc_attr( '--top-bar-ico: url( ' . esc_url( $topbar_icon( 'mail-icon.svg' ) ) . ' )' ); ?>"></span>
                        <span class="screen-reader-text"><?php esc_html_e( 'Email', '360-hotelier' ); ?></span>
                    </a>
                <?php if ( $h_site['topbar_phone_display'] ) : ?>
                    <a class="top-bar__icon-link" href="<?php echo esc_url( $tb_tel ); ?>">
                        <span class="top-bar__icon" style="<?php echo esc_attr( '--top-bar-ico: url( ' . esc_url( $topbar_icon( 'phone-icon.svg' ) ) . ' )' ); ?>"></span>
                        <span class="screen-reader-text"><?php esc_html_e( 'Phone', '360-hotelier' ); ?></span>
                    </a>
                <?php endif; ?>
                </nav>
                <a href="<?php echo esc_url( 'mailto:' . antispambot( $h_site['topbar_email'] ) ); ?>" class="top-bar__email"><?php echo esc_html( $h_site['topbar_email'] ); ?></a>
                <?php if ( $h_site['topbar_phone_display'] ) : ?>
                    <a href="<?php echo esc_url( $tb_tel ); ?>" class="top-bar__phone"><?php echo esc_html( $h_site['topbar_phone_display'] ); ?></a>
                <?php endif; ?>
                <div class="top-bar__social">
                    <a href="<?php echo esc_url( ! empty( $h_site['social_facebook'] ) ? $h_site['social_facebook'] : '#' ); ?>" class="top-bar__social-link" rel="noopener noreferrer" target="_blank">Facebook</a>
                    <a href="<?php echo esc_url( ! empty( $h_site['social_linkedin'] ) ? $h_site['social_linkedin'] : '#' ); ?>" class="top-bar__social-link" rel="noopener noreferrer" target="_blank">LinkedIn</a>
                    <a href="<?php echo esc_url( ! empty( $h_site['social_instagram'] ) ? $h_site['social_instagram'] : '#' ); ?>" class="top-bar__social-link" rel="noopener noreferrer" target="_blank">Instagram</a>
                </div>
            </div>

            <a href="<?php echo $tb_inactive_url; ?>" class="top-bar__lang-switcher">
                <?php echo esc_html( $tb_inactive_label ); ?>
            </a>

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

