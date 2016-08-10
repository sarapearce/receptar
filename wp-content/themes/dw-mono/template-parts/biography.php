<?php
/**
 * The template part for displaying an Author biography
 *
 * @package DW Mono
 * @since DW Mono 1.0.0
 */
?>

<div class="author-info">
	<div class="author-avatar">
		<?php
		$author_bio_avatar_size = apply_filters( 'dw_mono_author_bio_avatar_size', 64 );
		echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
		?>
	</div>

	<div class="author-description">
		<h2 class="author-title"><span class="author-heading"><?php _e( 'Author:', 'dw-mono' ); ?></span> <?php echo get_the_author(); ?></h2>

		<p class="author-bio">
			<?php the_author_meta( 'description' ); ?>
			<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php printf( __( 'View all posts by %s', 'dw-mono' ), get_the_author() ); ?>
			</a>
		</p>
	</div>
</div>
