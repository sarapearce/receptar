<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package DW Mono
 * @since DW Mono 1.0.0
 */
?>

<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
<div id="secondary" class="widget-area navmenu navmenu-inverse navmenu-fixed-left offcanvas" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div>
<?php endif; ?>
