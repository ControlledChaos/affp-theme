<?php
/**
 * The template for displaying the footer
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

// Get the site name.
$site_name = esc_attr( get_bloginfo( 'name' ) );

// Copyright HTML.
$copyright = sprintf(
	'<p class="copyright-text" itemscope="itemscope" itemtype="http://schema.org/CreativeWork">&copy; <span class="screen-reader-text">%1s</span><span itemprop="copyrightYear">%2s</span> <span itemprop="copyrightHolder">%3s.</span> %4s.</p>',
	esc_html__( 'Copyright ', 'affp-theme' ),
	get_the_time( 'Y' ),
	$site_name,
	esc_html__( 'All rights reserved', 'affp-theme' )
); ?>

	</div>

	<footer id="colophon" class="site-footer">
		<div class="footer-content global-wrapper footer-wrapper">
				<?php echo $copyright; ?>
		</div>
	</footer>
</div>

<?php AFFP_Theme\Tags\after_page(); ?>
<?php wp_footer(); ?>
<script>
jQuery(window).load( function () {
	jQuery('html').addClass('site-loaded');
    jQuery('.loader').fadeOut(350);
});
</script>
</body>
</html>