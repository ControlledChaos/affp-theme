<?php
/**
 * Theme activation
 *
 * Do not namespace this file.
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Theme activation class
 *
 * @since  1.0.0
 * @access public
 */
class AFFP_Theme_Activate {

    /**
	 * Constructor magic method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		add_action( 'after_switch_theme', [ $this, 'activate' ] );

	}

    /**
	 * Function to be fired when theme is activated
	 *
	 * Default actions provided here are samples of how to set theme mods,
	 * add starter content, and redirect the user after activation.
	 *
	 * Remove or modify these as needed.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 *
	 * @link   https://developer.wordpress.org/reference/functions/set_theme_mod/
	 */
    public function activate() {}
}

// Run the class.
new AFFP_Theme_Activate;