<?php
/*
Plugin Name: FaceBook Image Fix
Plugin URI: http://www.capn3m0.org/facebook-image-fix/
Description: FaceBook Image Fix solves problem with FaceBook LikeIt and Share actions. Sometimes when you share/like one of yours pages can happen that images preview viewed in FaceBook are wrong. This plugin solves the problem by inserting FaceBook Open Graph or XFBML Tag. Easy configuration! Seo Plugin support! YouTube thumbs support!
Version: 0.4.3
Author: capn3m0 <capn3m0@capn3m0.org>
Author URI: http://www.capn3m0.org
License: GPL2

=== RELEASE NOTES ===
2013-01-21 - v0.4.3 - Remove credits link to capn3m0 from the Footer
2012-01-23 - v0.4.2 - Added YouTube thumbs for post with Video and without images. Wordpress Video Plugin shortcodes support!
2012-01-23 - v0.4.1 - Added possibility to use only XFBML or Open Graph Tag.
2012-01-22 - v0.4 - Added support to All In One Seo Pack Meta data and Seo Ultimate Meta Data. Added og:locale tag. Added link to capn3m0.org on footer.
2012-01-20 - v0.3 - Fix problem with description tag. The description is generated retrieving first 250 chars of the post/pages content.
2012-01-20 - v0.2 - Fix problem with description tag. Added information comments in the Settings page.
2012-01-19 - v0.1 - first version

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
*/
add_action('admin_menu', 'fbimgfix_menu');
add_option("fbimgfix_tag", "0");
function fbimgfix_menu()
{
    if (function_exists('add_options_page')) {
        add_options_page('FaceBook Image Fix', 'FaceBook Image Fix', 9, 'fbimgfix',
            'fbimgfix_settings');
    }
}
function fbimgfix_settings()
{
    if ($_POST['Send']) {
        $fbimgfix = $_POST['fbimgfix'];
        $fbimgfix_logo = $_POST['fbimgfix_logo'];
        $fbimgfix_admins = $_POST['fbimgfix_admins'];
        $fbimgfix_plugins = $_POST['fbimgfix_plugins'];
		$fbimgfix_tag = $_POST['fbimgfix_tag'];
        update_option("fbimgfix", $fbimgfix);
        update_option("fbimgfix_logo", $fbimgfix_logo);
        update_option("fbimgfix_plugins", $fbimgfix_plugins);
        update_option("fbimgfix_admins", $fbimgfix_admins);
		update_option("fbimgfix_tag", $fbimgfix_tag);
        echo '<div id="message" class="updated fade"><p>Settings Updated!</p></div>';
    }
    $output = '<form method="post" action="' . $_SERVER['REQUEST_URI'] . '">';
?>
	<style type="text/css">

	input[type=text]{
	background: #cecdcd; /* Fallback */
	background: rgba(206, 205, 205, 0.6);
	border: 2px solid #666;
	padding: 6px 5px;
	line-height: 1em;
	-webkit-box-shadow: inset -1px 1px 1px rgba(255, 255, 255, 0.65);
	-moz-box-shadow: inset -1px 1px 1px rgba(255, 255, 255, 0.65);
	box-shadow: inset -1px 1px 1px rgba(255, 255, 255, 0.65);
	-webkit-border-radius: 8px !important;
	-moz-border-radius: 8px !important;
	border-radius: 8px !important;
	margin-bottom: 10px;
	width: 300px;
	}

	select{
	background: #cecdcd; /* Fallback */
	background: rgba(206, 205, 205, 0.6);
	border: 2px solid #666;
	padding: 6px 5px;
	height: 2.8em !important;
	-webkit-box-shadow: inset -1px 1px 1px rgba(255, 255, 255, 0.65);
	-moz-box-shadow: inset -1px 1px 1px rgba(255, 255, 255, 0.65);
	box-shadow: inset -1px 1px 1px rgba(255, 255, 255, 0.65);
	-webkit-border-radius: 8px !important;
	-moz-border-radius: 8px !important;
	border-radius: 8px !important;
	margin-bottom: 10px;
	width: 300px;
	text-align:center;
	}

	</style>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/it_IT/all.js#xfbml=1&appId=168431236506208";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>  
 
		  <?php
	$disabled = 'disabled="disabled"';
    $fbimgfixplugins = get_option('fbimgfix_plugins');
    $fbimgfix_settings = get_option('fbimgfix_settings');	
    $output .= '<div class="wrap">' . "\n";
    $output .= '<h2>FaceBook Image Fix Settings</h2>' . "\n";
    $output .= 'Version 0.4.2 created by <strong><a href="http://www.capn3m0.org/author/admin" target="_blank" class="author">capn3m0</a> - <a href="http://www.capn3m0.org/" target="_blank">Capn3m0.org WebSecurity</a></strong>' .
        "\n";
    $output .= '<br /><a href="https://twitter.com/capn3m0" class="twitter-follow-button" data-show-count="false" data-lang="it">Segui @capn3m0</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>';
    $output .= '<br /><div class="fb-like" data-href="https://www.facebook.com/capn3m0org" data-send="false" data-layout="button_count" data-width="50" data-show-faces="false" data-action="recommend"></div>';
    $output .= '	<br /> <br />' . "\n";
    $output .= '	<table border="0" cellspacing="0" cellpadding="6">' . "\n";
    $output .= '		<tr>' . "\n";
    $output .= '			<td width="75%"><strong>FaceBook Implementation Method (for fixing only image select <strong>XFBML</strong>): </td>' .
        "\n";
    $output .= '			<td width="25%"><input type="radio" name="fbimgfix_tag" value="0" ';
	if (get_option('fbimgfix_tag') == "0") { $output .= 'checked="checked"'; }
	$output .= '/>XFBML<br /><input type="radio" name="fbimgfix_tag" value="1" ';
	if (get_option('fbimgfix_tag') == "1") { $output .= 'checked="checked"'; }
	$output .= '/> Open Graph Tag</td>';
    $output .= '		</tr>' . "\n";
	$output .= '		<tr>' . "\n";
    $output .= '			<td colspan="2" width="100%">If you include Open Graph tags on your Web page, your page becomes an equivalent to a Facebook page<br>For more information about Open Graph Tag click <a href="https://developers.facebook.com/docs/opengraph/" target="_blank"><strong>here</strong></a>.</td>' .
        "\n";
    $output .= '		</tr>' . "\n";
    $output .= '		<tr>' . "\n";
    $output .= '			<td width="75%"><strong>Blog Logo URL</strong> (The image that will be used if there aren\'t images in the post.<b>At least 50x50px</b>) : </td>' .
        "\n";
    $output .= '			<td width="25%"><input type="text" name="fbimgfix_logo" value="' .
        get_option('fbimgfix_logo') . '"/></td>';
    $output .= '		</tr>' . "\n";
    $output .= '		<tr>' . "\n";
    $output .= '			<td width="50%">Enter <strong>Facebook User IDs</strong> separated by comma. Can be empty: </td>' .
        "\n";
    $output .= '			<td><input type="text" name="fbimgfix_admins" value="' .
        get_option('fbimgfix_admins') . '" '; 
	if (get_option('fbimgfix_tag') == "0") { $output .= $disabled; }
	$output .= '/></td>';
    $output .= '		</tr>' . "\n";
    $output .= '		<tr>' . "\n";
    $output .= '			<td width="75%"><strong>Meta Data Source</strong>: </td>' . "\n";
    $output .= '			<td width="25%"><select name="fbimgfix_plugins" '; 
	if (get_option('fbimgfix_tag') == "0") { $output .= $disabled; } 
	$output .= '/>'. "\n";
    $output .= '          <option value="wp" ';
    if ($fbimgfixplugins == "wp") {
        $output .= 'selected="selected">';
    } else {
        $output .= '>';
    }
    $output .= '          Default WordPress Meta</option>' . "\n";
    if (is_plugin_active('all-in-one-seo-pack/all_in_one_seo_pack.php')) {
        $output .= '          <option value="aioseop" ';
        if ($fbimgfixplugins == "aioseop") {
            $output .= 'selected="selected">';
        } else {
            $output .= '>';
        }
        $output .= '          All In One Seo Pack</option>' . "\n";
    }
    if (is_plugin_active('seo-ultimate/seo-ultimate.php')) {
        $output .= '          <option value="seoultimate" ';
        if ($fbimgfixplugins == "seoultimate") {
            $output .= 'selected="selected">';
        } else {
            $output .= '>';
        }
        $output .= '          Seo Ultimate</option>' . "\n";
    }
    $output .= '          </select></td>' . "\n";
    $output .= '		</tr>' . "\n";
    $output .= '	</table>' . "\n";
    $output .= "\n";
    $output .= '				<input type="submit" name="Send" class="button-primary" style="float:left" value="Update Settings &raquo;" />' .
        "\n";
    $output .= '</form>';
    $output .= '</div>' . "\n";
    echo $output;
}

