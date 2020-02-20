<?php
/**
 * Audrey Fisher FullPage functions
 *
 * A WordPress theme that integrates FullPage.JS into the front page.
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @author     Controlled Chaos Design <greg@ccdzine.com>
 * @copyright  Copyright (c) Controlled Chaos Design
 * @link       https://github.com/ControlledChaos/affp-theme
 * @license    http://www.gnu.org/licenses/gpl-3.0.html
 * @since      1.0.0
 */

// Namespace specificity for theme functions & filters.
namespace AFFP_Theme\Functions;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get plugins path
 *
 * Used to check for active plugins with the `is_plugin_active` function.
 *
 * @link https://developer.wordpress.org/reference/functions/is_plugin_active/
 *
 * @example The following would check for the Advanced Custom Fields plugin:
 *          ```
 *          if ( is_plugin_active( 'advanced-custom-fields/acf.php' ) ) {
 *          	// Do stuff.
 *           }
 *          ```
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Define the companion plugin path: directory and core file name.
 *
 * @since  1.0.0
 * @return string Returns the plugin path of the companion.
 */
if ( ! defined( 'AF_PLUGIN' ) ) {
	define( 'AF_PLUGIN', 'af-plugin/af-plugin.php' );
}

/**
 * Define the companion plugin name
 *
 * Used in admin notices.
 *
 * @since  1.0.0
 * @return string Returns the parent plugin name.
 */
if ( ! defined( 'AF_PLUGIN_NAME' ) ) {
	define( 'AF_PLUGIN_NAME', 'Audrey Fisher Plugin' );
}

/**
 * Check for plugin dependency
 *
 * Add an admin error notice if the companion plugin is not active.
 *
 * @link   https://github.com/ControlledChaos/af-plugin
 *
 * @since  1.0.0
 * @return void
 */
if ( ! is_plugin_active( AF_PLUGIN ) ) {
	add_action( 'admin_notices', function() {
		require_once get_parent_theme_file_path( '/includes/partials/companion-plugin-notice.php' );
	} );
}

/**
 * BS Theme functions class
 *
 * @since  1.0.0
 * @access public
 */
final class Functions {

	/**
	 * Return the instance of the class
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object
	 */
	public static function get_instance() {

		static $instance = null;

		if ( is_null( $instance ) ) {

			$instance = new self;

			// Theme activation & deactivation.
			$instance->activation();

			// Theme dependencies.
			$instance->dependencies();

		}

		return $instance;
	}

	/**
	 * Theme activation & deactivation functions
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	private function activation() {

		// Require theme activation functions.
		require_once get_theme_file_path( '/includes/class-activate.php' );

		// Require theme deactivation functions.
		require_once get_theme_file_path( '/includes/class-deactivate.php' );

	 }

	/**
	 * Constructor magic method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		// Swap html 'no-js' class with 'js'.
		add_action( 'wp_head', [ $this, 'js_detect' ], 0 );

		// Theme setup.
		add_action( 'after_setup_theme', [ $this, 'setup' ] );

		// Register widgets.
        add_action( 'widgets_init', [ $this, 'widgets' ] );

		// Disable custom colors in the editor.
		add_action( 'after_setup_theme', [ $this, 'editor_custom_color' ] );

		// Remove unpopular meta tags.
		add_action( 'init', [ $this, 'head_cleanup' ] );

		// Frontend scripts.
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_scripts' ] );

		// Footer scripts, add late.
		add_action( 'affp_scripts', [ $this, 'footer_scripts' ], 99 );

		// Admin scripts.
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );

		// Frontend styles.
		add_action( 'wp_enqueue_scripts', [ $this, 'frontend_styles' ] );

		/**
		 * Admin styles.
		 *
		 * Call late to override plugin styles.
		 */
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_styles' ], 99 );

		// Toolbar styles.
		add_action( 'wp_enqueue_scripts', [ $this, 'toolbar_styles' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'toolbar_styles' ], 99 );

		// Login styles.
		add_action( 'login_enqueue_scripts', [ $this, 'login_styles' ] );

		// jQuery UI fallback for HTML5 Contact Form 7 form fields.
		add_filter( 'wpcf7_support_html5_fallback', '__return_true' );

		// Remove prepend text from archive titles.
		add_filter( 'get_the_archive_title', [ $this, 'archive_title' ] );

		// Theme options page.
		add_action( 'admin_menu', [ $this, 'theme_options' ] );

		// Theme info page.
		add_action( 'admin_menu', [ $this, 'theme_info' ] );

