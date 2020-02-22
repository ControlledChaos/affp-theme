<?php
/**
 * Press grid section layout
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

// Query the press post type.
$args = [
	'post_type'      => [ 'press' ],
	'post_status'    => [ 'publish' ],
	'nopaging'       => false,
	'posts_per_page' => 6,
	'paged'          => 1,
	'order'          => 'ASC',
	'orderby'        => 'menu_order',
];
$query = new WP_Query( $args );

if ( $query->have_posts() ) : ?>
<ul class="posts-grid press-grid">
	<?php while ( $query->have_posts() ) : $query->the_post();
	$outlet   = get_field( 'press_outlet_name' );
	$logo     = get_field( 'press_outlet_logo' );
	$article  = get_field( 'press_article_title' );
	$url      = get_field( 'press_article_url' );
	$summary  = get_field( 'press_article_summary' );
	$logo_url = $logo['url'];
    $title    = $logo['title'];
	$alt      = $logo['alt'];

	// Check for the extra large image size.
	if ( has_image_size( 'x-large-thumbnail' ) ) {
		$size = 'x-large-thumbnail';
	} else {
		$size = 'medium';
	}
    $thumb    = $logo['sizes'][ $size ];
    $width    = $logo['sizes'][ $size . '-width' ];
    $height   = $logo['sizes'][ $size . '-height' ];
	?>
		<li>
			<figure>
				<a href="<?php the_permalink(); ?>">
					<img src="<?php echo esc_url( $thumb ); ?>" alt="<?php echo $outlet; ?>">
					<figcaption>
						<h3><?php echo $article; ?></h3>
						<p><span class="screen-reader-text"><?php _e( 'Article from ', 'affp-theme' ); ?></span><?php echo $outlet; ?></p>
					</figcaption>
				</a>
			</figure>
		</li>
	<?php endwhile; ?>
	</ul>
<?php else :
	_e( 'No press found', 'affp-theme' );
endif;

// Restore original Post Data
wp_reset_postdata();