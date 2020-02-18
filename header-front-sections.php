<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 *
 * @todo       Add hooks for nav above or below header.
 */

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
	<?php
	$custom_css = get_sub_field( 'fp_section_add_css' );
	if ( $custom_css ) {
		echo '<style>' . "\n";
		echo $custom_css . "\n";
		echo '</style>' . "\n";
	}
	?>
	<?php do_action( 'after_wp_head' ); ?>
</head>

<body <?php body_class(); ?>>
	<div class="loader">
		<div class="spinner"></div>
		<div class="loading">
			<p><?php _e( 'Loading', 'affp-theme' ); ?></p>
		</div>
    </div>
	<div id="page" class="site" itemscope="itemscope" itemtype="<?php AFFP_Theme\Tags\site_schema(); ?>">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'affp-theme' ); ?></a>

		<div class="navbar">
			<nav id="site-navigation" class="main-navigation wrapper" role="directory" itemscope itemtype="http://schema.org/SiteNavigationElement">
				<?php if ( has_custom_logo() ) { the_custom_logo();} ?>
				<button class="menu-toggle" aria-controls="main-menu" aria-expanded="false">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="theme-icon menu-icon"><path d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"/></svg>
					<?php esc_html_e( 'Menu', 'affp-theme' ); ?>
				</button>
				<?php
				if ( have_rows( 'front_page_sections' ) ) : ?>
				<ul>
					<li data-menuanchor="splash" class="screen-reader-text active">
						<a href="#splash">Welcome</a>
					</li>
					<?php while ( have_rows( 'front_page_sections' ) ) : the_row();
					$slug       = get_sub_field( 'fp_section_slug' );
					$menuanchor = str_replace( ' ', '', $slug );
					?>
					<li data-menuanchor="<?php echo $menuanchor; ?>">
						<a href="#<?php echo $menuanchor; ?>"><?php echo ucwords( $menuanchor ); ?></a>
					</li>
					<?php endwhile; ?>
				</ul>
				<?php endif; ?>
			</nav>
		</div>

		<div id="content" class="site-content">
