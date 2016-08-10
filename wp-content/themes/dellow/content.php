<?php
/**
 * @package Dellow
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class("row archive"); ?>>
	<?php if (has_post_thumbnail()) :
		if (of_get_option('sidebar-layout',true) == 'full') { ?>
			<div class="featured-thumb col-md-3 col-xs-8 col-sm-2"> <?php
		}
		else { ?>
			<div class="featured-thumb col-md-4 col-xs-8 col-sm-2"> <?php
		} ?>
			<div class="img-meta">
				<div class="img-meta-link meta-icon"><a class='meta-link' href="<?php the_permalink() ?>"><i class="icon-link"></i></a></div>
					<?php	$thumb_id = get_post_thumbnail_id();
							$thumb_url = wp_get_attachment_image_src($thumb_id,'full', true);
				?>
				<div class="img-meta-img meta-icon"><a class='meta-link meta-link-img' title="<?php the_title(); ?>" href="<?php echo $thumb_url[0] ?>"><i class="icon-picture"></i></a></div>
			</div>
			<a href="<?php the_permalink(); ?>">
			<?php if (has_post_thumbnail()) :
				the_post_thumbnail('homepage-banner');	
			endif; 
			?>
			</a>
			</div>
	<?php endif; ?>
	<?php if (has_post_thumbnail()) { 
		if (of_get_option('sidebar-layout',true) == 'full') { ?>
			<div class="article-rest col-md-9 col-sm-10"> <?php
		}
		else { ?>
			<div class="article-rest col-md-8 col-sm-10"> <?php
		} ?>
	<?php } else { ?>
			<div class="article-rest col-md-12">
	<?php } ?>
	<header class="entry-header">
		<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>

		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php dellow_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
	<div class="entry-content">
	<?php if ( of_get_option('excerpt1', true) == 0 ) : ?>
		<?php the_content( __( 'Contine reading <span class="meta-nav">&rarr;</span>', 'dellow' ) ); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages: ', 'dellow' ),
				'after'  => '</div>',
			) );
		else :
			the_excerpt();
		endif;		
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>
	</div>
</article><!-- #post-## -->