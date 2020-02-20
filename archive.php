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

			<?php while ( have_posts() ) :
				the_post();
				if ( is_post_type_archive() ) {
					get_template_part( 'template-parts/content', get_post_type() . '-archive' );
				} else {
					get_template_part( 'template-parts/content', get_post_type() );
				}

			endwhile;

			get_template_part( 'template-parts/navigation/numeric-nav' );

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main>
	</div>

<?php
get_sidebar();
get_footer();