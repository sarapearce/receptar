<?php
/**
 * The template for the footer widget area
 *
 * @package DW Mono
 * @since DW Mono 1.0.0
 */
?>

<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) ) : ?>
<div id="footer-widgets" class="widget-area" role="complementary">
	<div class="container-fluid">
		<div class="row row-eq-height">
		<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
			<div class="col-lg-4"><?php dynamic_sidebar( 'footer-1' ); ?></div>
		<?php endif; ?>
		<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
			<div class="col-lg-4"><?php dynamic_sidebar( 'footer-2' ); ?></div>
		<?php endif; ?>
		<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
			<div class="col-lg-4"><?php dynamic_sidebar( 'footer-3' ); ?></div>
		<?php endif; ?>
		</div>
	</div>
</div>
<?php endif; ?>
