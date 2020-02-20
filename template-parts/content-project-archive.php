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

$poster     = get_field( 'project_poster_image' );
$poster_url = $poster['url'];
$alt        = $poster['alt'];
$size       = 'poster-small';
$thumb      = $poster['sizes'][ $size ];
$width      = $poster['sizes'][ $size . '-width' ];
$height     = $poster['sizes'][ $size . '-height' ];

?>
<article id="project-<?php the_ID(); ?>" <?php post_class(); ?> role="article">

	<div class="entry-content" itemprop="articleBody">
		<div class="archive-project-list-view">
			<div class="project-poster">
				<figure>
					<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo get_the_title() . __( ' poster', 'affp-theme' ); ?>" $width="<?php echo $width; ?>" height="<?php echo $height; ?>"></a>
					<figcaption class="screen-reader-text"><?php echo get_the_title() . __( ' poster', 'affp-theme' ); ?></figcaption>
				</figure>
			</div>
			<div class="project-info">
				<header class="entry-header">
					<h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php echo $title; ?></a></h2>
					<?php echo $client; ?>
					<?php echo $director; ?>
				</header>
				<?php echo $description; ?>
				<p><a href="<?php the_permalink(); ?>"><?php _e( 'View Project', 'affp-theme' ); ?> <span class="icon-right"></span></a></p>
			</div>
		</div>
	</div>

</article>
