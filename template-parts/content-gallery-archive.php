<?php
/**
 * Template part for displaying posts
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

// Featured image.
$images = get_field( 'gallery_images' );
$image  = $images[0];
$size   = 'large';
if ( has_post_thumbnail() ) {
	$thumb = get_the_post_thumbnail_url( get_the_ID(), $size );
} else {
	$url   = $image['url'];
	$thumb = $image['sizes'][ $size ];
}

?>
<article id="gallery-<?php the_ID(); ?>" <?php post_class(); ?> role="article">

	<div class="entry-content" itemprop="articleBody">
		<div class="archive-gallery-list-view">
			<div class="gallery-image">
				<figure>
					<a href="<?php the_permalink(); ?>"><img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo get_the_title() . __( ' featured image', 'affp-theme' ); ?>" $width="320" height="240"></a>
					<figcaption class="screen-reader-text"><?php echo get_the_title() . __( ' gallery featured image', 'affp-theme' ); ?></figcaption>
				</figure>
			</div>
			<div class="gallery-info">
				<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php the_excerpt(); ?>
				<p class="gallery-link"><a href="<?php the_permalink(); ?>"><?php _e( 'View Project', 'affp-theme' ); ?> <span class="icon-right"></span></a></p>
			</div>
		</div>
	</div>

</article>
