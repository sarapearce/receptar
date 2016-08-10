<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner" style="background-image: url(<?php echo( esc_url( get_header_image() ) ); ?>)">
		<button type="button" data-toggle="offcanvas" class="navbar-toggle" data-target=".navmenu" data-canvas="body"><span class="sr-only"><?php _e( 'Toggle sidebar', 'dw-mono' ); ?></span><i class="fa fa-bars"></i></button>
		<div class="site-title">
			<div class="site-title-inner">
				<?php if ( is_single() ) : ?>
					<?php while ( have_posts() ) : the_post(); ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-brand">
							<?php $site_logo = dw_mono_get_theme_option('site_logo'); ?>
							<?php if( $site_logo ) : ?>
								<img src="<?php echo esc_url( $site_logo ); ?>" title="<?php bloginfo('name'); ?>">
							<?php else : ?>
								<?php _e( '<i class="fa fa-long-arrow-left"></i> Back to blog', 'dw-mono' ); ?>
							<?php endif; ?>
						</a>
						<h1><?php the_title(); ?></h1>
						<div class="entry-meta"><?php dw_mono_entry_meta(); ?></div>
					<?php endwhile; ?>
					<?php the_post_navigation(); ?>
				<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="site-brand">
					<?php $site_logo = dw_mono_get_theme_option('site_logo'); ?>
					<?php if( $site_logo ) : ?>
						<img src="<?php echo esc_url( $site_logo ); ?>" title="<?php bloginfo('name'); ?>">
					<?php endif; ?>
					<h1><?php bloginfo('name'); ?></h1>
				</a>
				<p><?php bloginfo('description'); ?></p>
				<?php endif; ?>
			</div>
		</div>
		<?php if ( dw_mono_get_theme_option( 'enable_overlay' ) ) : ?>
		<div class="header-overlay" style="opacity: <?php echo esc_attr( dw_mono_get_theme_option( 'overlay_opacity' ) ); ?>; background: <?php echo esc_attr( dw_mono_get_theme_option( 'overlay_color' ) ); ?>">
		</div>
		<?php endif; ?>
	</header>

	<div id="content-wrapper" class="site-content-wrapper">
		<div id="primary" class="content-area">
