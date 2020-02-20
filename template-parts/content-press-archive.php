<?php
/**
 * Template part for displaying posts
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

// Custom fields.
$outlet   = get_field( 'press_outlet_name' );
$logo     = get_field( 'press_outlet_logo' );
$article  = get_field( 'press_article_title' );
$url      = get_field( 'press_article_url' );
$summary  = get_field( 'press_article_summary' );

if ( has_image_size( 'x-large-thumbnail' ) ) {
	$size = 'x-large-thumbnail';
} else {
	$size = 'medium';
}
$logo_url = $logo['url'];
$title    = $logo['title'];
$alt      = $logo['alt'];
$thumb    = $logo['sizes'][ $size ];
$width    = $logo['sizes'][ $size . '-width' ];
$height   = $logo['sizes'][ $size . '-height' ];

?>
<article id="press-<?php the_ID(); ?>" <?php post_class(); ?> role="article">

	<div class="entry-content" itemprop="articleBody">
		<div class="archive-press-list-view">
			<div class="press-logo">
				<figure>
					<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="nofollow"><img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo $outlet . __( ' logo', 'affp-theme' ); ?>" $width="<?php echo $width; ?>" height="<?php echo $height; ?>"></a>
					<figcaption class="screen-reader-text"><?php echo $outlet . __( ' logo', 'affp-theme' ); ?></figcaption>
				</figure>
			</div>
			<div class="press-info">
				<h2><a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="nofollow"><?php echo $article; ?></a></h2>
				<p class="press-outlet"><?php echo $outlet; ?></p>
				<label class="press-summary-label" for="article-<?php echo get_the_ID(); ?>"><?php _e( 'Article Summary:' ); ?></label>
				<div id="article-<?php echo get_the_ID(); ?>-summary" class="press-summary">
					<?php echo $summary; ?>
				</div>
				<?php echo sprintf(
					'<p class="press-link"><a href="%1s" target="_blank" rel="nofollow">%2s <span class="icon-right"></span></a></p>',
					esc_url( $url ),
					__( 'Read Article', 'affp-theme' )
				); ?>
			</div>
		</div>
	</div>

</article>
