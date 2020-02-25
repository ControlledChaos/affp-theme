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

		// Disabled. Instantiating sliders on FullPage afterRender event.
		// add_action( 'affp_scripts', [ $this, 'intro_slides' ] );
		// add_action( 'affp_scripts', [ $this, 'featured_slides' ] );

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

		/**
		 * Navigation between sections.
		 *
		 * Uses the "slug" subfield from the ACF flexible content fields.
		 * The intro slides slug is static as "splash".
		 */

		// Intro slides section slug.
		$menu = "'splash',";

		// Loop through flexible content fields for the "slug" subfield.
		if ( have_rows( 'front_page_sections' ) ) : while ( have_rows( 'front_page_sections' ) ) : the_row();

		// Get the "slug" subfield.
		$slug = wp_strip_all_tags( get_sub_field( 'fp_section_slug' ) );

		// Eliminate any spaces entered into the field.
		$anchor = str_replace( ' ', '', strtolower( $slug ) );
		$menu  .=  "'" . $anchor . "',";

		// End loop.
		endwhile; endif;

		/**
		 * Add .section-viewed class by slug/class when leaving a section.
		 *
		 * This class is used to stop various transforms, transitions, etc
		 * when the section is first viewed.
		 */
		$viewed = '$( ".splash" ).addClass( "section-viewed" );' . "\r";

		// Loop through flexible content fields for the "slug" subfield.
		if ( have_rows( 'front_page_sections' ) ) : while ( have_rows( 'front_page_sections' ) ) : the_row();

		// Get the "slug" subfield.
		$slug = wp_strip_all_tags( get_sub_field( 'fp_section_slug' ) );

		// Eliminate any spaces entered into the field.
		$section = str_replace( ' ', '', strtolower( $slug ) );
		$viewed .= "if (origin.anchor == '" . $section . "') { $('." . $section . "').addClass('section-viewed'); }" . "\r";
		endwhile; endif;

		// Slick slider arrows.
		$slider_prev = sprintf(
			'<button class="slick slick-next tooltip" title="%1s"><span class="screen-reader-text">%2s</span></button>',
			__( 'Previous', 'affp-theme' ),
			__( 'Previous', 'affp-theme' )
		);
		$slider_next = sprintf(
			'<button class="slick slick-prev tooltip" title="%1s"><span class="screen-reader-text">%2s</span></button>',
			__( 'Next', 'affp-theme' ),
			__( 'Next', 'affp-theme' )
		);

		?>
		<script>
		// Load FullPage JS scripts.
		<?php echo file_get_contents( get_theme_file_uri( '/assets/js/scrolloverflow.min.js' ) ); ?>
		<?php echo file_get_contents( get_theme_file_uri( '/assets/js/fullpage.min.js' ) ); ?>

		jQuery(document).ready( function($) {

			// Instantiate FullPage JS and add options.
			$( '#front-page-sections' ).fullpage({
				anchors         : [ <?php echo $menu; ?> ],
				lockAnchors      : true,
				menu             : '#site-navigation',
				navigation       : false,
				scrollingSpeed   : 550,
				css3             : true,
				easing           : 'easeInOutCubic',
				controlArrows    : true,
				sectionSelector  : '.front-page-section',
				verticalCentered : true,
				paddingTop       : '60px',
				paddingBottom    : '0px',
				responsiveHeight : 560,
				dragAndMove      : true,
				slideSelector    : false,
				scrollOverflow   : true,
				scrollOverflowReset : true,
				afterRender      : function() {
					$( 'html' ).addClass( 'site-loaded' );
					$( '.loader' ).fadeOut( 350 );

					// Instantiate Slick slider for the intro slideshow.
					$( '.intro-slides' ).slick({
						arrows         : false,
						dots           : false,
						slidesToScroll : 1,
						autoplay       : true,
						autoplaySpeed  : 3000, // Match CSS animation timing on .slick-slide.active, _front-page.scss.
						infinite       : true,
						adaptiveHeight : false,
						speed          : 1800,
						pauseOnHover   : false,
						fade           : true,
						cssEase        : 'ease-in-out'
					});

					// Instantiate Slick slider for the featured projects carousel.
					$( '.featured-projects-slider, .featured-press-slider' ).slick({
						arrows         : true,
						dots           : false,
						slidesToShow   : 1,
						slidesToScroll : 1,
						// swipeToSlide   : true,
						draggable      : true,
						touchThreshold : 5,
						autoplay       : false,
						infinite       : true,
						adaptiveHeight : true,
						speed          : 300,
						pauseOnHover   : false,
						fade           : false,
						cssEase        : 'ease-in-out',
						zIndex         : 3500,
						nextArrow      : '<?php echo $slider_next; ?>',
						prevArrow      : '<?php echo $slider_prev; ?>',
						responsive     : [

							// Destroy slick at 640px and less.
							{
								breakpoint : 640,
								settings   : 'unslick'
							}
						]
					});

					// Add the .subsection-viewed class upon leaving a slide/section.
					$( '.featured-projects-slider, .featured-press-slider' ).on('afterChange', function( event, slick, currentSlide, nextSlide ) {
						var viewed = currentSlide;
						$( '.subsection' ).eq( viewed ).addClass( 'subsection-viewed' );
					});

					$( '.tooltip, .fancybox-toolbar .fancybox-button' ).tooltipster({
						delay : 150,
						animationDuration : 150,
						theme : 'affp-tooltips'
					});
				},
				afterLoad: function( origin, destination, direction ) {
					var loadedSection = this;

					/**
					 * Add .section-viewed class by slug/class when leaving a section.
					 *
					 * This class is used to stop various transforms, transitions, etc
					 * when the section is first viewed.
					 */
					<?php echo $viewed; ?>
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
			autoplaySpeed  : 8000, // Match CSS animation timing on .slick-slide.active, _front-page.scss.
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
	 * Featured post types carousels
	 *
	 * Uses Slick slider JS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns a script block.
	 */
	public function featured_slides() {

		?>
		<script>
		jQuery(document).ready( function($) {

			// Instantiate Slick slider for the featured carousels.
			$( '.featured-projects-slider, .featured-press-slider' ).slick({
				arrows         : true,
				dots           : false,
				slidesToShow   : 1,
				slidesToScroll : 1,
				swipeToSlide   : true,
				draggable      : true,
				touchThreshold : 5,
				autoplay       : false,
				infinite       : true,
				adaptiveHeight : true,
				speed          : 300,
				pauseOnHover   : false,
				fade           : false,
				cssEase        : 'ease-in-out',
				zIndex         : 3500,
				nextArrow      : '<button class="slick slick-next tooltip" title="<?php _e( 'Next Project', 'affp-theme' ); ?>"><span class="screen-reader-text"><?php _e( 'Next Project', 'affp-theme' ); ?></span></button>',
				prevArrow      : '<button class="slick slick-prev tooltip" title="<?php _e( 'Previous Project', 'affp-theme' ); ?>"><span class="screen-reader-text"><?php _e( 'Previous Project', 'affp-theme' ); ?></span></button>'
			});

			// Add the .subsection-viewed class upon leaving a slide/section.
			$( '.featured-projects-slider, .featured-press-slider' ).on('afterChange', function( event, slick, currentSlide, nextSlide ) {
				var viewed = currentSlide;
				$( '.subsection' ).eq( viewed ).addClass( 'subsection-viewed' );
			});
		});
		</script>
		<?php

	}
}