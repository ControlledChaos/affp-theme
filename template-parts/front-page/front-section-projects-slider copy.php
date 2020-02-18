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
	'order'          => 'DESC',
	'orderby'        => 'menu_order',
];
$query = new WP_Query( $args );

if ( $query->have_posts() ) : ?>
	<?php while ( $query->have_posts() ) : $query->the_post();
	// get_field( '' );
	$poster = get_field( 'project_poster_image' );
	$url    = $poster['url'];
    $title  = $poster['title'];
    $alt    = $poster['alt'];
    $size   = 'poster-small';
    $thumb  = $poster['sizes'][ $size ];
    $width  = $poster['sizes'][ $size . '-width' ];
    $height = $poster['sizes'][ $size . '-height' ];
	$decription = get_field( 'project_description' );
	$imdb_url   = get_field( 'project_imdb_page' );
	$vimeo_url  = get_field( 'project_vimeo_url' );
	?>
	<div class="subsection">
		<div class="featured-project">
			<div class="featured-project-poster">
				<figure>
					<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo get_the_title() . __( ' poster', 'affp-theme' ); ?>" $width="<?php echo $width; ?>" height="<?php echo $height; ?>">
					<figcaption class="screen-reader-text"><?php echo get_the_title() . __( ' poster', 'affp-theme' ); ?></figcaption>
				</figure>
			</div>
			<div class="featured-project-info">
				<h3><?php the_title(); ?></h3>
				<p><?php echo $decription; ?></p>
				<ul>
					<li><a href="<?php echo $vimeo_url; ?>" data-fancybox><span class="icon-video"></span> <span><?php _e( 'Trailer', 'affp-theme' ); ?></span></a></li>
					<li><a href="<?php echo ''; ?>"><span class="icon-photo"></span> <span><?php _e( 'Gallery', 'affp-theme' ); ?></span></a></li>
					<li><a href="<?php the_permalink(); ?>"><span class="icon-info"></span> <span><?php _e( 'Info', 'affp-theme' ); ?></span></a></li>
				</ul>
			</div>
		</div>
	</div>
	<?php endwhile;
else :
	_e( 'No projects found', 'affp-theme' );
endif;

// Restore original Post Data
wp_reset_postdata();