/**
 * Function: getTitle
 * Retrieve title from post meta table of WordPress, All In One Seo Pack and Seo Ultimate
 *
 * Parameters:
 *     $fbimgfixplugins - Plugin name
 */
function getTitle($fbimgfixplugins)
{
    global $wpdb;
    switch ($fbimgfixplugins) {
        case "wp":
            {
                if (is_home() || is_front_page()) {
                    $title = get_bloginfo('name');
                } else {
                    $title = get_the_title();
                }
            }
            return trim($title);
        case "aioseop":
            {
                if (is_home() || is_front_page()) {
                    global $aioseop_options;
                    $title = stripcslashes($aioseop_options['aiosp_home_title']);
                } else {
                    $query = 'SELECT * FROM ' . $wpdb->prefix . 'postmeta WHERE post_id=' .
                        get_the_ID() . ' AND meta_key="_aioseop_title";';
                    $return = $wpdb->get_results($query);
                    $title = $return[0]->meta_value;
                    if (trim($title) == "") {
                        if (is_home() || is_front_page()) {
                            $title = get_bloginfo('name');
                        } else {
                            $title = get_the_title();
                        }
                    }
                }
                return trim($title);
            }
        case "seoultimate":
            {
                if (is_home() || is_front_page()) {
                    $title = get_bloginfo('name');
                } else {
                    $query = 'SELECT * FROM ' . $wpdb->prefix . 'postmeta WHERE post_id=' .
                        get_the_ID() . ' AND meta_key="_su_title";';
                    $return = $wpdb->get_results($query);
                    $title = $return[0]->meta_value;
                    if (trim($title) == "") {
                        if (is_home() || is_front_page()) {
                            $title = get_bloginfo('name');
                        } else {
                            $title = get_the_title();
                        }
                    }
                }
                return trim($title);
            }
    }
}
/**
 * Function: getExc
 * Retrieve post/page description from post meta table of WordPress, All In One Seo Pack and Seo Ultimate
 *
 * Parameters:
 *     $fbimgfixplugins - Plugin name
 *     $length - Number of chars to retrieve. Default 300
 */
