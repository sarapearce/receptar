<?php get_header(); ?>

<section id="blog-listing" class="site-content clearfix">
	
	<?php $index = 0; ?>
	<?php while ( have_posts() ) : the_post(); ?>
		
		<article class="post post-col-<?php echo $index%3; ?> post-col-two-<?php echo $index%2; ?> post-<?php echo ++$index; ?> clearfix">
			<div class="content">
				<h2 class="post-title">
					<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				</h2>
				<div class="body">
					<?php echo strip_tags(strip_shortcodes(get_the_content()), "<p>"); ?>
				</div>
			</div>
			<a href="<?php the_permalink(); ?>" class="read-more"><?php _e("Read More", "templaty"); ?></a>
		</article>
		
	<?php endwhile; ?>

    <div class="listing-pagination">
        <?php posts_nav_link(); ?>
    </div>

</section>

<?php get_footer(); ?>