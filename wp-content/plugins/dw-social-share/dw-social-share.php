<?php
/*
 Plugin Name: DW Social Share
 Plugin URI: 
 Description: This plugin enables sharing of your content via popular social networks. Easy & configurable.
 Version: 1.0.0
 Author: DesignWall
 Author URI: http://www.designwall.com
 */

 function dw_social_share( $url='', $title='' ) {

 	if ( '' == $title ) {
 		$title = rawurlencode( get_the_title() );
 	}

 	$style = get_option( 'dw_social_style' );
 	$networks = get_option( 'dw_social_network' );
 	$social = '';
 	if ( is_array( $networks ) ) {
 		$social .= '<ul class="dw-social-share dwss-style-'.$style.'">';
 		foreach ( $networks as $value ) {
 			switch ( $value ) {
 				case 'facebook':
 				$social .= '<li class="dwss-facebook"><a href="javascript.void(0);" rel="nofollow"><i class="fa fa-facebook"></i> <span>Facebook</span></a></li>';
 				break;

 				case 'twitter':
 				$social .= '<li class="dwss-twitter"><a href="javascript.void(0);" rel="nofollow"><i class="fa fa-twitter"></i> <span>Twitter</span></a></li>';
 				break;

 				case 'google_plus':
 				$social .= '<li class="dwss-google-plus"><a href="javascript.void(0);" rel="nofollow"><i class="fa fa-google-plus"></i> <span>Google+</span></a></li>';
 				break;	

 				case 'linkedin':
 				$social .= '<li class="dwss-linkedin"><a href="javascript.void(0);" rel="nofollow"><i class="fa fa-linkedin"></i> <span>LinkedIn</span></a></li>';
 				break;	

 				case 'pinterest':
 				$social .= '<li class="dwss-pinterest"><a href="javascript.void(0);" rel="nofollow"><i class="fa fa-pinterest"></i> <span>Pinterest</span></a></li>';
 				break;	

 				case 'mail':
 				$social .= '<li class="dwss-mail" ><a href="mailto:admin@example.com?Subject='.$title.'" rel="nofollow"><i class="fa fa-envelope-o"></i> <span>Email</span></a></li>';
 				break;

 				case 'print':
 				$social .= '<li class="dwss-print" ><a href="javascript.void(0);" rel="nofollow"><i class="fa fa-print"></i> <span>Print</span></a></li>';
 				break;		

 				default:
					# code...
 				break;
 			}
 		}
 		$social .= '</ul>';
 	}
 	echo $social;
 }

//Shortcode
 function dw_social_share_shortcode( $atts, $content = "" ) {
 	$atts = shortcode_atts( array(
 		'url' => '',
 		'title' => ''
 		), $atts, 'dw_social_share' );
 	return dw_social_share( $atts['url'], $atts['title'] );
 }
 add_shortcode( 'dw_social_share', 'dw_social_share_shortcode' );

 add_action( 'wp_enqueue_scripts', 'dw_register_plugin_styles' );

/**
 * Register style sheet.
 */


function dw_register_plugin_styles() {
	wp_enqueue_script( 'dw-social-share', plugins_url( 'dw-social-share/assets/js/script.js' ), array(), '1.0.0', true );
	if ( '' == get_option( 'dw_social_enqueue' ) ) {
		wp_register_style( 'dw-social-share-fa', plugins_url( 'dw-social-share/assets/css/font-awesome.min.css' ) );
	}
	wp_register_style( 'dw-social-share', plugins_url( 'dw-social-share/assets/css/style.css' ) );

	wp_enqueue_style( 'dw-social-share' );
	wp_enqueue_style( 'dw-social-share-fa' );
}

// create custom plugin settings menu
add_action('admin_menu', 'dw_social_share_create_menu');

function dw_social_share_create_menu() {

	//create new subemenu setting page
	add_submenu_page( 'options-general.php', 'DW Social Share', 'DW Social Share', 'manage_options', 'dw-social-share', 'dw_social_share_settings_page' );
	// add_menu_page( 'DW Social Share Settings', 'DW Social Share', 'administrator', __FILE__, 'dw_social_share_settings_page' , '' );

	//call register settings function
	add_action( 'admin_init', 'register_dw_social_share_settings' );
}


function register_dw_social_share_settings() {
	//register our settings
	register_setting( 'dw_social_share-settings-group', 'dw_social_style' );
	register_setting( 'dw_social_share-settings-group', 'dw_social_network' );
	register_setting( 'dw_social_share-settings-group', 'dw_social_mobile' );
	register_setting( 'dw_social_share-settings-group', 'dw_social_enqueue' );
}

