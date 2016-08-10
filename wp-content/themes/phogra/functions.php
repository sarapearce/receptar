<?php
set_include_path(implode(PATH_SEPARATOR, array_merge(explode(PATH_SEPARATOR, get_include_path()), array( sprintf("%s%s%s", dirname(__FILE__), DIRECTORY_SEPARATOR, "functions") ))));
include("phogra-features.php");

/* Enqueue Javascript Files */
function phogra_enqueue_js_files() 
{
    wp_enqueue_script('jquery');
    wp_enqueue_script('phogra-custom', get_template_directory_uri() . "/js/jquery.custom-1.0.js");

    if ( is_page_template('template-contact.php') )
    {
        wp_enqueue_script('phogra-googlemaps', "http://maps.google.com/maps/api/js?sensor=false");
    }

    if ( is_singular() )
        wp_enqueue_script( "comment-reply" );
}
add_action('wp_enqueue_scripts', 'phogra_enqueue_js_files');
/* End Enqueue Javascript Files */

/* Enqueue CSS */
function phogra_enqueue_css() 
{
    wp_enqueue_style('phogra-default', get_stylesheet_uri(), array(), "1.6");
}
add_action('wp_enqueue_scripts', 'phogra_enqueue_css');

function phogra_display_user_custom_style_and_map()
{
?>
	<style type="text/css">
		<?php if (get_phogra_theme_option("logo_color")): ?>
			#logo a { color: <?php echo get_phogra_theme_option("logo_color"); ?> }
		<?php endif; ?>
		<?php if (get_phogra_theme_option("navigation_default_color")): ?>
			#sidebar nav a { color: <?php echo get_phogra_theme_option("navigation_default_color"); ?>; }
		<?php endif; ?>
		<?php if (get_phogra_theme_option("navigation_active_color")): ?>
			#sidebar nav a:hover,
			#sidebar nav .current-item a, 
			#sidebar nav .current_page_item a { color: <?php echo get_phogra_theme_option("navigation_active_color"); ?>; }
		<?php endif; ?>
		<?php if (get_phogra_theme_option("read_more_color")): ?>
			#blog-listing .read-more { color: <?php echo get_phogra_theme_option("read_more_color"); ?>; }
		<?php endif; ?>
		<?php if ( is_admin_bar_showing() ): ?>
			#sidebar { top: 28px; }  
			html { margin-top: 0px !important; }
			* html body { margin-top: 0px !important; }	
		<?php endif; ?>
	</style>
    <?php

    if (get_phogra_theme_option("map_location") && is_page_template('template-contact.php')):
?>
        <script type="text/javascript">
            window.onload = codeAddress;
            function codeAddress()
            {
                var geocoder = new google.maps.Geocoder();
                var address = "<?php echo addslashes(get_phogra_theme_option('map_location')); ?>";

                geocoder.geocode( { 'address': address }, function(results, status)
                {
                    if (status == google.maps.GeocoderStatus.OK)
                    {
                        var location = results[0].geometry.location;
                        var mapOptions = {
                            zoom: 12,
                            center: location,
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        }
                        map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
                        map.setCenter(location);
                        var marker = new google.maps.Marker({
                            map: map,
                            position: location
                        });
                    }
                });
            }
        </script>
<?php
    endif;
}
add_action('wp_head', 'phogra_display_user_custom_style_and_map');
/* End Enqueue CSS */

/* Define Image Sizes */
function phogra_define_theme_image_sizes()
{
    global $content_width;
    if ( ! isset( $content_width ) )
        $content_width = 580;

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	
	set_post_thumbnail_size( 225, 225, true );
    add_image_size( 'large-featured', 990 );
}
add_action( 'after_setup_theme', 'phogra_define_theme_image_sizes');
/* End Define Image Sizes */

/* Define Custom Menus */
function phogra_define_theme_menu()
{
	register_nav_menu( 'header_menu', __("Navigation Menu", "templaty") );
}
add_action( 'after_setup_theme', 'phogra_define_theme_menu' );
/* End Define Custom Menus */

/* Set Site Title */
function phogra_set_site_title($title)
{
	if ( $title == '' )
	{
		$ttl = get_bloginfo( 'name', 'display' );
		$description = get_bloginfo( 'description', 'display' );
		if ( trim($description) != '' )
		{
			$ttl = $ttl . ' | ' . get_bloginfo( 'description', 'display' );
		}
		
		return $ttl;
	}
}
add_filter( 'wp_title', 'phogra_set_site_title' );
/* End Set Site Title */

/* Theme Options Page Setup */
function phogra_theme_options_scripts_and_styles()
{
	if (isset($_GET["page"]) && $_GET["page"] == "phogra_theme_options")
 	{
 		wp_enqueue_script('jquery');
 		wp_enqueue_script('media-upload');
 		wp_enqueue_script('thickbox');
 		wp_enqueue_script('my-upload');
		
 		wp_enqueue_style('thickbox');
        wp_enqueue_style('wp-color-picker' );
        wp_enqueue_script('templaty-theme-options-handle', get_template_directory_uri() . '/theme-options/js/theme-options.js', array( 'wp-color-picker' ), false, true );

        wp_enqueue_style('templaty-theme-options-style', get_template_directory_uri() . '/theme-options/css/theme-options.css');
 	}
}
add_action('admin_enqueue_scripts', 'phogra_theme_options_scripts_and_styles');

require_once("theme-options/templaty-theme-options.php");

TemplatyThemeOptionsDefaults::Set("site_copyright", sprintf("&copy; %s %s. %s", date("Y"), get_bloginfo("title"), __("All rights reserved.", "templaty")));

