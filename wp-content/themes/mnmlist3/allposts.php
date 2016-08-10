<?php
/**
 * @package WordPress
 * @subpackage mnmlist
 */
/*
Template Name: allposts
*/
?>

<?php get_header(); ?>

	<div id="content">
		<div class="post" id="post-<?php the_ID(); ?>">

 
			<h2><a href="/">mnmlist</a> : <b>archives</b></h2>

			<div class="entry">

<script type="text/javascript">

var domainroot="mnmlist.com"

function Gsitesearch(curobj){
curobj.q.value="site:"+domainroot+" "+curobj.qfront.value
}

</script>


<form action="http://www.google.com/search" method="get" onSubmit="Gsitesearch(this)">

<p>search:<br />
<input name="q" type="hidden" class="texta" />
<input name="qfront" type="text" class="texta" style="width: 180px; text-size: 12px; height: 12px;" /> </p>

</form>

	
	<strong>Categories:</strong><br />
	<a href="http://mnmlist.com/category/meta/">meta</a> : <a href="http://mnmlist.com/category/contentedness/">contentedness</a> : <a href="http://mnmlist.com/category/doing/">doing</a> : <a href="http://mnmlist.com/category/mind/">mind</a>
	<br /><a href="http://mnmlist.com/category/possessions/">possessions</a> : <a href="http://mnmlist.com/category/sustainable/">sustainable</a> : <a href="http://mnmlist.com/category/tech/">tech</a>

	<br />

<table id=arc>
<?php
$query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) as `month`, DAYOFMONTH(post_date) as `dayofmonth`, ID, post_name, post_title FROM $wpdb->posts WHERE post_type = 'post' AND post_status = 'publish' ORDER BY post_date DESC";
$key = md5($query);
$cache = wp_cache_get( 'mp_archives' , 'general');
if ( !isset( $cache[ $key ] ) ) {
  $arcresults = $wpdb->get_results($query);
  $cache[ $key ] = $arcresults;
  wp_cache_add( 'mp_archives', $cache, 'general' );
} else {
  $arcresults = $cache[ $key ];
}
if ($arcresults) {
  $last_year = 0;
  $last_month = 0;
  foreach ( $arcresults as $arcresult ) {
    $year = $arcresult->year;
    $month = $arcresult->month;
    if ($year != $last_year) {
      $last_year = $year;
      $last_month = 0;
?>
<tr class=year><th><br /><br /><?php echo $arcresult->year; ?></th></tr>
<?php
    }
    if ($month != $last_month) {
      $last_month = $month;
?>
<tr class=archive><th><?php echo $wp_locale->get_month($arcresult->month); ?></th><td></td></tr>
<?php
    }
?>
<tr class=archive><th><?php echo $arcresult->dayofmonth; ?></th><td id=p<?php echo $arcresult->ID; ?>><a href="/<?php echo $arcresult->post_name; ?>"><?php echo strip_tags(apply_filters('the_title', $arcresult->post_title)); ?></a></td></tr>
<?php
  }
}
?>
</table>
</div>
</div>
</div>


<?php get_footer(); ?>