function getExc($fbimgfixplugins, $length = 300)
{
    global $wpdb;
    switch ($fbimgfixplugins) {
        case "wp":
            {
                if (is_home() || is_front_page()) {
                    $desc = get_bloginfo('description');
                } else {
                    $desc = get_the_excerpt();
                }
            }
            return trim($desc);
        case "aioseop":
            {
                if (is_home() || is_front_page()) {
                    global $aioseop_options;
                    $desc = stripcslashes($aioseop_options['aiosp_home_description']);
                } else {
                    $query = 'SELECT * FROM ' . $wpdb->prefix . 'postmeta WHERE post_id=' .
                        get_the_ID() . ' AND meta_key="_aioseop_description";';
                    $return = $wpdb->get_results($query);
                    $desc = $return[0]->meta_value;
                    if (trim($desc) == "") {
                        if (is_home() || is_front_page()) {
                            $desc = get_bloginfo('name');
                        } else {
                            $desc = get_the_excerpt();
                        }
                    }
                    $desc = substr($desc, 0, $length);
                }
                return trim($desc);
            }
        case "seoultimate":
            {
                if (is_home() || is_front_page()) {
                    $su = new SU_MetaDescriptions();
                    $desc = $su->get_setting('home_description');
                } else {
                    $query = 'SELECT * FROM ' . $wpdb->prefix . 'postmeta WHERE post_id=' .
                        get_the_ID() . ' AND meta_key="_su_description";';
                    $return = $wpdb->get_results($query);
                    $desc = $return[0]->meta_value;
                    if (trim($desc) == "") {
                        if (is_home() || is_front_page()) {
                            $desc = get_bloginfo('name');
                        } else {
                            $desc = get_the_excerpt();
                        }
                    }
                    $desc = substr($desc, 0, $length);
                }
            }
            return trim($desc);
    }
}
function parse_youtube_url($id,$return='embed',$width='',$height='',$rel=0){
    //return embed iframe
    if($return == 'embed'){
        return '<iframe width="'.($width?$width:560).'" height="'.($height?$height:349).'" src="http://www.youtube.com/embed/'.$id.'?rel='.$rel.'" frameborder="0" allowfullscreen></iframe>';
    }
    //return normal thumb
    else if($return == 'thumb'){
        return 'http://i1.ytimg.com/vi/'.$id.'/default.jpg';
    }
    //return hqthumb
    else if($return == 'hqthumb'){
        return 'http://i1.ytimg.com/vi/'.$id.'/hqdefault.jpg';
    }
    // else return id
    else{
        return $id;
    }
}
/**
 * Function: getImage
 * Retrieve first image used in the post/page.
 *
 * Parameters:
 *     $fbimgfixlogo - Logo url to use if there aren't images
 */
