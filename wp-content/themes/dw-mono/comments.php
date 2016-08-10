<?php
if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="comments">
	<?php if ( have_comments() ) : ?>
		<h3 class="comments-title">
			<?php comments_number( __( '0 comments', 'dw-mono' ),  __( '1 comments', 'dw-mono' ), __( '% comments', 'dw-mono' ) ); ?>
		</h3>

		<div class="comment-list">
			<?php
				wp_list_comments( array(
					'style'      => 'div',
					'short_ping' => true,
					'avatar_size' => 48
				) );
			?>
		</div>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<nav class="navigation comment-pagination" role="navigation">
			<?php paginate_comments_links( array( 'prev_text' => __( '<i class="fa fa-angle-left"></i>', 'dw-mono' ), 'next_text' => __( '<i class="fa fa-angle-right"></i>', 'dw-mono' ) ) ); ?>
		</nav>
		<?php endif; ?>

	<?php endif; ?>

	<?php if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<div class="alert alert-warning"><?php _e( 'Comments are closed.', 'dw-mono' ); ?></div>
	<?php endif; ?>

	<?php
		$commenter = wp_get_current_commenter();
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		$fields =  array(
		  'author' =>
		    '<p class="comment-form-author"><label for="author">' . __( 'Name', 'dw-mono' ) . '</label> ' .
		    ( $req ? '<span class="required">*</span>' : '' ) .
		    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
		    '" class="form-control"' . $aria_req . ' /></p>',
		  'email' =>
		    '<p class="comment-form-email"><label for="email">' . __( 'Email', 'dw-mono' ) . '</label> ' .
		    ( $req ? '<span class="required">*</span>' : '' ) .
		    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
		    '" class="form-control"' . $aria_req . ' /></p>',
		  'url' =>
		    '<p class="comment-form-url"><label for="url">' . __( 'Website', 'dw-mono' ) . '</label>' .
		    '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
		    '" class="form-control" /></p>',
		);
		$comments_args = array(
			'logged_in_as' => '',
			'comment_notes_before' => '',
			'comment_notes_after' => '',
			'class_submit' => 'btn btn-default',
			'fields' => apply_filters( 'comment_form_default_fields', $fields ),
	  	'comment_field' => '<p class="comment-form-comment"><label for="comment">' . __( 'Comment', 'dw-mono' ) . '</label><textarea id="comment" name="comment" class="form-control" rows="5" aria-required="true"></textarea></p>',
		);
		comment_form( $comments_args );
	?>

</section>
