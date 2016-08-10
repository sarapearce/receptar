<?php
if ( post_password_required() )
	return;
?>

<!-- Post Comments -->
<section id="post-comments">

	<!-- Comment Form -->
	<?php $req = get_option( 'require_name_email' ); ?>
	<?php comment_form(array(
		"title_reply" => "",
		"title_reply_to" => "",
		"cancel_reply_link" => "",
		"comment_notes_before" => "",
		"comment_notes_after" => "",
		'comment_field' => '
								<div class="formfield clearafter closer">
									<label class="lower">' . __( 'Your message here...', "templaty" ) . '</label>
									<div class="field">
										<textarea name="comment"></textarea>
									</div>
								</div>
							',
		"fields" => array(
							'author' => '
											<div class="formfield col">
												<label>' . __( 'Your name', "templaty" ) . '</label>
												<div class="field">
													<input type="text" class="text" name="author" value="' . esc_attr( $commenter['comment_author'] ) . '" />
												</div>
											</div>
										',
							'email'  => '
											<div class="formfield col col-right">
												<label>' . __( 'Your E-mail address', "templaty" ) . '</label>
												<div class="field">
													<input type="text" class="text" name="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" />
												</div>
											</div>
										'
						),
		"label_submit" => __( "Submit", "templaty" )
	)); ?>
	<!-- End Comment Form -->
	
	<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
		<!-- no explanation needed -->
	<?php elseif ( !$req ): ?>
		<!-- no explanation needed -->
	<?php elseif ( comments_open() ) : ?>
        <div id="explanation">
            <div class="inside"><?php _e("*please fill in all fields. Thanks!", "templaty"); ?></div>
        </div>
	<?php endif; ?>
	
	<?php if ( have_comments() ) : ?>

        <ul id="comments-list">
            <?php wp_list_comments( array() ); ?>
        </ul>
        <div class="comments-pages">
            <?php paginate_comments_links(); ?>
        </div>
		
		<?php if ( ! comments_open() && get_comments_number() ) : ?>
			<p><?php _e( 'Comments are closed.' , 'templaty' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

</section>
<!-- End Post Comments -->