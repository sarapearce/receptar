<?php get_header(); ?>
<main id="main" class="site-main" role="main">
<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-social">
			<?php if ( function_exists('dw_social_share') ) { dw_social_share(); } ?>
		</div>
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . __( 'Pages:', 'dw-mono' ),
					'after'  => '</div>',
				) );
			?>
		</div>
		<?php dw_mono_entry_footer(); ?>
	</article>

	<?php if ( '' !== get_the_author_meta( 'description' ) ) { get_template_part( 'template-parts/biography' ); } ?>

	<?php
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
	?>
<?php endwhile; ?>
</main>
<?php get_footer(); ?>
