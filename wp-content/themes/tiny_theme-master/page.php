<?php get_header() ?>
<div class="container">
		<header class="title">
			<h2><?php the_title() ?></h2>
		</header>
		<?php while ( have_posts() ) : the_post(); ?>
	
		<div class="post">	
				<article>
					<?php the_content() ?>
				</article>
				<div class="share">
					<ul>
						
						<li>
    						<a target="_blank" href="https://plus.google.com/+charlespearce" title="Google+">
								<i class="icon-google-plus"></i>
							</a>
						</li>
						
					</ul>
				</div>
				<?php endwhile; ?>
			</div>
		
	</div>	
	
<?php get_footer() ?>