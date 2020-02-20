<?php
/**
 * Featured projects slider section layout
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

// Query the project post type.
$args = [
	'post_type'      => [ 'project' ],
	'post_status'    => [ 'publish' ],
	'nopaging'       => true,
	'posts_per_page' => 6,
	'paged'          => 1,
	'order'          => 'ASC',
	'orderby'        => 'menu_order',
];
$query = new WP_Query( $args );

if ( $query->have_posts() ) : ?>
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
	<div class="subsection">
		<div id="project-<?php echo get_the_ID(); ?>" class="featured-project">
			<div class="project-poster">
				<figure>
					<a href="<?php echo $poster_url; ?>" data-fancybox data-type="image" data-caption="<?php echo get_the_title() . __( ' poster', 'affp-theme' ); ?>"><img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo get_the_title() . __( ' poster', 'affp-theme' ); ?>" $width="<?php echo $width; ?>" height="<?php echo $height; ?>"></a>
					<figcaption class="screen-reader-text"><?php echo get_the_title() . __( ' poster', 'affp-theme' ); ?></figcaption>
				</figure>
			</div>
			<div class="project-info">
				<h3><?php the_title(); ?></h3>
				<ul>
					<?php if ( $vimeo_url ) : ?>
					<li><a href="<?php echo $vimeo_url; ?>" data-fancybox target="_blank" rel="nofollow"><span class="icon-video"></span> <span><?php _e( 'Trailer', 'affp-theme' ); ?></span></a></li>
					<?php endif; ?>
					<?php if ( $gallery ) : ?>
					<li class="project-gallery-link"><a href="<?php echo $first_url; ?>" data-fancybox="<?php echo 'gallery-' . get_the_ID(); ?>"><span class="icon-photo"></span> <span><?php _e( 'Gallery', 'affp-theme' ); ?></span></a></li>
					<?php endif; ?>
					<li><a href="<?php the_permalink(); ?>" class="tooltip" title="<?php _e( 'Go to this project\'s page' ); ?>"><span class="icon-more"></span> <span><?php _e( 'More', 'affp-theme' ); ?></span></a></li>
				</ul>
				<h4><?php _e( 'Description', 'affp-theme' ); ?></h4>
				<p><?php echo $description; ?></p>
				<div class="project-gallery" id="<?php echo 'gallery-' . get_the_ID(); ?>">
					<?php AFFP_Theme\Tags\projects_galleries(); ?>
				</div>
			</div>
		</div>
	</div>
	<?php endwhile;
else :
	_e( 'No projects found', 'affp-theme' );
endif;

// Restore original Post Data
wp_reset_postdata();