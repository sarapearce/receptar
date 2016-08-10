<?php
if ( ! isset( $content_width ) ) {
	$content_width = 750;
}

if ( ! function_exists( 'dw_mono_setup' ) ) :
function dw_mono_setup() {
	load_theme_textdomain( 'dw-mono', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );

	$header_args = array(
		'uploads'       => true,
		'width'         => 960,
		'height'        => 1200,
		'header-text'   => false,
		'default-image' => get_template_directory_uri() . '/assets/img/header.jpg',
	);
	add_theme_support( 'custom-header', $header_args );

	register_default_headers( array(
		'default' => array(
			'url' => get_template_directory_uri() . '/assets/img/header.jpg',
			'thumbnail_url' => get_template_directory_uri() . '/assets/img/header.jpg',
			/* translators: header image description */
			'description' => __( 'Deffault', 'dw-mono' )
		),
	) );

	add_theme_support( 'woocommerce' );

	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

}
endif;
add_action( 'after_setup_theme', 'dw_mono_setup' );

function dw_mono_register_required_plugins() {
	$plugins = array(
		array(
			'name'        => 'DW Social Share',
			'slug'        => 'dw-social-share'
		),
		array(
			'name'        => 'DW Twitter',
			'slug'        => 'dw-twitter'
		),
		array(
			'name'        => 'DW Question & Answer',
			'slug'        => 'dw-question-answer'
		)
	);

	$config = array(
		'id'           => 'dw-mono',
		'menu'         => 'dw-mono-install-plugins',
		'parent-slug'  => 'fw-extensions',
	);
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'dw_mono_register_required_plugins' );

function dw_mono_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'dw-mono' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 1', 'dw-mono' ),
		'id'            => 'footer-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 2', 'dw-mono' ),
		'id'            => 'footer-2',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Footer 3', 'dw-mono' ),
		'id'            => 'footer-3',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'dw_mono_widgets_init' );

function dw_mono_search_form_modify( $html ) {
  //$html = str_replace( 'search-form', 'form-inline', $html );
  $html = str_replace( '<label>', '<label class="sr-only">', $html );
  $html = str_replace( '</label>', '', $html );
  $html = str_replace( '</span>', '</span></label>', $html );
  $html = str_replace( 'screen-reader-text', 'sr-only', $html );
  $html = str_replace( 'search-field', 'form-control', $html );
  $html = str_replace( 'search-submit', 'sr-only', $html );
  return $html;
}
add_filter( 'get_search_form', 'dw_mono_search_form_modify' );


