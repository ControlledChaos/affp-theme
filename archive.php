<?php
/**
 * The template for displaying archive pages
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main wrapper" itemscope itemprop="mainContentOfPage">

		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
			</header>

			<?php // get_template_part( 'template-parts/navigation/numeric-nav' ); ?>

			<?php if ( is_post_type_archive( [ 'project', 'press' ] ) ) : ?>

			<div class="list-view-toggle">
				<p class="list-view-toggle-actions"><span><?php _e( 'View as:', 'affp-theme' ); ?> </span>
					<button id="list-view-list" class="tooltip list-view list list-view-on" aria-label="List" title="List">
						<span class="screen-reader-text"><?php _e( 'View as list', 'affp-theme' ); ?></span>
						<span class="icon-list" aria-hidden="true"></span>
					</button>
					<button id="list-view-grid" class="tooltip list-view grid" aria-label="Grid" title="Grid">
						<span class="screen-reader-text"><?php _e( 'View as grid', 'affp-theme' ); ?></span>
						<span class="icon-grid" aria-hidden="true"></span>
					</button>
				</p>
			</div>

			<?php endif; ?>

			<div class="posts-list">
			<?php
			while ( have_posts() ) : the_post();
				if ( is_post_type_archive() ) {
					get_template_part( 'template-parts/content', get_post_type() . '-archive' );
				} else {
					get_template_part( 'template-parts/content', get_post_type() );
				}
			endwhile;
			?>
			</div>

			<?php get_template_part( 'template-parts/navigation/numeric-nav' );

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main>
	</div>

<?php
get_sidebar();
get_footer();