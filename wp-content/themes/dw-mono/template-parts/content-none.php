<?php
/**
 * The template part for displaying a message that posts cannot be found
 *
 * @package DW Mono
 * @since DW Mono 1.0
 */
?>
<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
	<div class="alert alert-info"><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'dw-mono' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></div>
<?php elseif ( is_search() ) : ?>
	<div class="alert alert-info"><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'dw-mono' ); ?></div>
	<?php get_search_form(); ?>
<?php else : ?>
	<div class="alert alert-info"><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'dw-mono' ); ?></div>
	<?php get_search_form(); ?>
<?php endif; ?>
