<?php
/**
 * 404 Not Found template.
 *
 * @package 360-hotelier
 */

get_header();

$h_404 = Hotelier_Site_Content_Options::get();
?>

<main id="main" class="site-main">
    <div class="site-container">

        <section class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title"><?php echo esc_html( $h_404['error_title'] ); ?></h1>
            </header>

            <div class="page-content">
                <p><?php echo esc_html( $h_404['error_text'] ); ?></p>
                <p>
                    <a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( $h_404['error_btn'] ); ?></a>
                </p>

                <?php get_search_form(); ?>
            </div>
        </section>

    </div>
</main>

<?php get_footer();
