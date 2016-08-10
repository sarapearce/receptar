<?php /* Template Name: Contact */ ?>
<?php get_header(); ?>

    <?php if (get_phogra_theme_option("map_location")): ?>
        <div id="map-canvas"></div>
    <?php endif; ?>

	<?php while ( have_posts() ) : the_post(); ?>  	
	  	<section id="contact-content" class="clearfix">
	  		<?php the_content(); ?>
	  	</section>
  	<?php endwhile; ?>
			
<?php get_footer(); ?>
