<?php
/**
 * Dellow functions and definitions
 *
 * @package Dellow
 */

/**
 * Initialize Options Panel
 */
if ( !function_exists( 'optionsframework_init' ) ) {
	define( 'OPTIONS_FRAMEWORK_DIRECTORY', get_template_directory_uri() . '/inc/' );
	require_once dirname( __FILE__ ) . '/inc/options-framework.php';
}
if ( ! function_exists( 'dellow_setup' ) ) :

function dellow_setup() {

	load_theme_textdomain( 'dellow', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'post-thumbnails' );
	add_image_size('homepage-banner',400,400,true);

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'dellow' ),
		'sliding' => __( 'Sliding Menu', 'dellow' ),
	) );

	add_theme_support( 'custom-background', apply_filters( 'dellow_custom_background_args', array(
		'default-color' => 'eeeeee',
		'default-image' => '',
	) ) );
	
	global $content_width;
	if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

}
endif; // dellow_setup
add_action( 'after_setup_theme', 'dellow_setup' );

function dellow_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'dellow' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Left', 'dellow' ),
		'id'            => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Center', 'dellow' ),
		'id'            => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Right', 'dellow' ),
		'id'            => 'sidebar-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'dellow_widgets_init' );

add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function optionsframework_custom_scripts() { ?>

<script type="text/javascript">
jQuery(document).ready(function() {

	jQuery('#example_showhidden').click(function() {
  		jQuery('#section-example_text_hidden').fadeToggle(400);
	});
	
	if (jQuery('#example_showhidden:checked').val() !== undefined) {
		jQuery('#section-example_text_hidden').show();
	}
	
});
</script>
<?php
}

function dellow_scripts() {
	wp_enqueue_style( 'dellow-fonts', '//fonts.googleapis.com/css?family=Lato:400,700,300' );
	wp_enqueue_style( 'dellow-basic-style', get_stylesheet_uri() );
	if ( (function_exists( 'of_get_option' )) && (of_get_option('sidebar-layout', true) != 1) ) {
		if (of_get_option('sidebar-layout', true) ==  'right') {
			wp_enqueue_style( 'dellow-layout', get_template_directory_uri()."/css/layouts/content-sidebar.css" );
		}
		elseif (of_get_option('sidebar-layout', true) ==  'left') {
			wp_enqueue_style( 'dellow-layout', get_template_directory_uri()."/css/layouts/sidebar-content.css" );
		}
		else {
			wp_enqueue_style( 'dellow-layout', get_template_directory_uri()."/css/layouts/content.css" );
		}	
	}
	else {
		wp_enqueue_style( 'dellow-layout', get_template_directory_uri()."/css/layouts/content-sidebar.css" );
	}
	
	wp_enqueue_style( 'dellow-sidr-style', get_template_directory_uri()."/css/sidr.css" );
	
	wp_enqueue_style( 'dellow-bootstrap-style', get_template_directory_uri()."/css/bootstrap.min.css", array('dellow-layout') );
		
	wp_enqueue_style( 'dellow-main-style', get_template_directory_uri()."/css/main.css", array('dellow-layout','dellow-sidr-style') );
	
	wp_enqueue_script( 'dellow-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'dellow-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );
	
	wp_enqueue_style( 'dellow-nivo-slider-default-theme', get_template_directory_uri()."/css/nivo/themes/default/default.css" );
	
	wp_enqueue_style( 'dellow-nivo-slider-style', get_template_directory_uri()."/css/nivo/nivo.css" );
	
	wp_enqueue_style('dellow-nivo-lightbox', get_template_directory_uri()."/css/nivo-lightbox.css" );
	
	wp_enqueue_style( 'dellow-nivo-lightbox-default-theme', get_template_directory_uri()."/css/themes/default/default.css" );
	
	wp_enqueue_script('dellow-timeago', get_template_directory_uri() . '/js/jquery.timeago.js', array('jquery') );
	
	wp_enqueue_script( 'dellow-nivo-slider', get_template_directory_uri() . '/js/nivo.slider.js', array('jquery') );
	
	wp_enqueue_script( 'dellow-sidr', get_template_directory_uri() . '/js/sidr.js', array('jquery') );
	
	wp_enqueue_script( 'jquery-effects-bounce' );	
	
	wp_enqueue_script( 'dellow-bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery') );
	
	wp_enqueue_script( 'dellow-lightbox-js', get_template_directory_uri() . '/js/nivo-lightbox.min.js', array('jquery') );
	
	wp_enqueue_script( 'dellow-custom-js', get_template_directory_uri() . '/js/custom.js', array('jquery','dellow-nivo-slider','dellow-timeago','hoverIntent') );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'dellow-keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'dellow_scripts' );

function dellow_custom_head_codes() {
 if ( (function_exists( 'of_get_option' )) && (of_get_option('headcode1', true) != 1) ) {
	echo of_get_option('headcode1', true);
 }
 if ( (function_exists( 'of_get_option' )) && (of_get_option('style2', true) != 1) ) {
	echo "<style>".of_get_option('style2', true)."</style>";
 }
 if ( (function_exists( 'of_get_option' )) && (of_get_option('slider_enabled') != 0) ) {
	echo "<script>jQuery(window).load(function() { jQuery('#slider').nivoSlider({effect:'boxRainGrow',pauseTime:4500}); });</script>";
 }
if ( get_header_image() ) : 
 	echo "<style>#parallax-bg { background: url('".get_header_image()."') center top repeat-x; }</style>";
 endif;
 
 if ( is_user_logged_in() ) :
 	echo "<style>#site-navigation { margin-top: 30px; }</style>";
 endif;
 
}	
add_action('wp_head', 'dellow_custom_head_codes');

function dellow_nav_menu_args( $args = '' )
{
    $args['container'] = false;
    return $args;
} // function
add_filter( 'wp_page_menu_args', 'dellow_nav_menu_args' );

function dellow_pagination() {
	global $wp_query;
	$big = 12345678;
	$page_format = paginate_links( array(
	    'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	    'format' => '?paged=%#%',
	    'current' => max( 1, get_query_var('paged') ),
	    'total' => $wp_query->max_num_pages,
	    'type'  => 'array'
	) );
	if( is_array($page_format) ) {
	            $paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
	            echo '<div class="pagination"><div><ul>';
	            echo '<li><span>'. $paged . ' of ' . $wp_query->max_num_pages .'</span></li>';
	            foreach ( $page_format as $page ) {
	                    echo "<li>$page</li>";
	            }
	           echo '</ul></div></div>';
	 }
}
/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates. Import Widgets
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
