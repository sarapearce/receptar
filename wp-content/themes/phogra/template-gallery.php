<?php /* Template Name: Gallery */ ?>
<?php get_header(); ?>

	<?php query_posts('posts_per_page=-1&post_type=page&orderby=menu_order&order=ASC&post_parent=' . get_queried_object_id()); ?>

	<section id="albums-list" class="clearfix">
		<?php while ( have_posts() ) : the_post(); ?>

			<article class="album">
				<a href="<?php the_permalink(); ?>">
					<?php if (has_post_thumbnail()): ?>
						<?php the_post_thumbnail(); ?>
					<?php endif; ?>
					<span class="mask"></span>
					<span class="plus">+</span>
					<span class="album-name"><?php the_title(); ?></span>
				</a>
			</article>

		<?php endwhile; ?>
	</section>

<?php get_footer(); ?>