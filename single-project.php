<?php
/**
 * The template for displaying project posts
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main wrapper" itemscope itemprop="mainContentOfPage">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

		endwhile; // End of the loop.
		?>

		</main>
		<nav class="posts-navigation posts-navigation-bottom single-project-navigation wrapper">
			<div class="nav-previous prev-project" rel="prev">
				<span><?php previous_post_link( '%link', '<span class="icon-left"></span> %title', false ); ?></span>
			</div>
			<div class="nav-next next-project" rel="next">
				<span><?php next_post_link( '%link', '%title <span class="icon-right"></span>', false ); ?></span>
			</div>
		</nav>
	</div>

<?php
get_footer();
