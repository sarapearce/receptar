<?php
header('HTTP/1.1 200 OK');

if ( ! defined( 'ABSPATH' ) ) {
    exit('no access'); // disable direct access
}

if ( !current_user_can('edit_themes') )
		wp_die('<p>'.__('You do not have sufficient permissions to edit templates for this site.').'</p>');

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

$content = '';
$urlFile = $file;
$file = $theme->get_stylesheet_directory() . '/' . $file;
if(file_exists($file)){
    $content = file_get_contents($file);
}else{
    $content = 'File does not exist...';
}
$filename = explode("/","/" . $urlFile);

$fsize = strlen($content);

header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header('Content-Description: File Transfer');
header("Content-Disposition: attachment; filename=" . $filename[count($filename)-1]);
header("Content-Length: ".$fsize);
header("Expires: 0");
header("Pragma: public");

echo $content;

exit;
?>