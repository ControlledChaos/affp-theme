<?php
/**
 * Default page header
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

$site_description = get_bloginfo( 'description', 'display' );

if ( $site_description || is_customize_preview() ) {
	$site_description = $site_description;
} else {
	$site_description = __( 'Costume Design', 'affp-theme' );
}

?>
<body <?php body_class(); ?>>
<?php AFFP_Theme\Tags\body_open(); ?>
<?php AFFP_Theme\Tags\before_page(); ?>
	<div class="loader">
		<div class="spinner"></div>
		<div class="loading">
			<p><?php _e( 'Loading', 'affp-theme' ); ?></p>
		</div>
    </div>
	<div id="page" class="site" itemscope="itemscope" itemtype="<?php AFFP_Theme\Tags\site_schema(); ?>">
		<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'affp-theme' ); ?></a>

		<div id="navbar" class="navbar">
			<nav id="site-navigation" class="main-navigation wrapper" role="directory" itemscope itemtype="http://schema.org/SiteNavigationElement">
				<button class="menu-toggle" aria-controls="main-menu" aria-expanded="false">
					<span class="icon-menu" role="presentation"></span><?php esc_html_e( 'Menu', 'affp-theme' ); ?>
				</button>
				<?php
				wp_nav_menu( [
					'theme_location' => 'main',
					'menu_id'        => 'main-menu',
					'container'      => false,
					'fallback_cb'    => null
				] );
				?>
			</nav>
		</div>

		<header id="masthead" class="site-header" role="banner" itemscope="itemscope" itemtype="http://schema.org/Organization">
			<div class="wrapper">
				<div class="site-branding">
					<?php
					if ( is_front_page() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php endif; ?>
					<p class="site-description"><?php echo $site_description; ?></p>
				</div>
			</div>
		</header>

		<div id="content" class="site-content">