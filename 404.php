<?php
/**
 * 404 Not Found template.
 *
 * @package 360-hotelier
 */

get_header(); ?>

<main id="main" class="site-main">
    <div class="site-container">

        <section class="error-404 not-found">
            <header class="page-header">
                <h1 class="page-title text-3xl"><?php esc_html_e( '404 — Page Not Found', '360-hotelier' ); ?></h1>
            </header>

            <div class="page-content">
                <p><?php esc_html_e( 'It looks like nothing was found at this location.', '360-hotelier' ); ?></p>

                <?php get_search_form(); ?>
            </div>
        </section>

    </div>
</main>

<?php get_footer();
