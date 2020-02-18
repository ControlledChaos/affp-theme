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
	'nopaging'       => true,
	'posts_per_page' => 6,
	'paged'          => 1,
	'order'          => 'DESC',
	'orderby'        => 'menu_order',
];
$query = new WP_Query( $args );

if ( $query->have_posts() ) : ?>
	<ul class="projects-grid">
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
		<li>
			<figure>
				<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo get_the_title() . __( ' poster', 'affp-theme' ); ?>">
				<figcaption>
					<h3 class="screen-reader-text"><?php the_title(); ?></h3>
					<p class="projects-grid-links">
						<a href="<?php echo $vimeo_url; ?>" data-fancybox><span class="screen-reader-text"><?php _e( 'Trailer', 'affp-theme' ); ?></span><span class="icon-video"></span></a>
						<a href="<?php echo ''; ?>"><span class="screen-reader-text"><?php _e( 'Gallery', 'affp-theme' ); ?></span><span class="icon-photo"></span></a>
						<a href="<?php the_permalink(); ?>"><span class="screen-reader-text"><?php _e( 'Info', 'affp-theme' ); ?></span><span class="icon-info"></span></a>
					</p>
				</figcaption>
			</figure>
		</li>
	<?php endwhile; ?>
	</ul>
<?php else :
	_e( 'No projects found', 'affp-theme' );
endif;

// Restore original Post Data
wp_reset_postdata();