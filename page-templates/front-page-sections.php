<?php
/**
 * Sectioned page for use with FullPageJS
 *
 * For use only with the static front page. Custom fields
 * are registered only for this page type.
 *
 * Requires Advanced Custom Fields Pro.
 *
 * Template Name: Front Page Sections
 * Template Post Type: page
 * Description: Provides sectioned content and custom scrolling for the static front page.
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main class="site-main front-page-main" id="front-page-sections" itemscope itemprop="mainContentOfPage">

		<section class="front-page-section splash active" data-anchor="splash">
			<?php get_template_part( 'template-parts/front-page/front-section-intro' ); ?>
		</section>

		<?php while ( have_posts() ) : the_post();

		// Check value exists.
		if ( have_rows( 'front_page_sections' ) ) :

			// Loop through rows.
			while ( have_rows( 'front_page_sections' ) ) : the_row();
			$slug    = get_sub_field( 'fp_section_slug' );
			$section = str_replace( ' ', '', strtolower( $slug ) );
			?>

			<section id="<?php echo $section; ?>" class="front-page-section <?php echo $section; ?>" data-anchor="<?php echo $section; ?>">
				<div class="entry-content wrapper">
					<header>
						<h2><?php echo get_sub_field( 'fp_section_title' ); ?></h2>
					</header>

					<?php
					// Get layout partial by type.
					if ( get_row_layout() == 'fp_section_content' ) {
						get_template_part( 'template-parts/front-page/front-section-content' );
					} elseif ( get_row_layout() == 'fp_section_projects' ) {
						if ( 'grid' == get_sub_field( 'fp_section_projects_display' ) ) {
							get_template_part( 'template-parts/front-page/front-section-projects-grid' );
						} else {
							echo '<div class="featured-projects-slider">';
							get_template_part( 'template-parts/front-page/front-section-projects-slider' );
							echo '</div>';
						}
					} elseif ( get_row_layout() == 'fp_section_page' ) {
						get_template_part( 'template-parts/front-page/front-section-page' );
					}

					if ( get_sub_field( 'fp_section_link_slug' ) ) {
						$link_slug = get_sub_field( 'fp_section_link_slug' );
						$slug      = str_replace( ' ', '', $link_slug );
						$move_to   = strtolower( $slug );
						echo sprintf(
							'<script>jQuery(document).on("click", "#move-to-%1s", function() { fullpage_api.moveTo("%2s", 1); });</script>',
							$move_to,
							$move_to
						);
						echo sprintf(
							'<p><a id="move-to-%1s" class="next-section">%2s <span class="icon-%3s"></a></p>',
							$move_to,
							get_sub_field( 'fp_section_link_text' ),
							get_sub_field( 'fp_section_link_icon' )
						);
					}
					?>
				</div>
			</section>

			<?php
			// End loop.
			endwhile;

		// No value.
		else :
			// Do something...
		endif;

endwhile; // End of the loop.
?>

		</main>
	</div>

<?php get_footer();
