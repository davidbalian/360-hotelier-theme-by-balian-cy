<?php
/**
 * Template part for displaying a message when no posts are found.
 *
 * @package 360-hotelier
 */
?>

<section class="no-results not-found">
    <header class="page-header">
        <h1 class="page-title"><?php esc_html_e( 'Nothing Found', '360-hotelier' ); ?></h1>
    </header>

    <div class="page-content">
        <?php if ( is_search() ) : ?>
            <p><?php esc_html_e( 'Sorry, nothing matched your search terms. Please try again with different keywords.', '360-hotelier' ); ?></p>
            <?php get_search_form(); ?>
        <?php else : ?>
            <p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for.', '360-hotelier' ); ?></p>
        <?php endif; ?>
    </div>
</section>
