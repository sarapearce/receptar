<?php

function phogra_add_homepage_template_features_meta_box()
{
    add_meta_box(
        'album_meta_box',
        __('Upload Your Images', "templaty"),
        'phogra_homepage_meta_box_callback',
        'page',
        'normal'
    );
}
add_action( 'add_meta_boxes', 'phogra_add_homepage_template_features_meta_box' );

function phogra_homepage_meta_box_callback($post)
{
    $imageList = explode(";", get_post_meta($post->ID, 'gallery_links', true));
    $imageListHtml = "";

    foreach($imageList as $key => $data)
    {
        if (!empty($data))
        {
            $imageListHtml .= '<div class="formfield clearfix">';
            $image = wp_get_attachment_image_src($data);
            if ($image)
            {
                $imageListHtml .= sprintf('<img src="%s" alt="image-%s" width="100" height="100" />', $image[0], $key);
            }
            $imageListHtml .= sprintf('<input type="hidden" class="text image-file file-id" name="image_link[]" value="%s" />', $data);
            $imageListHtml .= sprintf('<a href="#" class="remove">%s</a>', __("Remove", "templaty"));
            $imageListHtml .= '</div>';
        }
    }

    echo '
			<div class="form">
				<div class="formfield clearfix" id="post-images-row">
					<label>' . __("Images", "templaty") . ' - <a href="#" class="button button-primary add-more">' . __("Add More", "templaty") . '</a></label>
					<div class="image-list clearfix" id="post-type-image-list" data-remove-text="' . __("Remove", "templaty") . '" data-confirm-text="' . __("Are you sure?", "templaty") . '">
						' . $imageListHtml . '
					</div>
				</div>
			</div>
	';
}

function phogra_update_homepage_custom_data($postId)
{
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
    {
        return $postId;
    }

    if (!empty($_POST) && $_POST["post_type"] == "page")
    {
        $post = stripslashes_deep($_POST);
        update_post_meta($postId, 'gallery_links', implode(";", isset($post["image_link"]) ? $post["image_link"] : array("")));
    }
}
add_action("save_post", 'phogra_update_homepage_custom_data');

function phogra_features_scripts_and_styles($hook)
{
    if ( $hook == 'post-new.php' || $hook == 'post.php' )
    {
        wp_enqueue_script('phogra-mediauploader-extension', get_template_directory_uri() . '/js/mediauploader.extension.js', array( 'jquery' ), false, true );
        wp_enqueue_script('phogra-theme-features', get_template_directory_uri() . '/js/phogra.admin.features.js', array( 'phogra-mediauploader-extension' ), false, true );
        wp_enqueue_style('templaty-theme-options-style', get_template_directory_uri() . '/css/phogra.admin.features.css');
    }
}
add_action('admin_enqueue_scripts', 'phogra_features_scripts_and_styles');