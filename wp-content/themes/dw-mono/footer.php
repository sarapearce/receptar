
		<footer id="colophon" class="site-footer" role="contentinfo">
			<?php get_sidebar( 'footer' ); ?>
			<div class="site-info">
				<?php printf( __( 'Copyright &copy; %1$s by %2$s.', 'dw-mono' ), esc_attr( date( 'Y' ) ), '<a href="' . home_url() . '" rel="designer">' . get_bloginfo( 'name' ) . '</a>' ); ?>
				<?php printf( __( 'Theme: %1$s by %2$s.', 'dw-mono' ), '<a href="http://www.designwall.com/wordpress/themes/dw-mono/">DW Mono</a>', '<a href="http://www.designwall.com" rel="designer">DesignWall</a>' ); ?><br>
				<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'dw-mono' ) ); ?>"><?php printf( __( 'Proudly powered by %s', 'dw-mono' ), 'WordPress' ); ?></a>
			</div>
			<a href="#primary" class="smooth-scroll back-to-top"><i class="fa fa-angle-up"></i></a>
		</footer>
	</div>
</div>

<?php get_sidebar(); ?>
<?php wp_footer(); ?>

</body>
</html>