		// User color scheme classes.
		add_filter( 'body_class', [ $this, 'color_scheme_classes' ] );

	}

	/**
	 * JS Replace
	 *
	 * Replaces 'no-js' class with 'js' in the <html> element
	 * when JavaScript is detected.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function js_detect() {

		echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";

	}

	/**
	 * Theme setup
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function setup() {

		/**
		 * Load domain for translation
		 *
		 * @since 1.0.0
		 */
		load_theme_textdomain( 'affp-theme' );

		/**
		 * Add theme support
		 *
		 * @since 1.0.0
		 */

		// Browser title tag support.
		add_theme_support( 'title-tag' );

		// Background color & image support.
		add_theme_support( 'custom-background' );

		// RSS feed links support.
		add_theme_support( 'automatic-feed-links' );

		// HTML 5 tags support.
		add_theme_support( 'html5', [
			'search-form',
			'comment-form',
			'comment-list',
			'gscreenery',
			'caption'
		 ] );

		/**
		 * Block editor colors
		 *
		 * Match the following HEX codes with SASS color variables.
		 * @see assets/css/_variables.scss
		 *
		 * @since 1.0.0
		 */
		$color_args = [
			[
				'name'  => __( 'Text', 'affp-theme' ),
				'slug'  => 'bst-text',
				'color' => '#333333',
			],
			[
				'name'  => __( 'Light Gray', 'affp-theme' ),
				'slug'  => 'bst-light-gray',
				'color' => '#888888',
			],
			[
				'name'  => __( 'Pale Gray', 'affp-theme' ),
				'slug'  => 'bst-pale-gray',
				'color' => '#cccccc',
			],
			[
				'name'  => __( 'White', 'affp-theme' ),
				'slug'  => 'bst-white',
				'color' => '#ffffff',
			],
			[
				'name'  => __( 'Error Red', 'affp-theme' ),
				'slug'  => 'bst-error',
				'color' => '#dc3232',
			],
			[
				'name'  => __( 'Warning Yellow', 'affp-theme' ),
				'slug'  => 'bst-warning',
				'color' => '#ffb900',
			],
			[
				'name'  => __( 'Success Green', 'affp-theme' ),
				'slug'  => 'bst-success',
				'color' => '#46b450',
			]
		];

		// Apply a filter to editor arguments.
		$colors = apply_filters( 'bst_editor_colors', $color_args );

		// Add theme color support.
		add_theme_support( 'editor-color-palette', $colors );

		/**
		 * Set default image sizes
		 *
		 * Define the dimensions and the crop options.
		 *
		 * @since 1.0.0
		 */
		// Featured image support.
		add_theme_support( 'post-thumbnails' );

		// Thumbnail size.
		update_option( 'thumbnail_size_w', 160 );
		update_option( 'thumbnail_size_h', 160 );
		update_option( 'thumbnail_crop', 1 );

		// Medium size.
		update_option( 'medium_size_w', 320 );
		update_option( 'medium_size_h', 240 );
		update_option( 'medium_crop', 1 );

		// Medium-large size.
		update_option( 'medium_large_size_w', 480 );
		update_option( 'medium_large_size_h', 360 );

		// Large size.
		update_option( 'large_size_w', 640 );
		update_option( 'large_size_h', 480 );
		update_option( 'large_crop', 1 );

		// Set the post thumbnail size, 16:9 HD Video.
		set_post_thumbnail_size( 1280, 720, [ 'center', 'center' ] );

		// Add wide image support for the block editor.
		add_theme_support( 'align-wide' );

		/**
		 * Add image sizes
		 *
		 * Three sizes per aspect ratio so that WordPress
		 * will use srcset for responsive images.
		 *
		 * @since 1.0.0
		 */

		// 1:1 square.
		add_image_size( __( 'large-thumbnail', 'affp-theme' ), 240, 240, true );
		add_image_size( __( 'xlarge-thumbnail', 'affp-theme' ), 320, 320, true );

		// 16:9 HD Video.
		add_image_size( __( 'large-video', 'affp-theme' ), 1280, 720, true );
		add_image_size( __( 'medium-video', 'affp-theme' ), 960, 540, true );
		add_image_size( __( 'small-video', 'affp-theme' ), 640, 360, true );

		// 21:9 Cinemascope.
		add_image_size( __( 'large-banner', 'affp-theme' ), 1280, 549, true );
		add_image_size( __( 'medium-banner', 'affp-theme' ), 960, 411, true );
		add_image_size( __( 'small-banner', 'affp-theme' ), 640, 274, true );

		/**
		 * Custom logo
		 *
		 * @since 1.0.0
		 */

		// Logo arguments.
		$logo_args = [
			'width'       => 160,
			'height'      => 160,
			'flex-width'  => true,
			'flex-height' => true
		];

		// Apply a filter to logo arguments.
		$logo = apply_filters( 'affp_header_image', $logo_args );

		// Add logo support.
		add_theme_support( 'custom-logo', $logo );

		 /**
		 * Set content width.
		 *
		 * @since 1.0.0
		 */
		$bs_content_width = apply_filters( 'bst_content_width', 1280 );

		if ( ! isset( $content_width ) ) {
			$content_width = $bs_content_width;
		}

		// Embed sizes.
		update_option( 'embed_size_w', 1280 );
		update_option( 'embed_size_h', 720 );

		/**
		 * Register theme menus.
		 *
		 * @since  1.0.0
		 */
		register_nav_menus( [
			'main'   => __( 'Main Menu', 'affp-theme' ),
			'footer' => __( 'Footer Menu', 'affp-theme' ),
			'social' => __( 'Social Menu', 'affp-theme' )
		] );

		/**
		 * Add stylesheet for the content editor.
		 *
		 * @since 1.0.0
		 */
		add_editor_style( '/assets/css/editor.min.css', [ 'bst-admin' ], '', 'screen' );

	}

	/**
	 * Style the header image and text
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns an HTML style block.
	 *
	 */
	public function header_style() {

		$header_text_color = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text. Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
			return;
		}

		// If we get this far, we have custom styles.
		if ( ! display_header_text() ) {
			$style = sprintf(
				'<style type="text/css">%1s</style>',
				'.site-title,
				 .site-title a,
				 .site-description {
					position: absolute;
					clip: rect(1px, 1px, 1px, 1px);
				}'
			);
		} else {
			$style = sprintf(
				'<style type="text/css">%1s</style>',
				'.site-title,
				 .site-title a,
				 .site-description {
					color: #' . esc_attr( $header_text_color ) . ';
				}'
			);
		}

		echo $style;
	}

	/**
	 * Register widgets
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function widgets() {

		// Add customizer widget refresh support.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Register sidebar widget area.
		register_sidebar( [
			'name'          => esc_html__( 'Sidebar', 'affp-theme' ),
			'id'            => 'sidebar',
			'description'   => esc_html__( 'Add widgets here.', 'affp-theme' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		] );

	}

	/**
	 * Theme support for disabling custom colors in the editor
	 *
	 * @since  1.0.0
	 * @access public
	 * @return bool Returns true for the color picker.
	 */
	public function editor_custom_color() {

		$disable = add_theme_support( 'disable-custom-colors', [] );

		// Apply a filter for conditionally disabling the picker.
		$custom_colors = apply_filters( 'bst_editor_custom_colors', '__return_false' );

		return $custom_colors;

	}

	/**
	 * Clean up meta tags from the <head>
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function head_cleanup() {

		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'wp_generator' );
	}

	/**
	 * Frontend scripts
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function frontend_scripts() {

		// Enqueue jQuery.
		wp_enqueue_script( 'jquery' );

		// Navigation toggle and dropdown.
		wp_enqueue_script( 'test-navigation', get_theme_file_uri( '/assets/js/navigation.min.js' ), [], null, true );

		// Skip link focus, for accessibility.
		wp_enqueue_script( 'affp-theme-skip-link-focus-fix', get_theme_file_uri( '/assets/js/skip-link-focus-fix.min.js' ), [], null, true );

		// FitVids for responsive video embeds.
		wp_enqueue_script( 'affp-theme-fitvids', get_theme_file_uri( '/assets/js/jquery.fitvids.min.js' ), [ 'jquery' ], null, true );
		wp_add_inline_script( 'affp-theme-fitvids', 'jQuery(document).ready(function($){ $( ".entry-content" ).fitVids(); });', true );

		// Front page scripts.
		if ( is_front_page() ) {
			// wp_enqueue_script( 'affp-scrolloverflow', get_theme_file_uri( '/assets/js/scrolloverflow.min.js' ), [], null, true );
			// wp_enqueue_script( 'affp-fullpage', get_theme_file_uri( '/assets/js/fullpage.extensions.min.js' ), [], null, true );
			// wp_enqueue_script( 'affp-easings', get_theme_file_uri( '/assets/js/easings.min.js' ), [], null, true );
		}

		// Comments scripts.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

	}

	/**
	 * Footer scripts
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function footer_scripts() {

		// Fancybox spinner template.
		$spinner = sprintf(
			'<div class="loader">
				<div class="spinner"></div>
				<div class="loading">
					<span class="screen-reader-text">%1s</span>
				</div>
			</div>',
			__( 'Loading image', 'affp-theme' )
		);

		?>
		<script>
		jQuery(document).ready( function($) {

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

			$( '[data-fancybox]' ).fancybox({
				infobar : false,
				buttons : [
					'zoom',
					'slideShow',
					'fullScreen',
					'download',
					'thumbs',
					'close'
				],
				spinnerTpl : '<div class="spinner"></div>',
				btnTpl : {
					arrowLeft :
						'<button data-fancybox-prev class="fancybox-button fancybox-button--arrow_left icon-left tooltip" title="{{PREV}}"></button>',

					arrowRight :
						'<button data-fancybox-next class="fancybox-button fancybox-button--arrow_right icon-right tooltip" title="{{NEXT}}"></button>'
				},
				afterShow: function( instance, slide ) {
					$( '.fancybox-button' ).tooltipster({
						delay : 150,
						animationDuration : 150,
						theme : 'affp-tooltips'
					});
				}
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

			// Unwrap Contact Form 7 fields.
			$( '.wpcf7-form input, .wpcf7-form textarea, .wpcf7-form select' ).unwrap();
		});
		</script>
		<?php if ( ! is_page_template( 'page-templates/front-page-sections.php' ) ) : ?>
		<script>
		// Fade out the loading screen.
		( function($) {
			$(window).load( function() {
				$( 'html' ).addClass( 'site-loaded' );
				$( '.loader' ).fadeOut(350);
			});
		})(jQuery);
		</script>
		<?php endif;

	}

	/**
	 * Admin scripts
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_scripts() {}

	/**
	 * Frontend styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function frontend_styles() {

		// Google fonts.
		// wp_enqueue_style( 'affp-theme-google-fonts', 'add-url-here', [], '', 'screen' );

		/**
		 * Theme sylesheet
		 *
		 * This enqueues the minified stylesheet compiled from SASS (.scss) files.
		 * The main stylesheet, in the root directory, only contains the theme header but
		 * it is necessary for theme activation. DO NOT delete the main stylesheet!
		 */
		wp_enqueue_style( 'affp-theme', get_theme_file_uri( '/assets/css/style.min.css' ), [], '', 'all' );

		// Google fonts.
		wp_enqueue_style( 'affp-google-fonts', get_theme_file_uri( 'https://fonts.googleapis.com/css?family=Nunito+Sans:300,300i,400,400i,700,700i&display=swap' ), [ 'affp-theme' ], '', 'all' );

		// Front page styles.
		if ( is_front_page() ) {
			wp_enqueue_style( 'affp-fullpage', get_theme_file_uri( '/assets/css/fullpage.min.css' ), [ 'affp-theme' ], '', 'screen' );
			wp_enqueue_style( 'affp-keyframes', get_theme_file_uri( '/assets/css/keyframes.min.css' ), [ 'affp-theme' ], '', 'screen' );
		}

		// Print styles.
		wp_enqueue_style( 'affp-theme-print', get_theme_file_uri( '/assets/css/print.min.css' ), [], '', 'print' );

	}

	/**
	 * Admin styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_styles() {

		// Google fonts.
		wp_enqueue_style( 'affp-google-fonts', get_theme_file_uri( 'https://fonts.googleapis.com/css?family=Nunito+Sans:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&display=swap' ), [ 'affp-theme' ], '', 'all' );

		wp_enqueue_style( 'affp-theme-admin', get_theme_file_uri( '/assets/css/admin.min.css' ), [], '' );

	}

	/**
	 * Toolbar styles
	 *
	 * Enqueues if user is logged in and admin bar is showing.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function toolbar_styles() {

		if ( is_user_logged_in() && is_admin_bar_showing() ) {
			wp_enqueue_style( 'affp-theme-toolbar', get_theme_file_uri( '/assets/css/toolbar.min.css' ), [], '' );
		}

	}

	/**
	 * Login styles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function login_styles() {

		wp_enqueue_style( 'custom-login', get_theme_file_uri( '/assets/css/login.css' ), [], '', 'screen' );

	}

	/**
	 * Theme dependencies
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function dependencies() {

		require get_theme_file_path( '/includes/template-functions.php' );
		require get_theme_file_path( '/includes/template-tags.php' );
		require get_theme_file_path( '/includes/customizer.php' );
		// require get_parent_theme_file_path( '/includes/register-acf-fields.php' );

	}

	/**
	 * Filter archive titles
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the filtered titles.
	 */
	public function archive_title( $title ) {

		// If is taxonomy archive.
		if ( is_tax() ) {
			$title = single_cat_title( '', false );

		// If is standard category archive.
		} elseif ( is_category() ) {
			$title = single_cat_title( '', false );

		// If is standard tag archive.
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );

		} elseif ( is_post_type_archive() ) {
            $title = post_type_archive_title( '', false );

		// If is author archive.
		} elseif ( is_author() ) {
			$title = sprintf(
				'%1s <span class="vcard">%2s</span>',
				__( 'Posts by', 'mixes-theme' ),
				get_the_author()
			);
		}

		// Return the ammended title.
    	return $title;

	}

	/**
	 * Theme options page
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function theme_options() {

		// Add a submenu page under Themes.
		$this->help_theme_options = add_submenu_page(
			'themes.php',
			__( 'Theme Options', 'affp-theme' ),
			__( 'Theme Options', 'affp-theme' ),
			'manage_options',
			'affp-theme-options',
			[ $this, 'theme_options_output' ]
		);

		// Add sample help tab.
		add_action( 'load-' . $this->help_theme_options, [ $this, 'help_theme_options' ] );

	}

	/**
     * Get output of the theme options page
     *
     * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function theme_options_output() {

        require get_parent_theme_file_path( '/includes/theme-options-page.php' );

	}

	/**
     * Add tabs to the about page contextual help section
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function help_theme_options() {

		// Add to the about page.
		$screen = get_current_screen();
		if ( $screen->id != $this->help_theme_options ) {
			return;
		}

		// More information tab.
		$screen->add_help_tab( [
			'id'       => 'help_theme_options_info',
			'title'    => __( 'More Information', 'affp-theme' ),
			'content'  => null,
			'callback' => [ $this, 'help_theme_options_info' ]
		] );

        // Add a help sidebar.
		$screen->set_help_sidebar(
			$this->help_theme_options_sidebar()
		);

	}

	/**
     * Get convert plugin help tab content
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
     */
	public function help_theme_options_info() {

		include_once get_theme_file_path( 'includes/partials/help-theme-options-info.php' );

    }

    /**
     * The about page contextual tab sidebar content
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the HTML of the sidebar content.
     */
    public function help_theme_options_sidebar() {

        $html  = sprintf( '<h4>%1s</h4>', __( 'Author Credits', 'affp-theme' ) );
        $html .= sprintf(
            '<p>%1s %2s.</p>',
            __( 'This theme was created by', 'affp-theme' ),
            'Your Name'
        );
        $html .= sprintf(
            '<p>%1s <br /><a href="%2s" target="_blank">%3s</a> <br />%4s</p>',
            __( 'Visit', 'affp-theme' ),
            'https://example.com/',
            'Example Site',
            __( 'for more details.', 'affp-theme' )
        );
        $html .= sprintf(
            '<p>%1s</p>',
            __( 'Change this sidebar to give yourself credit for the hard work you did customizing this theme.', 'affp-theme' )
         );

		return $html;

	}

	/**
	 * Theme info page
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function theme_info() {

		// Add a submenu page under Themes.
		add_submenu_page(
			'themes.php',
			__( 'Theme Info', 'affp-theme' ),
			__( 'Theme Info', 'affp-theme' ),
			'manage_options',
			'affp-theme-info',
			[ $this, 'theme_info_output' ]
		);

	}

	/**
     * Get output of the theme info page
     *
     * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function theme_info_output() {

        require get_theme_file_path( '/includes/theme-info-page.php' );

	}

	/**
     * User color scheme classes
	 *
	 * Add a class to the body element according to
	 * the user's admin color scheme preference.
     *
     * @since  1.0.0
	 * @access public
	 * @return array Returns a modified array of body classes.
     */
	public function color_scheme_classes( $classes ) {

		// Add a class if user is logged in and admin bar is showing.
		if ( is_user_logged_in() && is_admin_bar_showing() ) {

			// Get the user color scheme option.
			$scheme = get_user_option( 'admin_color' );

			// Return body classes with `user-color-$scheme`.
			return array_merge( $classes, array( 'user-color-' . $scheme ) );
		}

		// Return the unfiltered classes if user is not logged in.
		return $classes;

	}

}

/**
 * Get an instance of the Functions class
 *
 * This function is useful for quickly grabbing data
 * used throughout the theme.
 *
 * @since  1.0.0
 * @access public
 * @return object
 */
function AFFP_Theme() {

	$AFFP_Theme = Functions::get_instance();

	return $AFFP_Theme;

}

// Run the Functions class.
AFFP_Theme();