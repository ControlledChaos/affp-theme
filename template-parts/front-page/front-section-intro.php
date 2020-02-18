<?php
/**
 * Intro section layout
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

// Get fields.
$site_title = get_field( 'intro_section_title' );
$site_desc  = get_field( 'intro_section_tagline' );

// Conditional text fields.
if ( $site_title ) {
	$site_title = $site_title;
} else {
	$site_title = __( 'Audrey Fisher', 'af-theme' );
}

if ( $site_desc ) {
	$site_desc = $site_desc;
} else {
	$site_desc = __( 'Costume Design', 'af-theme' );
}

?>
<div class="intro-overlay" role="presentation">
	<?php
	$images = get_field( 'intro_section_images' );
	if ( $images ) : ?>
		<ul class="intro-slides">
			<?php foreach( $images as $image ): ?>
				<li style="background-image: url('<?php echo $image['url']; ?>');">
					<span class="screen-reader-text"><?php echo esc_attr( $image['alt'] ); ?></span>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php endif; ?>
</div>
<header id="masthead" class="site-header" role="banner" itemscope="itemscope" itemtype="http://schema.org/Organization">
	<h1 class="site-title"><?php echo $site_title; ?></h1>
	<p class="site-description"><?php echo $site_desc; ?></p>

	<a class="icon-down" id="intro-entry-link"><span class="screen-reader-text">Enter Site</span></a>
</header>