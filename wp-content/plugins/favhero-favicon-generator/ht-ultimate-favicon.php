<?php
/*
*	Plugin Name: Heroic Favicon Generator
*	Plugin URI: http://wordpress.org/extend/plugins/ht-ultimate-favicon/
*	Description: The Ultimate Favicon tool for WordPress
*	Author: Hero Themes
*	Version: 1.4.2
*	Author URI: http://www.herothemes.com/
*	Text Domain: ht-ultimate-favicon
*/

define( 'HT_ULTIMATE_FAVICONS_OPTION_KEY', '_ht_favicons_key' );

if( !class_exists( 'HT_Ultimate_Favicon' ) ){
	class HT_Ultimate_Favicon {


		
		/**
		* Constructor
		*/
		function __construct(){
			//load plugin textdomain
			add_action( 'init', array( $this, 'load_textdomain' ) );
			
			include_once( 'phpthumb/phpthumb.functions.php' );
			include_once( 'phpthumb/phpthumb.ico.php' );
			include_once( 'php/ht-ultimate-favicon-settings.php' );
			add_action( 'wp_head', array( $this, 'echo_favicons') );
			
		}

		function load_textdomain(){
			load_plugin_textdomain('ht-ultimate-favicon', false, basename( dirname( __FILE__ ) ) . '/languages' );
		}

		function echo_favicons(){
			$favicon_set = get_option( HT_ULTIMATE_FAVICONS_OPTION_KEY );
			echo '<!-- FAVHERO FAVICON START -->';
			//16,32,48,57,72,96,120,128,144,152,195,228, 230
			if($favicon_set){
				foreach ($favicon_set as $key => $value) {
					switch($key) {
						case '152':
							echo '<link rel="apple-touch-icon-precomposed" href="'. $value .'">';
							break;
						case '144':
							echo '<meta name="msapplication-TileColor" content="#FFFFFF">';
							echo '<meta name="msapplication-TileImage" content="' . $value . '">';
							break;
						case '152':						
							echo '<!-- For iPad with high-resolution Retina display running iOS ≥ 7: -->';
							echo '<link rel="apple-touch-icon-precomposed" sizes="152x152" href="' . $value . '">';
							break;
						case '144':						
							echo '<!-- For iPad with high-resolution Retina display running iOS ≤ 6: -->';
							echo '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="' . $value . '">';
							break;
						case '120':
							echo '<!-- For iPhone with high-resolution Retina display running iOS ≥ 7: -->';
							echo '<link rel="apple-touch-icon-precomposed" sizes="120x120" href="' . $value . '">';
							break;
						case '114':						
							echo '<!-- For iPhone with high-resolution Retina display running iOS ≤ 6: -->';
							echo '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="' . $value . '">';
							break;
						case '72':						
							echo '<!-- For first- and second-generation iPad: -->';
							echo '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="' . $value . '">';
							break;
						case '57':						
							echo '<!-- For non-Retina iPhone, iPod Touch, and Android 2.1+ devices: -->';
							echo '<link rel="apple-touch-icon-precomposed" href="' . $value . '">';
						break;
					}
				}
			} else {
				echo '<!-- NO FAVICONS SET -->';
			}
			echo '<!-- FAVHERO FAVICON START -->';
		}

		/**
		* Test WP Support
		* @return boolean Support provided
		*/
		function test_wp_support(){
			$arg = array(
			    'mime_type' => 'image/png',
			    'methods' => array(
			        'resize',
			        'save'
			    )
			);
			return wp_image_editor_supports($arg);
		}

		/**
		*
		*/
		public function create_icon_from_attachment_for_size($size, $attachment_id){
			$attachment = get_attached_file( $attachment_id, false );

			$attachment_path = get_attached_file( $attachment_id );

			if( ( $size=='ico' ) && ( pathinfo($attachment_path, PATHINFO_EXTENSION)=='ico') ){
				$upload_dir = wp_upload_dir();
				$path = $upload_dir['path'];

				//the attachment is already an icon file so use that 
				HT_Ultimate_Favicon::use_dot_ico_file( $path, $attachment_path );
				return $attachment_path;
			}

			$img = wp_get_image_editor( $attachment );

			if ( ! is_wp_error( $img ) ) {
				if($size=='ico'){				
					return HT_Ultimate_Favicon::create_dot_ico_from_png_attachment( $attachment_id );
				} else {
					$upload_dir = wp_upload_dir();
					$path = $upload_dir['path'];
					return HT_Ultimate_Favicon::create_png_icon($img, $size, $path);
				}					
			}
		}

		/**
		*
		*/
		public function create_dot_ico_from_png_attachment($attachment_id){
			$attachment = get_attached_file( $attachment_id, false );
			$img = wp_get_image_editor( $attachment );

			if ( ! is_wp_error( $img ) ) {

				$upload_dir = wp_upload_dir();
				$path = $upload_dir['path'];

				$favicon_sizes = array(16,32,48);
				//sort the array high to low
				arsort($favicon_sizes);

				//is writable test
				if ( is_writable($path) ){
					//echo 'writable';
					foreach ($favicon_sizes as $size) {
						$icons[strval($size)] = HT_Ultimate_Favicon::create_temp_png_icon($img, $size, $path);
					}

					//then create icon with files

					//16 x 16
					$gd_16 = @imagecreatefrompng( $path . '/temp-favicon-16.png' );
					//32 x 32
					$gd_32 = @imagecreatefrompng( $path . '/temp-favicon-32.png' );
					//48 x 48
					$gd_48 = @imagecreatefrompng( $path . '/temp-favicon-48.png' );

					if( $gd_16 && $gd_32 && $gd_48 ){
						//echo 'gd_worked';
						$gd_icon_array = array( $gd_16, $gd_32, $gd_48 );
						$icon = phpthumb_ico::GD2ICOstring( $gd_icon_array );
						return HT_Ultimate_Favicon::use_dot_ico_file ( $path, $icon );
					} else {
						HT_Ultimate_Favicon::issue_message('GD Not Installed, please check GD is available');
					}
					
					return $icons;
				} else {
					HT_Ultimate_Favicon::issue_message('Image path is not writeable');
				}

			} else {
				HT_Ultimate_Favicon::issue_message('Could not open original image attachment');
			}
		}


		public function use_dot_ico_file( $path, $icon ){
			$filename = $path . '/favicon.ico';
			$fp = fopen( $filename, 'w+' );
			fwrite( $fp, $icon );
			fclose( $fp );
			HT_Ultimate_Favicon::move_ico_to_root($filename);
			return $path . '/temp-favicon-32.png';

		}

		public function move_ico_to_root($ico_file){
			//copy favicon to root
			if( !copy($ico_file, ABSPATH . 'favicon.ico') ){
				HT_Ultimate_Favicon::issue_message('Could not copy favicon to root, please check the permissions on your installation');
			} else {
				//echo 'copied favicon to root';
			}
		}

		/**
		* Delete favicon from root of install
		*/
		public function delete_ico_from_root(){
			$file = ABSPATH . 'favicon.ico';
			if( file_exists( $file ) && ! unlink( $file ) ){
				HT_Ultimate_Favicon::issue_message('Could not delete root favicon, please check the permissions on your instllation');
			} else {
				//echo 'copied favicon to root';
			}
		}


		/**
		* Create a favicon icon set from a given attachment id
		*/
		public function create_icons_from_attachment_id($attachment_id){

			//todo test for support with wp_image_editor_supports($arg);
			//todo test for gd
			//create the image editor
			$attachment = get_attached_file( $attachment_id, false );
			$img = wp_get_image_editor( $attachment );
			$icons = array();

			if ( ! is_wp_error( $img ) ) {

				$upload_dir = wp_upload_dir();
				$path = $upload_dir['path'];

				$favicon_sizes = array(16,32,48,57,72,96,120,128,144,152,195,228, 230);
				//sort the array high to low
				arsort($favicon_sizes);

				//is writable test
				if ( is_writable($path) ){
					foreach ($favicon_sizes as $size) {
						$icons[strval($size)] = HT_Ultimate_Favicon::create_png_icon($img, $size, $path);
					}

					//then create icon with files

					//16 x 16
					$gd_16 = @imagecreatefrompng( $path . '/favicon-16.png' );
					//32 x 32
					$gd_32 = @imagecreatefrompng( $path . '/favicon-32.png' );
					//48 x 48
					$gd_48 = @imagecreatefrompng( $path . '/favicon-48.png' );

					if( $gd_16 && $gd_32 && $gd_48 ){
						//echo 'gd_worked';
						$gd_icon_array = array( $gd_16, $gd_32, $gd_48 );
						$icon = phpthumb_ico::GD2ICOstring( $gd_icon_array );
						$icons['ico'] = HT_Ultimate_Favicon::use_dot_ico_file ( $path, $icon );
					} else {
						HT_Ultimate_Favicon::issue_message('GD Not Installed, please check GD is available');
					}
					
					return $icons;
				} else {
					HT_Ultimate_Favicon::issue_message('Image path is not writeable');
				}

			} else {
				HT_Ultimate_Favicon::issue_message('Could not open original image attachment');
			}
		}

		/**
		* Create icon
		*
		* @param size - the size of the icon
		*/
		function create_png_icon($img, $size, $path){
			$img->resize( $size, $size, true );
			$filename = $path . '/favicon-' . $size . '.png';
			$img->save( $filename ,'image/png');
			return $filename;
		}

		/**
		* Create icon
		*
		* @param size - the size of the icon
		*/
		function create_temp_png_icon($img, $size, $path){
			$img->resize( $size, $size, true );
			$filename = $path . '/temp-favicon-' . $size . '.png';
			$img->save( $filename ,'image/png');
			return $filename;
		}

		/**
		*
		*
		*/
		function issue_message($message){
			echo '<div class="updated">';
		    echo '<p>' . __( $message, 'ht-ultimate-favicon' ) . '</p>';
		    echo '</div>';
		}

		

	}//end class

}//end class exists



//run the plugin
if( class_exists( 'HT_Ultimate_Favicon' ) ){
	$ht_gallery_manager_init = new HT_Ultimate_Favicon();
}


