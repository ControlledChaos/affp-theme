<?php
/**
 * Template for sectioned front page part
 *
 * This will redirect to the front page if accessed directly.
 *
 * Template Name: Single Front Page Section
 * Template Post Type: page
 * Description: For use as a single section in the sectioned static front page.
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

// Redirect to the front page.
wp_safe_redirect( home_url() );

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" itemscope itemprop="mainContentOfPage">

		<?php while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', 'front-page-section' );

		endwhile; // End of the loop.
		?>

		</main>
	</div>

<?php
get_sidebar();
get_footer();