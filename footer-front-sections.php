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
				<?php echo $copyright; ?></div>
	</footer>
</div>

<?php AFFP_Theme\Tags\after_page(); ?>
<?php wp_footer(); ?>
<script>
jQuery(document).ready( function($) {

	// Instantiate Slick slider for the intro slideshow.
	$( '.intro-slides' ).slick({
		arrows         : false,
		dots           : false,
		slidesToScroll : 1,
		autoplay       : true,
		autoplaySpeed  : 4200,
		infinite       : true,
		adaptiveHeight : false,
		speed          : 1200,
		pauseOnHover   : false,
		fade           : true,
		cssEase        : 'ease-in-out'
	});

	// Instantiate Slick slider for the featured projects carousel.
	$( '.featured-projects-slider' ).slick({
		arrows         : true,
		dots           : false,
		slidesToShow   : 1,
		slidesToScroll : 1,
		autoplay       : false,
		infinite       : true,
		adaptiveHeight : true,
		speed          : 300,
		pauseOnHover   : false,
		fade           : false,
		cssEase        : 'ease-in-out',
		nextArrow      : '<button class="slick slick-next tooltip" title="<?php _e( 'Next Project', 'affp-theme' ); ?>"><span class="screen-reader-text"><?php _e( 'Next Project', 'affp-theme' ); ?></span></button>',
		prevArrow      : '<button class="slick slick-prev tooltip" title="<?php _e( 'Previous Project', 'affp-theme' ); ?>"><span class="screen-reader-text"><?php _e( 'Previous Project', 'affp-theme' ); ?></span></button>'
	});
});
</script>
<script>
// Load FullPage JS scripts.
<?php echo file_get_contents( get_theme_file_uri( '/assets/js/scrolloverflow.min.js' ) ); ?>
<?php echo file_get_contents( get_theme_file_uri( '/assets/js/fullpage.min.js' ) ); ?>

jQuery(document).ready( function($) {

	// Instantiate FullPage JS and add options.
	$( '#front-page-sections' ).fullpage({
		anchors         : [ 'splash',<?php if ( have_rows( 'front_page_sections' ) ) : while ( have_rows( 'front_page_sections' ) ) : the_row(); $slug = get_sub_field( 'fp_section_slug' ); $menuanchor = str_replace( ' ', '', $slug ); echo "'" . $menuanchor . "',"; endwhile; endif; ?> ],
		lockAnchors     : true,
		menu            : '#site-navigation',
		navigation      : false,
		scrollingSpeed  : 550,
		css3            : true,
		easing          : 'easeInOutCubic',
		controlArrows   : true,
		sectionSelector : '.front-page-section',
		dragAndMove     : true,
		slideSelector   : false,
		scrollOverflow  : true,
		afterRender     : function() {
			$( 'html' ).addClass( 'site-loaded' );
			$( '.loader' ).fadeOut( 350 );
		},
		afterLoad: function( origin, destination, direction ) {
			var loadedSection = this;

			// Add .section-viewed class by slug/class when leaving a section.
			<?php if ( have_rows( 'front_page_sections' ) ) : while ( have_rows( 'front_page_sections' ) ) : the_row(); $slug = get_sub_field( 'fp_section_slug' ); $menuanchor = str_replace( ' ', '', $slug );
			echo "if (origin.anchor == '" . $menuanchor . "') { $('." . $menuanchor . "').addClass('section-viewed'); }"; endwhile; endif; ?>
		}
	});

	// Make FullPage work with id attributes for no JS navigation fallback.
	$( '.main-navigation ul li a' ).click( function() {
		let newSlide = $(this).closest( 'li' ).data( 'menuanchor' )
		$.fn.fullpage.moveTo( newSlide, 1 );
	});

	// Intro down arrow link.
	$( '#intro-entry-link' ).click( function() {
		fullpage_api.moveSectionDown();
	});

	// Toggle the side menu.
	$( '#side-menu-toggle' ).click( function() {
		$( '.secondary-nav' ).addClass( 'open' );
		$( '#menu-open' ).attr( 'aria-expanded', function ( i, attr ) {
			return attr == 'true' ? 'false' : 'true'
		});
		$( '.body-overlay' ).addClass( 'menu-open' );
	});
	$( '#menu-close' ).click( function() {
		$( '.secondary-nav' ).removeClass( 'open' );
		$( '.body-overlay' ).removeClass( 'menu-open' );
	});

	/**
	 * Add Tooltipster
	 *
	 * Uses the title attribute in elements with the .tooltip class.
	 */
	$( '.tooltip' ).tooltipster({
		delay : 150,
		animationDuration : 150,
		theme : 'affp-tooltips'
	});
});
</script>
</body>
</html>