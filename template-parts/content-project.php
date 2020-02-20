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
$vimeo_url   = get_field( 'project_vimeo_url' );
$gallery     = get_field( 'project_gallery' );

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
$size       = 'poster-medium';
$thumb      = $poster['sizes'][ $size ];
$width      = $poster['sizes'][ $size . '-width' ];
$height     = $poster['sizes'][ $size . '-height' ];

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

if ( ! empty( $vimeo_url ) ) {
	$vimeo_data = json_decode( file_get_contents( 'http://vimeo.com/api/oembed.json?url=' . $vimeo_url ) );
} else {
	$vimeo_data = null;
}

if ( ! $vimeo_data ) {
	$vimeo = null;
} else {
	$vimeo = $vimeo_data->video_id;
}

?>
<nav class="posts-navigation posts-navigation-top single-project-navigation wrapper">
	<div class="nav-previous prev-project" rel="prev">
		<span><?php previous_post_link( '%link', '<span class="icon-left"></span> %title', false ); ?></span>
	</div>
	<div class="nav-next next-project" rel="next">
		<span><?php next_post_link( '%link', '%title <span class="icon-right"></span>', false ); ?></span>
	</div>
</nav>
<article id="project-<?php the_ID(); ?>" <?php post_class(); ?> role="article">

	<div class="entry-content" itemprop="articleBody">
		<div class="single-project-top">
			<div class="project-poster">
				<figure>
					<a href="<?php echo $poster_url; ?>" data-fancybox data-type="image" data-caption="<?php echo get_the_title() . __( ' poster', 'affp-theme' ); ?>"><img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo get_the_title() . __( ' poster', 'affp-theme' ); ?>" $width="<?php echo $width; ?>" height="<?php echo $height; ?>"></a>
					<figcaption class="screen-reader-text"><?php echo get_the_title() . __( ' poster', 'affp-theme' ); ?></figcaption>
				</figure>
			</div>
			<div class="project-info">
				<header class="entry-header">
					<h1 class="entry-title"><?php echo $title; ?></h1>
					<?php echo $client; ?>
					<?php echo $director; ?>
				</header>
				<?php echo $description; ?>
				<?php echo $imdb; ?>
			</div>
		</div>
		<?php if ( $vimeo_url ) : ?>
		<div class="project-trailer-embed">
			<?php echo sprintf( '<h3>%1s %2s</h3>', get_the_title(), esc_html__( 'Trailer', 'affp-theme' ) ); ?>
            <iframe src="https://player.vimeo.com/video/<?php echo $vimeo; ?>?color=ffffff&title=0&byline=0&portrait=0" width="1280" height="720" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
		</div>
		<?php endif; ?>

		<div class="clearfix video-fix"></div>

		<?php if ( $gallery ) : ?>
		<div class="project-gallery" id="project-gallery-<?php echo get_the_ID(); ?>">
			<?php echo sprintf( '<h3>%1s %2s</h3>', get_the_title(), esc_html__( 'Gallery', 'amcd-theme' ) ); ?>
			<ul class="project-gallery-list">
			<?php foreach( $gallery as $image ) : ?>
				<li>
					<figure>
						<a data-type="image" data-fancybox="project-gallery-<?php echo get_the_ID(); ?>" data-caption="<?php echo __( 'Scenes from ' ) . $title; ?>" href="<?php echo $image['url']; ?>">
							<img src="<?php echo $image['sizes']['medium']; ?>" />
							<figcaption><span><?php echo $image['caption']; ?></span></figcaption>
						</a>
					</figure>
				</li>
			<?php endforeach; ?>
			</ul>
		</div>
		<?php endif; ?>

	</div>

</article>
