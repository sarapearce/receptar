<?php get_header(); ?>
<?php if ( is_archive() ) : ?>
	<?php
		the_archive_title( '<h1 class="page-title">', '</h1>' );
		the_archive_description( '<div class="taxonomy-description">', '</div>' );
	?>
<?php elseif ( is_search() ) : ?>
	<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'dw-mono' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
<?php elseif ( is_home() && ! is_front_page() ) : ?>
	<h1 class="page-title"><?php single_post_title(); ?></h1>
<?php endif; ?>
<?php if ( have_posts() ) : ?>
	<main id="main" class="site-main" role="main">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php get_template_part( 'template-parts/content', get_post_format() ); ?>
	<?php endwhile; ?>
	</main>
	<?php dw_mono_posts_navigation(); ?>
<?php else : ?>
	<main id="main" class="site-main" role="main">
	<?php if ( is_404() ) : ?><h1 class="page-title"><?php _e( 'Nothing Found', 'dw-mono' ); ?></h1><?php endif; ?>
	<?php get_template_part( 'template-parts/content', 'none' ); ?>
	</main>
<?php endif; ?>
<?php get_footer(); ?>
