<?php
/**
 * Featured projects grid section layout
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

// Query the project post type.
$args = [
	'post_type'      => [ 'project' ],
	'post_status'    => [ 'publish' ],
	'nopaging'       => false,
	'posts_per_page' => 6,
	'paged'          => 1,
	'order'          => 'ASC',
	'orderby'        => 'menu_order',
];
$query = new WP_Query( $args );

if ( $query->have_posts() ) : ?>
	<ul class="posts-grid projects-grid">
	<?php while ( $query->have_posts() ) : $query->the_post();
		$poster      = get_field( 'project_poster_image' );
		$poster_url  = $poster['url'];
		$title       = $poster['title'];
		$alt         = $poster['alt'];
		$size        = 'poster-medium';
		$thumb       = $poster['sizes'][ $size ];
		$width       = $poster['sizes'][ $size . '-width' ];
		$height      = $poster['sizes'][ $size . '-height' ];
		$description = get_field( 'project_description' );
		$imdb_url    = get_field( 'project_imdb_page' );
		$vimeo_url   = get_field( 'project_vimeo_url' );
		$gallery     = get_field( 'project_gallery' );
		$first_image = $gallery[0];
		$first_url   = $first_image['url'];
		?>
		<li>
			<figure>
				<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo get_the_title() . __( ' poster', 'affp-theme' ); ?>">
				<figcaption>
					<h3><?php the_title(); ?></h3>
					<ul class="projects-grid-links">
						<?php if ( $vimeo_url ) : ?>
						<li><a class="tooltip" href="<?php echo esc_url( $vimeo_url ); ?>" title="<?php _e( 'Project trailer' ); ?>" data-fancybox target="_blank" rel="nofollow"><span class="icon-video"></span> <span class="screen-reader-text"><?php _e( 'Trailer', 'affp-theme' ); ?></span></a></li>
						<?php endif; ?>
						<?php if ( $gallery ) : ?>
						<li class="project-gallery-link"><a class="tooltip" href="<?php echo esc_url( $first_url ); ?>" title="<?php _e( 'Project gallery' ); ?>" data-fancybox="<?php echo 'gallery-' . get_the_ID(); ?>"><span class="icon-photo"></span> <span class="screen-reader-text"><?php _e( 'Gallery', 'affp-theme' ); ?></span></a></li>
						<?php endif; ?>
						<li><a class="tooltip" href="<?php the_permalink(); ?>" title="<?php _e( 'Go to this project\'s page' ); ?>"><span class="icon-more"></span> <span class="screen-reader-text"><?php _e( 'More', 'affp-theme' ); ?></span></a></li>
					</ul>
				</figcaption>
			</figure>
			<div class="project-gallery" id="<?php echo 'gallery-' . get_the_ID(); ?>">
				<?php AFFP_Theme\Tags\projects_galleries(); ?>
			</div>
		</li>
	<?php endwhile; ?>
	</ul>
<?php else :
	_e( 'No projects found', 'affp-theme' );
endif;

// Restore original Post Data
wp_reset_postdata();