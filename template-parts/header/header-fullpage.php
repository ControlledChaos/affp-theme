<?php
/**
 * Page header for the FullPageJS template
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

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
					<li data-menuanchor="<?php echo strtolower( $menuanchor ); ?>">
						<a href="#<?php echo strtolower( $menuanchor ); ?>"><?php echo ucwords( $menuanchor ); ?></a>
					</li>
					<?php endwhile; ?>
				</ul>
				<?php endif; ?>
			</nav>
		</div>

		<div id="content" class="site-content">