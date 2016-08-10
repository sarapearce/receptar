<?php
/*
Plugin Name: Solid Code Theme Editor
Plugin URI: http://solid-code.co.uk/2011/08/solid-code-theme-editor/
Description: Adds a special editor to the theme editor with more functionality
Version: 1.1.0
Author: Dagan Lev
Author URI: http://solid-code.co.uk

Copyright 2011  Dagan Lev  (email : daganlev@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit('no access'); // disable direct access
}

//add actions
add_action( 'admin_menu', 'scte_add_theme_page' );
add_action('admin_print_scripts', 'scte_scripts');
add_action('admin_print_styles', 'scte_styles');
add_action('template_redirect', 'scte_redirect_special');

function scte_redirect_special(){
	//download file
	if(preg_match('/solid-code-theme-editor\/downloadfile\//',$_SERVER["REQUEST_URI"],$main_id)){
		include(WP_PLUGIN_DIR . '/solid-code-theme-editor/sc-theme-downloader.php');
		exit;
	}
	//download theme backup
	if(preg_match('/solid-code-theme-editor\/downloadbackup\//',$_SERVER["REQUEST_URI"],$main_id)){
		include(WP_PLUGIN_DIR . '/solid-code-theme-editor/sc-theme-backup.php');
		exit;
	}
}

function scte_add_theme_page() {
	add_theme_page('Solid Code Theme Editor', 'SC Theme Editor','edit_themes', 'scte-theme-editor', 'scte_theme_editor_page');
}

function scte_styles(){
	if(isset($_GET['page']) && $_GET['page']=='scte-theme-editor'){
		$pluginURL = WP_PLUGIN_URL;
		if(is_ssl()){
			$pluginURL = str_ireplace("http://","https://",$pluginURL);
		}
		wp_register_style('scte-style', $pluginURL.'/solid-code-theme-editor/scte-style.css');
		wp_enqueue_style('scte-style');
	}
}
function scte_scripts(){
	if(isset($_GET['page']) && $_GET['page']=='scte-theme-editor'){
		$pluginURL = WP_PLUGIN_URL;
		if(is_ssl()){
			$pluginURL = str_ireplace("http://","https://",$pluginURL);
		}
		wp_register_script('scte_script', $pluginURL.'/solid-code-theme-editor/scte-script.js', array('jquery'));
		wp_enqueue_script('scte_script');
	}
}

function scte_theme_editor_page(){
	if ( !current_user_can('edit_themes') )
		wp_die('<p>'.__('You do not have sufficient permissions to edit templates for this site.').'</p>');
	
	$pluginURL = WP_PLUGIN_URL;
	if(is_ssl()){
		$pluginURL = str_ireplace("http://","https://",$pluginURL);
	}
	
	$allowedFileExt = array('less','php','css','js','xml','html','htm','txt','sql');
	$themes = wp_get_themes();
	
	$file = '';
	$theme = '';
	
	if(!isset($_GET['theme'])){
		$theme = wp_get_theme();
	}else{
		$theme = wp_get_theme(urldecode($_GET['theme']));
	}
	//default file to style.css
	if(!isset($_GET['file'])){
		$file = '/style.css';
	}else{
		$file = str_ireplace("../","",$_GET['file']);
	}

	//delete file
	if(isset($_GET['delfile'])){
		$delfile = $theme->get_stylesheet_directory() . $file;
		if(file_exists($delfile)){
			unlink($delfile);
			echo '<script type="text/javascript">
				<!--
				window.location = \'themes.php?page=scte-theme-editor&theme=' . urlencode($theme->get_stylesheet()) . '\';
				//-->
				</script>';
			exit();
		}
	}
	
	//create new file in current directory
	$chkfrm = '';
	if(isset($_POST['newfilename'])){
		if(preg_match('/^([\w\-]*)\.([\w\-]*)$/',$_POST['newfilename'],$filematches)){
			if(in_array($filematches[2],$allowedFileExt)){
				$newfile = $theme->get_stylesheet_directory() . str_ireplace(end(explode("/",$file)),"",$file) . $_POST['newfilename'];
				if(!file_exists($newfile)){
					$ourFileHandle = fopen($newfile, 'w') or $chkfrm = 'Error creating file...';
					fclose($ourFileHandle);
					echo '<script type="text/javascript">
						<!--
						window.location = \'themes.php?page=scte-theme-editor&theme=' . urlencode($theme->get_stylesheet()) . '&file=' . urlencode(str_ireplace(end(explode("/",$file)),"",$file) . $_POST['newfilename']) . '&created=1\';
						//-->
						</script>';
					exit();
				}else{
					$chkfrm = 'File Already Exists...';
				}
			}else{
				$chkfrm = 'Invalid file name, please enter file with valid extension (no spaces or wierd characters)<br />(valid extensions: '. implode(", ",$allowedFileExt) .')';
			}
		}else{
			$chkfrm = 'Invalid file name, please enter file with valid extension (no spaces or wierd characters)<br />(valid extensions: '. implode(", ",$allowedFileExt) .')';
		}
	}
	
	//save file content
	if(isset($_POST['newcontent'])){
		$newcontent = stripslashes($_POST['newcontent']);
		if (is_writeable($theme->get_stylesheet_directory() . '/' . $file)) {
			//is_writable() not always reliable, check return value. see comments @ http://uk.php.net/is_writable
			$f = fopen($theme->get_stylesheet_directory() . '/' . $file, 'w+');
			if ($f !== FALSE) {
				fwrite($f, $newcontent);
				fclose($f);
				echo '<script type="text/javascript">
					<!--
					window.location = \'themes.php?page=scte-theme-editor&theme=' . urlencode($theme->get_stylesheet()) . '&file=' . urlencode($file) . '&saved=1\';
					//-->
					</script>';
				exit();
			}
		}		
	}
	?>
	<div class="wrap">
	<div id="icon-themes" class="icon32"><br /></div><h2>Solid Code Theme Editor</h2>
	<p><b style="color:red;">WARNING!!!</b> - changing Theme files may harm your WordPress Site installation, please do not proceed unless you know exactly what you are doing.</p>
	<?php
	if(isset($_GET['saved'])){
		echo '<div id="message" class="updated"><p>File edited successfully.</p></div>';
	}
	if(isset($_GET['created'])){
		echo '<div id="message" class="updated"><p>File created successfully.</p></div>';
	}
	if($chkfrm!=''){
		echo '<div id="message" class="error"><p>'.$chkfrm.'</p></div>';
	}
	?>
		<div class="fileedit-sub">
			<div class="alignleft">
			<h3 style="margin-top:0px;"><?php echo $theme->Name; ?> - <span style="font-weight:normal;"><?php echo $file; ?></span></h3>
			</div>
			<div class="alignright">
				<form action="themes.php?page=scte-theme-editor" method="get">
					<input type="hidden" name="page" id="page1" value="<?php echo $_GET['page']; ?>" />
					<strong><label for="theme">Select theme to edit: </label></strong>
					<select name="theme" id="theme1">
						<?php
						foreach($themes as $stheme){
							if($theme->Name==$stheme['Name']){
								echo '<option selected="selected" value="'. ($stheme->parent() ? '' : $stheme->template) .'">'. $stheme['Name'] . ($stheme->parent() ? '' : '') .  '</option>';
							}else{
								if(!$stheme->parent()){
									echo '<option value="'. ($stheme->parent() ? '' : $stheme->template) .'">'. $stheme['Name']  . '</option>';	
								}
							}
						}
						?>
					</select>
					<input type="submit" name="Submit" id="Submit" class="button" value="Select" />
				</form>
			</div>
			<br class="clear" />
		</div>
		
		<?php
		$content = '';
		$urlFile = $file;
		$file = $theme->get_stylesheet_directory() . '/' . $file;
		if(file_exists($file)){
			//check valid ext
			$fxt = explode('.',$file);
			if(in_array($fxt[count($fxt)-1],$allowedFileExt)){
				$content = esc_textarea( file_get_contents($file) );
			}
		}else{
			$content = 'File does not exist...';
		}
		?>
		<div class="scte_content_left">
			<ul>
				<li style="float:left;"><a href="<?php echo (is_multisite() ? '': $pluginURL); ?>/solid-code-theme-editor/downloadfile/?theme=<?php echo urlencode($theme->get_stylesheet()); ?>&amp;file=<?php echo urlencode($urlFile); ?>">Download File</a></li>
				<li style="float:left;margin-left:20px;"><a href="<?php echo (is_multisite() ? '': $pluginURL); ?>/solid-code-theme-editor/downloadbackup/?theme=<?php echo urlencode($theme->get_stylesheet()); ?>">Download Whole Theme</a> (ZIP)</li>
			</ul>
			<div style="clear:both;"><!-- EMPTY --></div>
			<form id="newfile" name="newfile" method="post" action="themes.php?page=scte-theme-editor&amp;theme=<?php echo urlencode($theme->get_stylesheet()); ?>&amp;file=<?php echo urlencode($urlFile); ?>">
				<input type="text" size="50" id="newfilename" name="newfilename" value="Enter file name" />&nbsp;<input type="submit" value="Create File in current directory" class="button" />
				<p>&nbsp;</p>
			</form>
			<div style="clear:both;"><!-- EMPTY --></div>
			<form name="textarea_form" id="textarea_form" method="post" action="themes.php?page=scte-theme-editor&amp;theme=<?php echo urlencode($theme->get_stylesheet()); ?>&amp;file=<?php echo urlencode($urlFile); ?>">
				<?php if(in_array($fxt[count($fxt)-1],$allowedFileExt)){ ?>
					<textarea style="display:none;" wrap="off" cols="70" rows="25" name="newcontent" id="newcontent" tabindex="1"><?php echo $content; ?></textarea>
					<div id="editor" style="z-index:100;position: relative;width: 100%;height: 600px;"><?php echo $content; ?></div>
					<script src="<?php echo $pluginURL; ?>/solid-code-theme-editor/ace/ace.js" type="text/javascript" charset="utf-8"></script>
					<script src="<?php echo $pluginURL; ?>/solid-code-theme-editor/ace/mode-javascript.js" type="text/javascript" charset="utf-8"></script>
					<script src="<?php echo $pluginURL; ?>/solid-code-theme-editor/ace/mode-css.js" type="text/javascript" charset="utf-8"></script>
					<script src="<?php echo $pluginURL; ?>/solid-code-theme-editor/ace/mode-html.js" type="text/javascript" charset="utf-8"></script>
					<script src="<?php echo $pluginURL; ?>/solid-code-theme-editor/ace/mode-php.js" type="text/javascript" charset="utf-8"></script>
					<script src="<?php echo $pluginURL; ?>/solid-code-theme-editor/ace/mode-sql.js" type="text/javascript" charset="utf-8"></script>
					<script src="<?php echo $pluginURL; ?>/solid-code-theme-editor/ace/mode-text.js" type="text/javascript" charset="utf-8"></script>
					<script src="<?php echo $pluginURL; ?>/solid-code-theme-editor/ace/mode-xml.js" type="text/javascript" charset="utf-8"></script>
					<script src="<?php echo $pluginURL; ?>/solid-code-theme-editor/ace/theme-chrome.js" type="text/javascript" charset="utf-8"></script>
					<script type="text/javascript">
						<!--
						jQuery(document).ready(function(){
							if(jQuery.browser.msie){
								jQuery('#newcontent').show();
								jQuery('#editor').hide();
							}else{
								var editor = ace.edit("editor");

								editor.getSession().on('change', function(){
									jQuery('#newcontent').val(editor.getSession().getValue());
								});
								
								var mode = '<?php
									//identify mode
									$fileExt2 = explode(".",$file);
									$fileExt = end($fileExt2);
									switch($fileExt){
										case 'js':
											echo 'javascript';
											break;
										case 'css':
											echo 'css';
											break;
										case 'less':
											echo 'less';
											break;
										case 'html':
											echo 'html';
											break;
										case 'htm':
											echo 'html';
											break;
										case 'php':
											echo 'php';
											break;
										case 'sql':
											echo 'sql';
											break;
										case 'xml':
											echo 'xml';
											break;
										default:
											echo 'text';
											break;
									}
								?>';
								editor.getSession().setMode("ace/mode/" + mode);
								editor.setTheme("ace/theme/chrome");
							}
						});
						//-->
					</script>
					<p>
					<input type="submit" name="submit" id="submit" class="button-primary" value="Update File" tabindex="2" />
					</p>
				<?php }else{
					echo '<p>File does not match allowed file extension ' . join(',',$allowedFileExt) . '</p>';
				} ?>
			</form>
		</div>
		<div class="scte_content_right">
			<div class="scte_inside_right">
				<h2>Files</h2>
				<?php
				//loop through all theme files
				echo scte_loopThroughFiles($theme->get_stylesheet_directory(),$theme->get_stylesheet_directory(),$theme->get_stylesheet(),$urlFile);
				?>
			</div>
		</div>
		<div style="clear:both;"><!-- empty --></div>
	</div>
	<?php
}

function scte_loopThroughFiles($maindir,$dir,$theme,$sfile){
	$strtmp = '';
	$strtmpdir = '';
	if (file_exists($dir)) {
		if(str_ireplace(str_ireplace($maindir,'',$dir),'',$sfile) != $sfile){
			$strtmpdir = '<ul class="scte_show">';
		}else{
			$strtmpdir = '<ul>';         
		}
		$files=glob($dir.'/*');
		sort($files);

		foreach($files as $file){
			$file=str_replace($dir.'/','',$file);
			if ($file != "." && $file != ".." && $file != ".svn") {
				if(is_dir($dir . '/' . $file)){
					$strtmpdir .= '<li>' . $file . scte_loopThroughFiles($maindir,$dir . '/'. $file,$theme,$sfile) . '</li>';       
				}else{
					if($sfile==(str_ireplace($maindir,'',$dir . '/') . $file)){
						$strtmp .= '<li><a href="JavaScript:SCTE_delFile(\''.urlencode($theme).'\',\''.urlencode(str_ireplace($maindir,'',$dir . '/') . $file).'\');">Delete</a>&nbsp;|&nbsp;<a class="scte_selected_file" href="themes.php?page=scte-theme-editor&amp;theme='.urlencode($theme).'&amp;file='.urlencode(str_ireplace($maindir,'',$dir . '/') . $file).'">' .$file. '</a></li>';	
					}else{
						$strtmp .= '<li><a href="JavaScript:SCTE_delFile(\''.urlencode($theme).'\',\''.urlencode(str_ireplace($maindir,'',$dir . '/') . $file).'\');">Delete</a>&nbsp;|&nbsp;<a href="themes.php?page=scte-theme-editor&amp;theme='.urlencode($theme).'&amp;file='.urlencode(str_ireplace($maindir,'',$dir . '/') . $file).'">' .$file. '</a></li>';		
					}
				}
			}
		}
		$strtmp = $strtmpdir . $strtmp . '</ul>';
	}
	return $strtmp;
}
?>