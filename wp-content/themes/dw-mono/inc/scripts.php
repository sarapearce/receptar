<?php
function dw_mono_scripts() {
	global $wp_version;
	$version = wp_get_theme( wp_get_theme()->template )->get( 'Version' );

	if ( defined( 'WP_ENV' ) && 'development' === WP_ENV ) {
		$assets = array(
			'css' => '/assets/css/dw-mono.css',
			'js'  => '/assets/js/dw-mono.js',
		);
	} else {
		$assets = array(
			'css' => '/assets/css/dw-mono.min.css',
			'js'  => '/assets/js/dw-mono.min.js',
		);
	}

	wp_enqueue_style( 'dw-mono-main', get_template_directory_uri() . $assets['css'], array(), $version );
	wp_enqueue_style( 'dw-mono-style', get_stylesheet_uri() );
	wp_enqueue_style( 'dw-focus-print', get_template_directory_uri() . '/assets/css/print.css', array(), $version, 'print' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/js/modernizr.min.js', array(), $version, false );
	wp_enqueue_script( 'dw-mono-script', get_template_directory_uri() . $assets['js'], array( 'jquery' ), $version, true );
}
add_action( 'wp_enqueue_scripts', 'dw_mono_scripts' );
