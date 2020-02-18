<?php
/**
 * Admin notice that this theme needs its companion plugin.
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

namespace AFFP_Theme\Includes\Partials;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$get_theme  = wp_get_theme();
$theme_name = $get_theme->get( 'Name' );

?>
<div class="notice notice-error">
	<?php
	echo sprintf(
		'<p>%1s <strong>%2s %3s</strong> %4s <a href="%5s" target="_blank">%6s</a> %7s</p>',
		esc_html__( 'The', 'affp-theme' ),
		esc_html( $theme_name ),
		esc_html__( 'theme', 'affp-theme' ),
		esc_html__( 'needs the', 'affp-theme' ),
		esc_url( 'https://github.com/ControlledChaos/af-plugin' ),
		esc_html( AF_PLUGIN_NAME ),
		esc_html__( 'to be installed and activated.', 'affp-theme' )
	); ?>
</div>