function dw_social_share_settings_page() {
	?>
	<div class="wrap">
		<h2>DW Social Share</h2>
		<p>To implement the social share, you will have to edit your theme (If you are not using our <a href="https://www.designwall.com/wordpress/themes/">WordPress Themes</a>). Copy the following code into your theme where you want the social share to be:</p> 
			<?php
			$php_string  = "<?php if ( function_exists('dw_social_share') )  { dw_social_share(); } ?>";
			echo '<code>';
			echo htmlentities( $php_string, true );
			echo '</code>';
			?>
		<form method="post" action="options.php">
			<?php settings_fields( 'dw_social_share-settings-group' ); ?>
			<?php do_settings_sections( 'dw_social_share-settings-group' ); ?>
			<h3>Select the sharing style</h3>

			<p><label><input <?php if( get_option( 'dw_social_style' ) ) : echo get_option( 'dw_social_style' ) == 1 ? 'checked' : '' ; endif;  ?> type="radio" name="dw_social_style" value="1" ><img style="vertical-align: middle;" src="<?php echo plugins_url( 'dw-social-share/assets/img/style-1.png', dirname(__FILE__) ); ?>" /></input></label></p>
			<p><label><input <?php if( get_option( 'dw_social_style' ) ) : echo get_option( 'dw_social_style' ) == 2 ? 'checked' : '' ; endif;  ?> type="radio" name="dw_social_style" value="2" ><img style="vertical-align: middle;" src="<?php echo plugins_url( 'dw-social-share/assets/img/style-2.png', dirname(__FILE__) ); ?>"/></input></label></p>
			<p><label><input <?php if( get_option( 'dw_social_style' ) ) : echo get_option( 'dw_social_style' ) == 3 ? 'checked' : '' ; endif;  ?> type="radio" name="dw_social_style" value="3" ><img style="vertical-align: middle;" src="<?php echo plugins_url( 'dw-social-share/assets/img/style-3.png', dirname(__FILE__) ); ?>"/></input></label></p>
			<p><label><input <?php if( get_option( 'dw_social_style' ) ) : echo get_option( 'dw_social_style' ) == 4 ? 'checked' : '' ; endif;  ?> type="radio" name="dw_social_style" value="4" ><img style="vertical-align: middle;" src="<?php echo plugins_url( 'dw-social-share/assets/img/style-4.png', dirname(__FILE__) ); ?>"/></input></label></p>
			<p><label><input <?php if( get_option( 'dw_social_style' ) ) : echo get_option( 'dw_social_style' ) == 5 ? 'checked' : '' ; endif;  ?> type="radio" name="dw_social_style" value="5" ><img style="vertical-align: middle;" src="<?php echo plugins_url( 'dw-social-share/assets/img/style-5.png', dirname(__FILE__) ); ?>"/></input></label></p>
			<p><label><input <?php if( get_option( 'dw_social_style' ) ) : echo get_option( 'dw_social_style' ) == 6 ? 'checked' : '' ; endif;  ?> type="radio" name="dw_social_style" value="6" ><img style="vertical-align: middle;" src="<?php echo plugins_url( 'dw-social-share/assets/img/style-6.png', dirname(__FILE__) ); ?>"/></input></label></p>
			<p><label><input <?php if( get_option( 'dw_social_style' ) ) : echo get_option( 'dw_social_style' ) == 7 ? 'checked' : '' ; endif;  ?> type="radio" name="dw_social_style" value="7" ><img style="vertical-align: middle;" src="<?php echo plugins_url( 'dw-social-share/assets/img/style-7.png', dirname(__FILE__) ); ?>"/></input></label></p>
			<p><label><input <?php if( get_option( 'dw_social_style' ) ) : echo get_option( 'dw_social_style' ) == 'custom' ? 'checked' : '' ; endif;  ?> type="radio" name="dw_social_style" value="custom" ><img style="vertical-align: middle;" src="http://placehold.it/350x50?text=Custom%20Style"/></input></label></p>
			

			<h3>Select the sharing networks</h3>

			<p><label><input <?php if( get_option( 'dw_social_network' ) ) : echo in_array( 'facebook', get_option(  'dw_social_network' ) ) ? 'checked' : '';  endif; ?> type="checkbox" name="dw_social_network[]" value="facebook"> Facebook</label></p>
			<p><label><input <?php if( get_option( 'dw_social_network' ) ) : echo in_array( 'twitter', get_option(  'dw_social_network' ) ) ? 'checked' : '';   endif; ?> type="checkbox" name="dw_social_network[]" value="twitter"> Twitter </label></p>
			<p><label><input <?php if( get_option( 'dw_social_network' ) ) : echo in_array( 'google_plus', get_option(  'dw_social_network' ) ) ? 'checked' : '';  endif; ?> type="checkbox" name="dw_social_network[]" value="google_plus"> Google Plus </label></p>
			<p><label><input <?php if( get_option( 'dw_social_network' ) ) : echo in_array( 'linkedin', get_option(  'dw_social_network' ) ) ? 'checked' : '';  endif; ?> type="checkbox" name="dw_social_network[]" value="linkedin"> Linkedin </label></p>
			<p><label><input <?php if( get_option( 'dw_social_network' ) ) : echo in_array( 'pinterest', get_option(  'dw_social_network' ) ) ? 'checked' : '';  endif; ?> type="checkbox" name="dw_social_network[]" value="pinterest"> Pinterest </label></p>
			<p><label><input <?php if( get_option( 'dw_social_network' ) ) : echo in_array( 'mail', get_option(  'dw_social_network' ) ) ? 'checked' : '';  endif; ?> type="checkbox" name="dw_social_network[]" value="mail"> Email </label></p>
			<p><label><input <?php if( get_option( 'dw_social_network' ) ) : echo in_array( 'print', get_option(  'dw_social_network' ) ) ? 'checked' : '';  endif; ?> type="checkbox" name="dw_social_network[]" value="print"> Print </label></p>

			<h3>Advanced Options</h3>

			<p><label><input type="checkbox" name="dw_social_enqueue" value="yes" <?php if( get_option( 'dw_social_enqueue' ) ) : echo 'checked'; endif; ?> ><strong>Disable CSS and JS</strong></label></p>

			<?php submit_button(); ?>

		</form>
	</div>
	<?php } 
