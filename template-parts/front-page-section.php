<?php
/**
 * Template part for displaying page content in page.php
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

	<div class="entry-content" itemprop="articleBody">
		<p><?php _e( 'This page is used as a section on the front page. It is not intended to be read as a standalone page.' ); ?></p>
		<?php the_content(); ?>
	</div>
</article>
