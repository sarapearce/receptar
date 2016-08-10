<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php dw_mono_entry_meta(); ?>
		</div>
		<?php endif; ?>
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
	</header>
<?php if ( has_post_thumbnail() ) : ?>
	<div class="entry-thumbnail"><?php the_post_thumbnail(); ?></div>
<?php endif; ?>
	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'dw-mono' ) ); ?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'dw-mono' ),
				'after'  => '</div>',
			) );
		?>
	</div>
	<?php dw_mono_entry_footer(); ?>
</article>
