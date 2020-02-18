<?php
/**
 * Page object section layout
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

$post_object = get_sub_field( 'fp_section_page_object' );

if ( $post_object ) :

	$post = $post_object;
	setup_postdata( $post );
	?>
	<div>
		<?php the_content(); ?>
	</div>
	<?php wp_reset_postdata(); ?>
<?php endif;