function phogra_theme_options_init()
{
	register_setting( 'phogra_options_group', 'phogra_option_name', 'phogra_theme_options_validate' );
}
add_action('admin_init', 'phogra_theme_options_init');

function phogra_theme_options_add_page()
{
	add_theme_page(__( 'Theme Options', 'templaty' ), __( 'Theme Options', 'templaty' ), 'edit_theme_options', 'phogra_theme_options', 'phogra_theme_options_do_page');
}
add_action('admin_menu', 'phogra_theme_options_add_page');

function phogra_theme_options_do_page()
{
	if (!isset( $_REQUEST['settings-updated']))
	{
		$_REQUEST['settings-updated'] = false;
	}
	?>
	<div class="wrap">

		<?php screen_icon(); echo "<h2>" . wp_get_theme() . __( ' Theme Options', 'templaty' ) . "</h2>"; ?>
		
		<?php if ( false !== $_REQUEST['settings-updated'] ) : ?>
			<div class="updated fade"><p><strong><?php _e( 'Options saved', 'templaty' ); ?></strong></p></div>
		<?php endif; ?>

		<form method="post" action="options.php" id="templaty-theme-options-form">
			<?php settings_fields( 'phogra_options_group' ); ?>

			<table class="form-table">

				<?php $templaty = new TemplatyThemeOptions(); ?>
				
				<!-- Favicon Upload Field -->
				<?php $templaty->GenerateFileUploadField('site_favicon', __('Favicon', 'templaty')); ?>
				
				<!-- Text Logo -->
				<?php $templaty->GenerateTextField('blogname', __('Text Logo', 'templaty'), get_option("blogname")); ?>
				
				<!-- Logo Upload Field -->
				<?php $templaty->GenerateFileUploadField('logo_image', __('Image Logo', 'templaty')); ?>
				
				<!-- Background Color Field -->
				<?php $templaty->GenerateColorPickerField('logo_color', __('Logo Text Color', 'templaty'), "#C6FF00"); ?>
				
				<!-- Navigation Links Color Field -->
				<?php $templaty->GenerateColorPickerField('navigation_default_color', __('Navigation Text Color', 'templaty'), "#FFFFFF"); ?>
				
				<!-- Navigation Hover Color Field -->
				<?php $templaty->GenerateColorPickerField('navigation_active_color', __('Navigation Active Color', 'templaty'), "#C6FF00"); ?>
				
				<!-- Navigation Links Color Field -->
				<?php $templaty->GenerateColorPickerField('read_more_color', __('Read More Color', 'templaty'), "#C6FF00"); ?>
				
				<!-- Facebook Field -->
				<?php $templaty->GenerateTextField('facebook_link', __('Facebook Link', 'templaty')); ?>
				
				<!-- Twitter Field -->
				<?php $templaty->GenerateTextField('twitter_link', __('Twitter Link', 'templaty')); ?>
				
				<!-- Flickr Field -->
				<?php $templaty->GenerateTextField('flickr_link', __('Flickr Link', 'templaty')); ?>
				
				<!-- Google Field -->
				<?php $templaty->GenerateTextField('google_link', __('Google Link', 'templaty')); ?>
				
				<!-- RSS Field -->
				<?php $templaty->GenerateTextField('rss_link', __('RSS Link', 'templaty')); ?>
				
				<!-- Dribble Field -->
				<?php $templaty->GenerateTextField('dribble_link', __('Dribble Link', 'templaty')); ?>
				
				<!-- Vimeo Field -->
				<?php $templaty->GenerateTextField('vimeo_link', __('Vimeo Link', 'templaty')); ?>
				
				<!-- Forrst Field -->
				<?php $templaty->GenerateTextField('forrst_link', __('Forrst Link', 'templaty')); ?>
				
				<!-- Youtube Field -->
				<?php $templaty->GenerateTextField('youtube_link', __('Youtube Link', 'templaty')); ?>
				
				<!-- Digg Field -->
				<?php $templaty->GenerateTextField('digg_link', __('Digg Link', 'templaty')); ?>
				
				<!-- Pinterest Field -->
				<?php $templaty->GenerateTextField('pinterest_link', __('Pinterest Link', 'templaty')); ?>
				
				<!-- Contact Map Location Field -->
				<?php $templaty->GenerateTextField('map_location', __('Map Location', 'templaty'), '', __('Here you can insert the address that should be displayed by the map from the contact page. Example: "Grote St, Adelaide, Australia".', 'templaty')); ?>
				
				<!-- Site Copyright Field -->
				<?php $templaty->GenerateTextField('site_copyright', __('Site Copyright', 'templaty'), TemplatyThemeOptionsDefaults::Get("site_copyright")); ?>
				
			</table>

			<p class="submit">
				<input type="submit" class="button-primary" value="<?php _e( 'Save Options', 'templaty' ); ?>" />
			</p>
		</form>
	</div>
	<?php
}

function phogra_theme_options_validate($inputs)
{
	$settings = array( "blogname", "blogdescription" );
	$newSettings = array();
	
	foreach($inputs as $key => $value)
	{
		$inputs[$key] = wp_filter_nohtml_kses($value);
		
		if (in_array($key, $settings))
		{
			$newSettings[$key] = $value;
			unset($inputs[$key]);
		}
	}
	
	foreach($newSettings as $key => $value)
	{
		update_option($key, $value);
	}
	
	return $inputs;
}

function get_phogra_theme_option($key = '')
{
	$options = get_option( 'phogra_option_name' );
	
	if ($key != '' && !is_null($options[$key]) && $options[$key] != "")
	{
		return esc_html($options[$key]);
	}
	
	return false;
}

/* End Theme Options Page Setup */