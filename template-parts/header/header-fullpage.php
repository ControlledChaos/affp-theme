<?php
/**
 * Page header for the FullPageJS template
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

/**
 * Get the name of menus in the Menus UI by location.
 *
 * @example wp_nav_menu( 'theme_location' => 'example' );
 */
$locations = get_nav_menu_locations();
$more_menu = wp_get_nav_menu_object( $locations['more'] );

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
				<?php if ( has_custom_logo() ) { the_custom_logo();} ?>
				<button class="menu-toggle" aria-controls="main-menu" aria-expanded="false">
					<span class="icon-menu" role="presentation"></span><?php esc_html_e( 'Menu', 'affp-theme' ); ?>
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
					<li data-menuanchor="<?php echo strtolower( $menuanchor ); ?>">
						<a href="#<?php echo strtolower( $menuanchor ); ?>"><?php the_sub_field( 'fp_section_menu' ); ?></a>
					</li>
					<?php endwhile; ?>
					<?php if ( has_nav_menu( 'more' ) ) : ?>
					<li class="more-menu-base-item">
						<?php echo $more_menu->name; ?>
						<?php
						wp_nav_menu( [
							'theme_location' => 'more',
							'container'      => false,
							'menu_class'     => 'more-menu',
							'menu_id'        => 'more-menu',
							'fallback_cb'    => null
						] );
						?>
					</li>
					<?php endif; ?>
				</ul>
				<?php endif; ?>
			</nav>
		</div>

		<div id="content" class="site-content">