<?php
/**
 * Press slider section layout
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

// Query the press post type.
$args = [
	'post_type'      => [ 'press' ],
	'posts_per_page' => 8,
	'orderby'        => 'menu_order',
	'order'          => 'ASC'
];
$query = new WP_Query( $args );

if ( $query->have_posts() ) : ?>
	<?php while ( $query->have_posts() ) : $query->the_post();
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
	<div class="subsection">
		<div id="press-<?php echo get_the_ID(); ?>" class="featured-post featured-press">
			<div class="featured-post-image press-logo">
				<figure>
					<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo $outlet . __( ' logo', 'affp-theme' ); ?>" $width="<?php echo $width; ?>" height="<?php echo $height; ?>">
					<figcaption class="screen-reader-text"><?php echo $outlet . __( ' logo', 'affp-theme' ); ?></figcaption>
				</figure>
			</div>
			<div class="featured-post-info press-info">
				<p class="press-outlet"><?php echo $outlet; ?></p>
				<h3><?php echo $article; ?></h3>
				<label class="press-summary-label" for="article-<?php echo get_the_ID(); ?>"><?php _e( 'Article Summary:' ); ?></label>
				<div id="article-<?php echo get_the_ID(); ?>" class="press-summary">
					<?php echo $summary; ?>
				</div>
				<?php echo sprintf(
					'<p class="press-link"><a href="%1s" target="_blank" rel="nofollow"><span class="info-link-text">%2s</span> <span class="icon-right"></span></a></p>',
					esc_url( $url ),
					__( 'Read Article', 'affp-theme' )
				); ?>
			</div>
		</div>
	</div>
	<?php endwhile;
else :
	_e( 'No press articles found', 'affp-theme' );
endif;

// Restore original Post Data
wp_reset_postdata();