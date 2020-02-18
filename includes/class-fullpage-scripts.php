<?php
/**
 * Front page scripts
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

namespace AFFP_Theme\Includes\Scripts;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Front page scripts class
 *
 * @since  1.0.0
 * @access public
 */
class FullPage_Scripts {

	/**
	 * Constructor magic method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		add_action( 'affp_scripts', [ $this, 'full_page' ] );
		add_action( 'affp_scripts', [ $this, 'intro_slides' ] );
		add_action( 'affp_scripts', [ $this, 'projects_slides' ] );

	}

	/**
	 * FullPageJS
	 *
	 * Instantiation, options, & events.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns a script block.
	 */
	public function full_page() {

		?>
		<script>
		// Load FullPage JS scripts.
		<?php echo file_get_contents( get_theme_file_uri( '/assets/js/scrolloverflow.min.js' ) ); ?>
		<?php echo file_get_contents( get_theme_file_uri( '/assets/js/fullpage.min.js' ) ); ?>

		jQuery(document).ready( function($) {

			// Instantiate FullPage JS and add options.
			$( '#front-page-sections' ).fullpage({
				anchors         : [ 'splash',<?php if ( have_rows( 'front_page_sections' ) ) : while ( have_rows( 'front_page_sections' ) ) : the_row(); $slug = get_sub_field( 'fp_section_slug' ); $anchor = str_replace( ' ', '', strtolower( $slug ) ); echo "'" . $anchor . "',"; endwhile; endif; ?> ],
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

					/**
					 * Add .section-viewed class by slug/class when leaving a section.
					 * This class is used to stop various transforms, transitions, etc
					 * when the section is first viewed.
					 */
					$( '.splash' ).addClass( 'section-viewed' );
					<?php if ( have_rows( 'front_page_sections' ) ) : while ( have_rows( 'front_page_sections' ) ) : the_row(); $slug = get_sub_field( 'fp_section_slug' ); $section = str_replace( ' ', '', strtolower( $slug ) );
					echo "if (origin.anchor == '" . $section . "') { $('." . $section . "').addClass('section-viewed'); }"; endwhile; endif; ?>
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
		});
		</script>
		<?php

	}

	/**
	 * Intro slideshow
	 *
	 * Uses Slick slider JS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns a script block.
	 */
	public function intro_slides() {

	?>
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
	});
	</script>
	<?php

	}

	/**
	 * Featured Projects carousel
	 *
	 * Uses Slick slider JS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns a script block.
	 */
	public function projects_slides() {

		?>
		<script>
		jQuery(document).ready( function($) {

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
		<?php

	}
}