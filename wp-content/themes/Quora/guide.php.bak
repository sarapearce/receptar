<?php
function theme_guide(){
add_theme_page( 'Theme guide','Theme documentation','edit_themes', 'theme-documentation', 'w2f_theme_guide');
}
add_action('admin_menu', 'theme_guide');

function w2f_theme_guide(){
		echo '
		
<div id="welcome-panel" class="about-wrap">

	<div class="wpbadge" style="float:left; margin-right:30px; "><img src="'. get_template_directory_uri() . '/screenshot.png" width="250" height="200" /></div>

	<div class="welcome-panel-content">
	
	<h1>Welcome to '.wp_get_theme().' WordPress theme!</h1>
	
	<p class="about-text"> '.wp_get_theme().' is a free premium WordPress theme. This is a WordPress 3+ ready theme with features like custom menu, featured images, widgetized sidebar etc. Theme also comes with an option panel. The homepage of the theme has a customizable jQuery content slider. </p>
	
		

		<div class="changelog ">
		<h3>Required plugins </h3>
		<p>The theme often requires few plugins to work the way it is originally intented to. You will find a notification on the admin panel prompting you to install the required plugins. Please install and activate the plugins.  </p>
		<ol>
			<li><a href="http://wordpress.org/extend/plugins/options-framework/">Options framework</a></li>
		</ol>
		</div>
	
	
		<div class="changelog ">
		
		<h3>Theme options explained</h3>
		<p>The theme contains an options page using which you adjust various settings available on the theme. </p>
		
		<p><b>Logo:</b>
		You can upload a custom logo image via the theme options.</p>
		
		<p><b>Slider setting:</b>
		There is a jQuery slider on the homepage of the theme You can use the slider to display the featured images from a selected category. From the theme options page you can select a category and the number of slides to be displayed.</p>


		<p><b>Banner setting:</b>
		Configure the banner ads on the sidebar </p>

		</div>
	


				
		<div class="changelog ">
		<h3>Theme License </h3>
		<p>	The PHP code of the theme is licensed under the GPL license as is WordPress itself. You can read it here: http://codex.wordpress.org/GPL.All other parts of the theme including, but not limited to the CSS code, images, and design are licensed for free personal usage. </p>
		<ul>
		<li> You are requested to retain the credit banners on the template.</li>
		<li> You are allowed to use the theme on multiple installations, and to edit the template for your personal/client use.</li>
		<li> You are NOT allowed to edit the theme or change its form with the intention to resell or redistribute it. </li>
		<li> You are NOT allowed to use the theme as a part of a template repository for any paid CMS service.</li>
		</ul>
	</div>
	
				

	<p class="welcome-panel-dismiss">WordPress theme designed by <a href="http://www.web2feel.com">web2feel.com</a>.</p>

	</div>
	</div>
		
		';
		

}