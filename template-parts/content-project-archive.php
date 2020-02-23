<?php
/**
 * Template part for displaying posts
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

// Custom fields.
$title       = get_field( 'project_title' );
$client      = get_field( 'project_client' );
$director    = get_field( 'project_director' );
$description = get_field( 'project_description' );
$imdb_url    = get_field( 'project_imdb_page' );

if ( $description ) {
	$description = $description;
} else {
	$description = '';
}

if ( $client ) {
	$client = sprintf(
		'<p><strong>%1s</strong> %2s</p>',
		__( 'Client:', 'affp-theme' ),
		$client
	);
} else {
	$client = null;
}

if ( $director ) {
	$director = sprintf(
		'<p class="directed-by-label"><strong>%1s</strong> %2s</p>',
		__( 'Directed by:', 'affp-theme' ),
		$director
	);
} else {
	$director = null;
}

if ( $imdb_url ) {
	$imdb = sprintf(
		'<p><a href="%1s" target="_blank" rel="nofollow">%2s %3s <span class="icon-right"></span></a></p>',
		esc_url( $imdb_url ),
		$title,
		__( 'on IMDb', 'affp-theme' )
	);
} else {
	$imdb = null;
}

$poster      = get_field( 'project_poster_image' );
$poster_url  = $poster['url'];
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
<article id="project-<?php the_ID(); ?>" <?php post_class(); ?> role="article">

	<div class="entry-content" itemprop="articleBody">
		<div class="archive-project archive-toggle-view-post">
			<div class="project-poster archive-toggle-view-image">
				<figure>
					<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo get_the_title() . __( ' poster', 'affp-theme' ); ?>" $width="<?php echo $width; ?>" height="<?php echo $height; ?>"></a>
					<figcaption class="screen-reader-text"><?php echo get_the_title() . __( ' poster', 'affp-theme' ); ?></figcaption>
				</figure>
			</div>
			<div class="project-info archive-toggle-view-info">
				<header class="entry-header">
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php echo $title; ?></a></h2>
				</header>

				<div id="project-details-<?php the_ID(); ?>" class="archive-post-details archive-project-details">
					<h3><?php _e( 'Project Details', 'affp-theme' ); ?></h3>
					<?php echo $client; ?>
					<?php echo $director; ?>
					<?php echo $imdb; ?>
				</div>

				<ul class="projects-links">
					<?php if ( $vimeo_url ) : ?>
					<li><a class="tooltip" href="<?php echo esc_url( $vimeo_url ); ?>" title="<?php _e( 'Project trailer' ); ?>" data-fancybox target="_blank" rel="nofollow"><span class="icon-video"></span> <span class="info-link-text"><?php _e( 'Trailer', 'affp-theme' ); ?></span></a></li>
					<?php endif; ?>
					<?php if ( $gallery ) : ?>
					<li class="project-gallery-link"><a class="tooltip" href="<?php echo esc_url( $first_url ); ?>" title="<?php _e( 'Project gallery' ); ?>" data-fancybox="<?php echo 'gallery-' . get_the_ID(); ?>"><span class="icon-photo"></span> <span class="info-link-text"><?php _e( 'Gallery', 'affp-theme' ); ?></span></a></li>
					<?php endif; ?>
					<?php if ( $client || $director || $imdb ) : ?>
					<li class="project-details-link"><a class="tooltip" data-fancybox data-src="#project-details-<?php the_ID(); ?>" title="<?php _e( 'Project Details' ); ?>"><span class="icon-more"></span> <span class="info-link-text"><?php _e( 'Details', 'affp-theme' ); ?></span></a></li>
					<?php endif; ?>
					<li class="project-page-link"><a class="tooltip" href="<?php the_permalink(); ?>" title="<?php _e( 'Go to this project\'s page' ); ?>"><span class="icon-more"></span> <span class="info-link-text"><?php _e( 'View Project', 'affp-theme' ); ?></span></a></li>
				</ul>

				<div class="project-description"><?php echo $description; ?></div>

				<p class="project-link"><a href="<?php the_permalink(); ?>"><?php _e( 'View Project', 'affp-theme' ); ?> <span class="icon-right"></span></a></p>
			</div>
			<div class="project-gallery" id="<?php echo 'gallery-' . get_the_ID(); ?>">
				<?php AFFP_Theme\Tags\projects_galleries(); ?>
			</div>
		</div>
	</div>

</article>
