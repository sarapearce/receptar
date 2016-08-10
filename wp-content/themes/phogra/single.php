<?php get_header(); ?>

<section id="blog-listing" class="site-content clearfix">
	
	<section class="site-main">
		<?php while ( have_posts() ) : the_post(); ?>
			<article class="post post-1 post-single">
				<div class="content" <?php post_class(); ?>>
					<h2 class="post-title"><?php the_title(); ?></h2>
					<div class="post-tags">
						<?php the_tags(); ?>
					</div>
                    <?php if ( has_post_thumbnail() ): ?>
                        <figure class="post-featured-image">
                            <?php the_post_thumbnail('large-featured'); ?>
                        </figure>
                    <?php endif; ?>
					<div class="body">
						<?php the_content(); ?>
					</div>

                    <div class="post-pages">
                        <?php wp_link_pages(); ?>
                    </div>
				</div>
			</article>

			<?php comments_template( '', true ); ?>
			
		<?php endwhile; ?>
		
		
	</section>
	
	<section class="site-side">
		
		<?php query_posts("posts_per_page=10"); ?>
		<?php while ( have_posts() ) : the_post(); ?>
		
			<article class="post post-col-2">
				<div class="content">
					<h2 class="post-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>
					<div class="body">
						<?php echo strip_tags(get_the_content(), "<p>"); ?>
					</div>
				</div>
				<a href="<?php the_permalink(); ?>" class="read-more"><?php _e("Read More", "templaty"); ?></a>
			</article>
			
		<?php endwhile; ?>
		
	</section>
	
</section>

<?php get_footer(); ?>
