<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 */
function optionsframework_option_name() {

	// This gets the theme name from the stylesheet
	$themename = wp_get_theme();
	$themename = preg_replace("/\W/", "_", strtolower($themename) );

	$optionsframework_settings = get_option( 'optionsframework' );
	$optionsframework_settings['id'] = $themename;
	update_option( 'optionsframework', $optionsframework_settings );
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the 'id' fields, make sure to use all lowercase and no spaces.
 *
 * If you are making your theme translatable, you should replace 'dellow'
 * with the actual text domain for your theme.  Read more:
 * http://codex.wordpress.org/Function_Reference/load_theme_textdomain
 */

function optionsframework_options() {

	$options = array();
	$imagepath =  get_template_directory_uri() . '/images/';
	
	//Basic Settings
	
	$options[] = array(
		'name' => __('Basic Settings', 'dellow'),
		'type' => 'heading');
			
	$options[] = array(
		'name' => __('Site Logo', 'dellow'),
		'desc' => __('Leave Blank to use text Heading.', 'dellow'),
		'id' => 'logo',
		'class' => '',
		'type' => 'upload');	

	$options[] = array(
		'name' => __('Custom Code in Header', 'dellow'),
		'desc' => __('Insert scripts or code before the closing &lt;/head&gt; tag in the document source:', 'dellow'),
		'id' => 'headcode1',
		'std' => '',
		'type' => 'textarea');
		
	$options[] = array(
		'name' => __('Custom Code in Footer', 'dellow'),
		'desc' => __('Insert scripts or code before the closing &lt;/body&gt; tag in the document source:', 'dellow'),
		'id' => 'footercode1',
		'std' => '',
		'type' => 'textarea');	
		
	$options[] = array(
		'name' => __('Copyright Text', 'dellow'),
		'desc' => __('Some Text regarding copyright of your site, you would like to display in the footer.', 'dellow'),
		'id' => 'footertext2',
		'std' => '',
		'type' => 'textarea');
		
	$options[] = array(
		'desc' => __('To have more customization options <a href="http://inkhive.com/product/dellow-plus/" target="_blank">Upgrade to Pro</a> at Just $24.95'),
		'std' => '',
		'type' => 'info');
		
	//Design Settings
		
	$options[] = array(
		'name' => __('Layout Settings', 'dellow'),
		'type' => 'heading');	
	
	$options[] = array(
		'name' => "Sidebar Layout",
		'desc' => "Select Layout for Posts & Pages.",
		'id' => "sidebar-layout",
		'std' => "right",
		'type' => "images",
		'options' => array(
			'left' => $imagepath . '2cl.png',
			'right' => $imagepath . '2cr.png',
			'full' => $imagepath . '1col.png')
	);
	
	
	$options[] = array(
		'desc' => __('<a href="http://inkhive.com/product/dellow-plus/" target="_blank">Pro Version</a> supports the option to add custom skins, styles & Layouts. Upgrade at Just $24.95.'),
		'std' => '',
		'type' => 'info');
	
	$options[] = array(
		'name' => __('Enable Excerpts on Homepage', 'dellow'),
		'desc' => __('By default, the theme shows either the full post or content up till the point where you placed the &lt;!--more--> tag. Check this if you want to you enable Excerpts on Homepage. Excerpts are short summary of your posts.', 'dellow'),
		'id' => 'excerpt1',
		'std' => '0',
		'type' => 'checkbox');	
		
	$options[] = array(
		'name' => __('Custom CSS', 'dellow'),
		'desc' => __('Some Custom Styling for your site. Place any css codes here instead of the style.css file.', 'dellow'),
		'id' => 'style2',
		'std' => '',
		'type' => 'textarea');
	
	//SLIDER SETTINGS

	$options[] = array(
		'name' => __('Slider Settings', 'dellow'),
		'type' => 'heading');

	$options[] = array(
		'name' => __('Enable Slider', 'dellow'),
		'desc' => __('Check this to Enable Slider.', 'dellow'),
		'id' => 'slider_enabled',
		'type' => 'checkbox',
		'std' => '0' );
		
	$options[] = array(
		'name' => __('Using the Slider', 'dellow'),
		'desc' => __('This Slider supports upto 5 Images. To show only 3 Slides in the slider, upload only 3 images. Leave the rest Blank. For best results, upload images of size 1180x500px.', 'dellow'),
		'type' => 'info');
		
	$options[] = array(
		'desc' => __('In the <a href="http://inkhive.com/product/dellow-plus/" target="_blank">Pro Version (Dellow Plus)</a> there are options to customize slider by choosing form over 16 animation effects, ability to set transition time and speed and more. Upgrade at Just $24.95'),
		'std' => '',
		'type' => 'info');	

	$options[] = array(
		'name' => __('Slider Image 1', 'dellow'),
		'desc' => __('First Slide', 'dellow'),
		'id' => 'slide1',
		'class' => '',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'dellow'),
		'id' => 'slidetitle1',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'dellow'),
		'id' => 'slidedesc1',
		'std' => '',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'dellow'),
		'id' => 'slideurl1',
		'std' => '',
		'type' => 'text');		
	
	$options[] = array(
		'name' => __('Slider Image 2', 'dellow'),
		'desc' => __('Second Slide', 'dellow'),
		'class' => '',
		'id' => 'slide2',
		'type' => 'upload');
	
	$options[] = array(
		'desc' => __('Title', 'dellow'),
		'id' => 'slidetitle2',
		'std' => '',
		'type' => 'text');	
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'dellow'),
		'id' => 'slidedesc2',
		'std' => '',
		'type' => 'textarea');		
		
	$options[] = array(
		'desc' => __('Url', 'dellow'),
		'id' => 'slideurl2',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Slider Image 3', 'dellow'),
		'desc' => __('Third Slide', 'dellow'),
		'id' => 'slide3',
		'class' => '',
		'type' => 'upload');	
	
	$options[] = array(
		'desc' => __('Title', 'dellow'),
		'id' => 'slidetitle3',
		'std' => '',
		'type' => 'text');	
		
	$options[] = array(
		'desc' => __('Description or Tagline', 'dellow'),
		'id' => 'slidedesc3',
		'std' => '',
		'type' => 'textarea');	
			
	$options[] = array(
		'desc' => __('Url', 'dellow'),
		'id' => 'slideurl3',
		'std' => '',
		'type' => 'text');		
	
	$options[] = array(
		'name' => __('Slider Image 4', 'dellow'),
		'desc' => __('Fourth Slide', 'dellow'),
		'id' => 'slide4',
		'class' => '',
		'type' => 'upload');	
		
	$options[] = array(
		'desc' => __('Title', 'dellow'),
		'id' => 'slidetitle4',
		'std' => '',
		'type' => 'text');
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'dellow'),
		'id' => 'slidedesc4',
		'std' => '',
		'type' => 'textarea');			
		
	$options[] = array(
		'desc' => __('Url', 'dellow'),
		'id' => 'slideurl4',
		'std' => '',
		'type' => 'text');		
	
	$options[] = array(
		'name' => __('Slider Image 5', 'dellow'),
		'desc' => __('Fifth Slide', 'dellow'),
		'id' => 'slide5',
		'class' => '',
		'type' => 'upload');	
		
	$options[] = array(
		'desc' => __('Title', 'dellow'),
		'id' => 'slidetitle5',
		'std' => '',
		'type' => 'text');	
	
	$options[] = array(
		'desc' => __('Description or Tagline', 'dellow'),
		'id' => 'slidedesc5',
		'std' => '',
		'type' => 'textarea');		
		
	$options[] = array(
		'desc' => __('Url', 'dellow'),
		'id' => 'slideurl5',
		'std' => '',
		'type' => 'text');	
			
	//Social Settings
	
	$options[] = array(
		'name' => __('Social Settings', 'dellow'),
		'type' => 'heading');
	
	$options[] = array(
		'desc' => __('Please set the value of following fields, as per the instructions given along. If you do not want to use an icon, just leave it blank. If some icons are showing up, even when no value is set then make sure they are completely blank, and just save the options once. They will not be shown anymore.', 'dellow'),
		'type' => 'info');

	$options[] = array(
		'name' => __('Facebook', 'dellow'),
		'desc' => __('Facebook Profile or Page URL i.e. http://facebook.com/username/ ', 'dellow'),
		'id' => 'facebook',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Twitter', 'dellow'),
		'desc' => __('Twitter Username', 'dellow'),
		'id' => 'twitter',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
	
	$options[] = array(
		'name' => __('Google Plus', 'dellow'),
		'desc' => __('Google Plus profile url, including "http://"', 'dellow'),
		'id' => 'google',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Feeburner', 'dellow'),
		'desc' => __('URL for your RSS Feeds', 'dellow'),
		'id' => 'feedburner',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Pinterest', 'dellow'),
		'desc' => __('Your Pinterest Profile URL', 'dellow'),
		'id' => 'pinterest',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Instagram', 'dellow'),
		'desc' => __('Your Instagram Profile URL', 'dellow'),
		'id' => 'instagram',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Linked In', 'dellow'),
		'desc' => __('Your Linked In Profile URL', 'dellow'),
		'id' => 'linkedin',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');	
		
	$options[] = array(
		'name' => __('Youtube', 'dellow'),
		'desc' => __('Your Youtube Channel URL', 'dellow'),
		'id' => 'youtube',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Tumblr', 'dellow'),
		'desc' => __('Your Tumblr Blog URL', 'dellow'),
		'id' => 'tumblr',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Flickr', 'dellow'),
		'desc' => __('Your Flickr Profile URL', 'dellow'),
		'id' => 'flickr',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');
		
	$options[] = array(
		'name' => __('Dribbble', 'dellow'),
		'desc' => __('Your Dribble Profile URL', 'dellow'),
		'id' => 'dribble',
		'std' => '',
		'class' => 'mini',
		'type' => 'text');	
		
	$options[] = array(
		'desc' => __('More social Icons are available in the <a href="http://inkhive.com/product/dellow-plus/" target="_blank">Pro Version (dellow Plus)</a>. Upgrade at Just $24.95'),
		'std' => '',
		'type' => 'info');										
		
	$options[] = array(
	'name' => __('Support', 'dellow'),
	'type' => 'heading');
	
	$options[] = array(
		'desc' => __('Dellow WordPress theme has been Designed and Created by <a href="http://InkHive.com" target="_blank">Rohit Tripathi</a>. For any Queries or help regarding this theme, <a href="http://inkhive.com/forums/section/theme-support/dellow/" target="_blank">use the support forums.</a> You can also ask questions about this theme on WordPress.org Support Forums. I will answer your queries there too.', 'dellow'),
		'type' => 'info');	
	
	$options[] = array(
		'desc' => __('A Documentation file has been provided with the theme, for your convenience. <a target="_blank" href="'.get_template_directory_uri().'/Documentation-Dellow.pdf">Dellow Theme Documentation.</a> ', 'dellow'),
		'type' => 'info');	
		
		
	 $options[] = array(
		'desc' => __('<a href="http://twitter.com/rohitinked" target="_blank">Follow Me on Twitter</a> to know about my upcoming themes.', 'dellow'),
		'type' => 'info');	
	
	$options[] = array(
		'desc' => __('We Offer Dedicated Personal Support to all our <a href="http://inkhive.com/product/dellow-plus/" target="_blank">Pro Version Customers</a>. Upgrade at Just $24.95'),
		'std' => '',
		'type' => 'info');		
	
	$options[] = array(
		'name' => __('Regenerating Post Thumbnails', 'dellow'),
		'desc' => __('If you are using dellow Theme on a New Wordpress Installation, then you can skip this section.<br />But if you have just switched to this theme from some other theme, then you are requested regenerate all the post thumbnails. It will fix all the issues you are facing with distorted & ugly homepage thumbnail Images. ', 'dellow'),
		'type' => 'info');	
		
	$options[] = array(
		'desc' => __('To Regenerate all Thumbnail images, Install and Activate the <a href="http://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails</a> WP Plugin. Then from <strong>Tools &gt; Regen. Thumbnails</strong>, re-create thumbnails for all your existing images. And your blog will look even more stylish with Dellow theme.<br /> ', 'dellow'),
		'type' => 'info');	
		
			
	$options[] = array(
		'desc' => __('<strong>Note:</strong> Regenerating the thumbnails, will not affect your original images. It will just generate a separate image file for those images.', 'dellow'),
		'type' => 'info');	
	
	$options[] = array(
		'name' => __('Theme Credits', 'dellow'),
		'desc' => __('Check this if you want to you do not want to give us credit in your site footer.', 'dellow'),
		'id' => 'credit1',
		'std' => '0',
		'type' => 'checkbox');
	
		$options[] = array(
		'name' => __('Upgrade to Pro', 'dellow'),
		'type' => 'heading');
	
	$options[] = array(
		'desc' => __('To Upgrade to Dellow Plus and unlock plenty of features in this theme, please visit <a href="http://inkhive.com/product/dellow-plus/" target="_blank">this link</a>. Upgrade at Just $24.95'),
		'std' => '',
		'type' => 'info');
			
			
	$options[] = array(
		'desc' => __('For any queries, you can <a href="http://inkhive.com/contact-us/" target="_blank">contact us</a>.'),
		'std' => '',
		'type' => 'info');	

	return $options;
}