function getImage($fbimgfixlogo)
{
    if (is_home() || is_front_page()) {
        return $fbimgfixlogo;
    } else {
        $post = get_post($id);
		if ($output = preg_match('/\[youtube ([[:print:]]+)\]/', $post->post_content, $m)) {
		$ytpics = parse_youtube_url($m[1],'thumb');
		return $ytpics;
		} elseif ($output = preg_match('%(?:youtube\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $post->post_content, $m)) {
		$ytid = explode("/",$m[0]);
		$ytpics = parse_youtube_url($ytid[2],'thumb');
		return $ytpics;
		} elseif ($output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $images)) {
        if (!empty($images[1][0])) {
            return $images[1][0];
        }  else {
            return $fbimgfixlogo;
        }
		}
    }
}	
/**
 * Function: addfbogt
 * Add Facebook Open Graph Tag to Wordpress Header
 *
 */
function addfbogt()
{


    if (!is_preview()) {
        $fbimgfixtype = "blog";
        $fbimgfixplugins = get_option('fbimgfix_plugins');
        $fbimgfixlogo = get_option("fbimgfix_logo");
        $fbimgfixadmins = get_option("fbimgfix_admins");
        $fbimgfixlang = str_replace("-", "_", get_bloginfo('language'));
        $fbimgfixtitle = getTitle($fbimgfixplugins);
        $fbimgfixdesc = getExc($fbimgfixplugins);
        $fbimgfiximage = getImage($fbimgfixlogo);
		$fbimgfixtag = get_option("fbimgfix_tag");
if ( $fbimgfixtag == "0" ) {
?>
<!-- Start FaceBook Image Fix <http://www.capn3m0.org> -->
<link rel="image_src" href="<?php echo $fbimgfiximage ?>" />
<!-- End FaceBook Image Fix Plugin -->
<?
} elseif ( $fbimgfixtag == "1" ) {
?>
<!-- Start FaceBook Image Fix <http://www.capn3m0.org> -->
<meta property="og:title" content="<?php echo $fbimgfixtitle ?>"/>
<meta property="og:type" content="<?php echo $fbimgfixtype ?>"/>
<?php if (is_home() || is_front_page()) { ?>
<meta property="og:url" content="<?php echo get_site_url(); ?>"/>
<?php } else { ?>
<meta property="og:url" content="<?php echo get_permalink(); ?>"/>
<?php } ?>
<meta property="og:image" content="<?php echo $fbimgfiximage ?>"/>
<meta property="og:site_name" content="<?php echo get_bloginfo('name'); ?>"/>
<meta property="fb:admins" content="<?php echo $fbimgfixadmins ?>"/>
<meta property="og:description" content="<?php echo $fbimgfixdesc ?>"/>
<!-- End FaceBook Image Fix Plugin -->
<?php } ?>
<?php } ?>
<?php } ?>
<?php add_action('wp_head', 'addfbogt'); ?>