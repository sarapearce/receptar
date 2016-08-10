<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Dellow
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="parallax-bg"></div>
	  	
<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>
	
	<div id="top-bar">
	<div class="container">
	<?php if ( has_nav_menu('sliding') ) :  ?>
	<div class="col-md-1 menu-icon-container">
	<a id='main-menu' href="#sidr"><i class="icon-list menu-icon"> </i></a>
	</div>
	<?php endif; ?>
	<div id="top-search" class="col-md-5">
	<?php get_search_form(); ?>
	</div>
	
	<div id="social-icons" class="col-md-6">
			    <?php if ( of_get_option('facebook', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('facebook', true)); ?>" title="Facebook" ><i class="social-icon icon-facebook-sign"></i></a>
	             <?php } ?>
	            <?php if ( of_get_option('twitter', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url("http://twitter.com/".of_get_option('twitter', true)); ?>" title="Twitter" ><i class="social-icon icon-twitter-sign"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('google', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('google', true)); ?>" title="Google Plus" ><i class="social-icon icon-google-plus-sign"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('feedburner', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('feedburner', true)); ?>" title="RSS Feeds" ><i class="social-icon icon-rss-sign"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('pinterest', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('pinterest', true)); ?>" title="Pinterest" ><i class="social-icon icon-pinterest-sign"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('instagram', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('instagram', true)); ?>" title="Instagram" ><i class="social-icon icon-instagram"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('linkedin', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('linkedin', true)); ?>" title="LinkedIn" ><i class="social-icon icon-linkedin-sign"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('youtube', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('youtube', true)); ?>" title="YouTube" ><i class="social-icon icon-youtube-sign"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('tumblr', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('tumblr', true)); ?>" title="Tumblr" ><i class="social-icon icon-tumblr-sign"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('flickr', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('flickr', true)); ?>" title="Flickr" ><i class="social-icon icon-flickr"></i></a>
	             <?php } ?>
	             <?php if ( of_get_option('dribble', true) != "") { ?>
				 <a target="_blank" href="<?php echo esc_url(of_get_option('dribble', true)); ?>" title="Dribbble" ><i class="social-icon icon-dribbble"></i></a>
	             <?php } ?>
         
	</div>
	
	</div>
	</div><!--#top-bar-->
	<header id="masthead" class="site-header row container" role="banner">
		<div class="site-branding col-md-12">
		<?php if((of_get_option('logo', true) != "") && (of_get_option('logo', true) != 1) ) { ?>
			<h1 class="site-title logo-container"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
			<?php
			echo "<img class='main_logo' src='".of_get_option('logo', true)."' title='".esc_attr(get_bloginfo( 'name','display' ) )."'></a></h1>";	
			}
		else { ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1> 
			<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
		<?php	
		}
		?>
		</div>
		
	</header><!-- #masthead -->
	
	<div id="primary-navigation" class="container">
		<nav id="navigation-2" class="primary-navigation" role="navigation">
	       <div id="primary-nav-container">		
				<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
	       </div>  
		</nav><!-- #site-navigation -->
	</div>		

	<?php
			if ( of_get_option('slide1',true) == 1 ) :
				 get_template_part('defaults/slider');
			else :
				get_template_part('slider', 'nivo');
			endif; ?>
			
		<?php //if ( has_nav_menu('sliding') ) :  ?>
		<div id="sidr" class="default-nav-wrapper"> 	
		   <nav id="site-navigation" class="main-navigation" role="navigation">
		       <div id="nav-container">		
					<?php wp_nav_menu( array( 'theme_location' => 'sliding' ) ); ?>
		       </div>  
			</nav><!-- #site-navigation -->
		</div>
		<?php //endif; ?>
		
		<div id="content" class="site-content row">
		<div class="container col-md-12"> 
