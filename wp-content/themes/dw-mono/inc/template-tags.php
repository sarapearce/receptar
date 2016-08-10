<?php
if ( ! function_exists( 'dw_mono_entry_meta' ) ) :
function dw_mono_entry_meta() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated sr-only" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		_x( '%s', 'post date', 'dw-mono' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		_x( 'by %s', 'post author', 'dw-mono' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';
}
endif;

if ( ! function_exists( 'dw_mono_entry_footer' ) ) :
function dw_mono_entry_footer() {
	if ( 'post' == get_post_type() ) {
		echo '<footer class="entry-footer">';
		$categories_list = get_the_category_list( __( ', ', 'dw-mono' ) );
		if ( $categories_list && dw_mono_categorized_blog() && ! is_single() && ! is_category() ) {
			printf( '<span class="cat-links">' . __( '<i class="fa fa-folder-open"></i> %1$s', 'dw-mono' ) . '</span>', $categories_list );
		}
		$tags_list = get_the_tag_list( '', __( ', ', 'dw-mono' ) );
		if ( $tags_list &&  ! is_tag() && ( is_single() || is_category() ) ) {
			printf( '<span class="tags-links">' . __( '<i class="fa fa-tag"></i> %1$s', 'dw-mono' ) . '</span>', $tags_list );
		}

		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			echo '<i class="fa fa-comments"></i>';
			comments_popup_link( __( '0 Comments', 'dw-mono' ), __( '1 Comment', 'dw-mono' ), __( '% Comments', 'dw-mono' ) );
			echo '</span>';
		}
		echo '</footer>';
	}
}
endif;

if ( ! function_exists( 'dw_mono_posts_navigation' ) ) :
function dw_mono_posts_navigation() {
	the_posts_pagination(
		array(
			'mid_size' => 4,
			'prev_text' => __( '<i class="fa fa-angle-left"></i>', 'dw-mono' ),
    	'next_text' => __( '<i class="fa fa-angle-right"></i>', 'dw-mono' ),
		)
	);
}
endif;

function dw_mono_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'dw_mono_categories' ) ) ) {
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			'number'     => 2,
		) );

		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'dw_mono_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		return true;
	} else {
		return false;
	}
}

function dw_mono_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	delete_transient( 'dw_mono_categories' );
}
add_action( 'edit_category', 'dw_mono_category_transient_flusher' );
add_action( 'save_post',     'dw_mono_category_transient_flusher' );

if ( ! function_exists( 'dw_mono_breadcrumbs' ) ) :
function dw_mono_breadcrumbs() {
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<div class="breadcrumbs">', '</div>' );
	}
}
endif;

if ( ! function_exists( 'dw_mono_primary_column_class' ) ) :
function dw_mono_primary_column_class() {
	echo 'col-sm-8';
}
endif;

if ( ! function_exists( 'dw_mono_secondary_column_class' ) ) :
function dw_mono_secondary_column_class() {
	echo 'col-sm-4';
}
endif;
