<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width" />
	
	<?php if (get_phogra_theme_option('site_favicon')): ?>
		<link rel="shortcut icon" href="<?php echo get_phogra_theme_option('site_favicon'); ?>" />
	<?php endif; ?>
	
	<title><?php wp_title(); ?></title>
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5shiv.js" type="text/javascript"></script>
	<![endif]-->
	
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	
<!-- WEB PAGE -->
	<section id="page"<?php if (is_page_template('template-contact.php')): ?> class="full-size"<?php endif; ?>>
		
		<!-- SIDEBAR -->		
		<section id="sidebar">
			<a href="#" id="sidebar-trigger"><?php _e("Expand/Collapse", "templaty"); ?></a>
			
			<section class="sidebar-inside">
				<section class="sidebar-content">
	
					<!-- LOGO -->
					<h1 id="logo">
						<a href="<?php echo esc_url(home_url()); ?>">
							<span class="image">
								<?php if (get_phogra_theme_option('logo_image')): ?>
									<img src="<?php echo get_phogra_theme_option('logo_image'); ?>" alt="<?php bloginfo("title"); ?>" />
								<?php endif; ?>
							</span>
							<span class="text"><?php bloginfo("title"); ?></span>
						</a>
					</h1>
					<!-- END LOGO -->
					
					<!-- NAVIGATION -->
					<nav id="navigation" class="clearfix">
						<?php wp_nav_menu(array('theme_location' => 'header_menu', 'container' => false, 'menu_id' => 'navigation-menu', 'depth' => 1, 'link_before' => '&rsaquo; ')); ?>
					</nav>		
					<!-- END NAVIGATION -->
					
					<!-- FOOTER -->
					<footer id="footer" class="clearfix">
						
						<ul id="social-links" class="clearfix">
							<?php 
								$socialLinks = array( 
									"facebook" => "Facebook", 
									"twitter" => "Twitter",
									"flickr" => "Flickr", 
									"google" => "Google", 
									"rss" => "RSS",
									"dribble" => "Dribble", 
									"vimeo" => "Vimeo",
									"forrst" => "Forrst",
									"youtube" => "Youtube",
									"digg" => "Digg",
									"pinterest" => "Pinterest" 
								); 
							?>
							<?php foreach($socialLinks as $key => $value): ?>
								<?php $optionKey = sprintf("%s_link", $key); ?>
								<?php if (get_phogra_theme_option($optionKey)): ?>
									<li class="<?php echo $key; ?>">
										<?php printf('<a href="%s" target="_blank">Link</a>', get_phogra_theme_option($optionKey)); ?>
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
						
						<div class="copyright">
							<?php if (get_phogra_theme_option("site_copyright")): ?>
								<?php echo get_phogra_theme_option("site_copyright"); ?>
							<?php else: ?>
								<?php echo TemplatyThemeOptionsDefaults::Get("site_copyright"); ?>
							<?php endif; ?>
						</div>
					</footer>
					<!-- END FOOTER -->
					
				</section>
			</section>
		</section>
		<!-- END SIDEBAR -->
		
		<!-- CONTENT -->
		<section id="content">
