<?php
/**
 * Template part for displaying gallery content
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article">
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header>

	<?php AFFP_Theme\Tags\post_thumbnail(); ?>

	<div class="entry-content" itemprop="articleBody">
		<?php the_content();

		if ( class_exists( 'acf_pro' ) ) :
			$images = get_field( 'gallery_images' );
			$size   = get_field( 'gallery_size' );
			if ( $size ) {
				$size = $size;
			} else {
				$size = 'medium';
			}

			if ( $images ) : ?>
				<ul class="gallery gallery-size-<?php echo $size; ?>">
					<?php foreach( $images as $image ): ?>
						<li class="gallery-item">
							<a href="<?php echo esc_url( $image['url'] ); ?>" data-fancybox="images" data-caption="<?php echo esc_html( $image['caption'] ); ?>">
								 <figure>
									 <img src="<?php echo esc_url( $image['sizes'][$size] ); ?>" alt="<?php echo esc_attr( $image['alt'] ); ?>" />
									 <figcaption><?php echo esc_html( $image['caption'] ); ?></figcaption>
								 </figure>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif;
		endif; // End if ACF Pro.

		?>
	</div>

</article>
