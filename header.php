<?php
/**
 * Theme header
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

/**
 * Scripts for FullPageJS template
 *
 * Only for use on the static front page.
 */
if ( is_front_page() && is_page_template( 'page-templates/front-page-sections.php' ) ) {
	require get_theme_file_path( '/includes/class-fullpage-scripts.php' );
	new AFFP_Theme\Includes\Scripts\FullPage_Scripts();
}

if ( is_home() && ! is_front_page() ) {
    $canonical = get_permalink( get_option( 'page_for_posts' ) );
} elseif ( is_archive() ) {
    $canonical = get_permalink( get_option( 'page_for_posts' ) );
} else {
    $canonical = get_permalink();
}

$site_description = get_bloginfo( 'description', 'display' );
if ( $site_description || is_customize_preview() ) {
	$site_description = $site_description;
} else {
	$site_description = __( 'Costume Design', 'af-theme' );
}

?>
<!doctype html>
<?php do_action( 'before_html' ); ?>
<html <?php language_attributes(); ?> class="no-js">
<head id="<?php echo get_bloginfo( 'wpurl' ); ?>" data-template-set="<?php echo get_template(); ?>">
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<!--[if IE ]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open() ) {
		echo sprintf( '<link rel="pingback" href="%s" />', get_bloginfo( 'pingback_url' ) );
	} ?>
	<link href="<?php echo $canonical; ?>" rel="canonical" />
	<?php if ( is_search() ) { echo '<meta name="robots" content="noindex,nofollow" />'; } ?>

	<!-- Prefetch font URLs -->
	<link rel='dns-prefetch' href='//fonts.google.com'/>

	<?php do_action( 'before_wp_head' ); ?>
	<?php wp_head(); ?>
	<?php do_action( 'after_wp_head' ); ?>
</head>
<?php
if ( is_front_page() && is_page_template( 'page-templates/front-page-sections.php' ) ) {
	get_template_part( 'template-parts/header/header-fullpage' );
} else {
	get_template_part( 'template-parts/header/header' );
}