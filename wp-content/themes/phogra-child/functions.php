<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    //need to hard code the template directory path the style.css, make style.css be pointed to by sass
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}
