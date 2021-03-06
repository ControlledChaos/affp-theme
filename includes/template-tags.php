<?php
/**
 * Template tags
 *
 * @package    WordPress/ClassicPress
 * @subpackage AFFP_Theme
 * @since      1.0.0
 */

// Namespace specificity for theme functions & filters.
namespace AFFP_Theme\Tags;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if WordPress is 5.0 or greater.
 *
 * @since  1.0.0
 * @access public
 * @return bool Returns true if the WordPress version is 5.0 or greater.
 */
function theme_new_cms() {

	// Get the WordPress version.
	$version = get_bloginfo( 'version' );

	if ( $version >= 5.0 ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Check if the CMS is ClassicPress.
 *
 * @since  1.0.0
 * @access public
 * @return bool Returns true if ClassicPress is running.
 */
function theme_classicpress() {

	if ( function_exists( 'classicpress_version' ) ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Check for Advanced Custom Fields
 *
 * @since  1.0.0
 * @access public
 * @return bool Returns true if the ACF free or Pro plugin is active.
 */
function theme_acf() {

	if ( class_exists( 'acf' ) ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Check for Advanced Custom Fields Pro
 *
 * @since  1.0.0
 * @access public
 * @return bool Returns true if the ACF Pro plugin is active.
 */
function theme_acf_pro() {

	if ( class_exists( 'acf_pro' ) ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Check for Advanced Custom Fields options page
 *
 * @since  1.0.0
 * @access public
 * @return bool Returns true if ACF 4.0 free plus the
 *              Options Page addon or Pro plugin is active.
 */
function theme_acf_options() {

	if ( class_exists( 'acf_pro' ) ) {
		return true;
	} elseif ( ( class_exists( 'acf' ) && class_exists( 'acf_options_page' ) ) ) {
		return true;
	} else {
		return false;
	}

}

/**
 * Additional hook for scripts & styles
 *
 * Triggered after the opening `<body>` tag.
 *
 * @link https://make.wordpress.org/themes/2019/03/29/addition-of-new-wp_body_open-hook/
 * @link https://developer.wordpress.org/reference/functions/wp_body_open/
 */
function body_open() {
	do_action( 'wp_body_open' );
	do_action( 'bs_body_open' );
}

/**
 * Site Schema
 *
 * Conditional Schema attributes for `<div id="page"`.
 *
 * @since  1.0.0
 * @access public
 * @return string Returns the relevant itemtype.
 */
function site_schema() {

	// Change page slugs and template names as needed.
	if ( is_page( 'about' ) || is_page( 'about-us' ) || is_page_template( 'page-about.php' ) || is_page_template( 'about.php' ) ) {
		$itemtype = esc_attr( 'AboutPage' );
	} elseif ( is_page( 'contact' ) || is_page( 'contact-us' ) || is_page_template( 'page-contact.php' ) || is_page_template( 'contact.php' ) ) {
		$itemtype = esc_attr( 'ContactPage' );
	} elseif ( is_page( 'faq' ) || is_page( 'faqs' ) || is_page_template( 'page-faq.php' ) || is_page_template( 'faq.php' ) ) {
		$itemtype = esc_attr( 'QAPage' );
	} elseif ( is_page( 'cart' ) || is_page( 'shopping-cart' ) || is_page( 'checkout' ) || is_page_template( 'cart.php' ) || is_page_template( 'checkout.php' ) ) {
		$itemtype = esc_attr( 'CheckoutPage' );
	} elseif ( is_front_page() || is_page() ) {
		$itemtype = esc_attr( 'WebPage' );
	} elseif ( is_author() || is_plugin_active( 'buddypress/bp-loader.php' ) && bp_is_home() || is_plugin_active( 'bbpress/bbpress.php' ) && bbp_is_user_home() ) {
		$itemtype = esc_attr( 'ProfilePage' );
	} elseif ( is_search() ) {
		$itemtype = esc_attr( 'SearchResultsPage' );
	} else {
		$itemtype = esc_attr( 'Blog' );
	}

	echo $itemtype;

}

/**
 * Featured projects galleries
 */
function projects_galleries() {

	$gallery = get_field( 'project_gallery' );
	$title   = get_field( 'project_title' );
	$count   = null;
	if ( $title ) {
		$title = $title;
	} else {
		$title = get_the_title();
	}
	if ( $gallery ) : $count = 0;
	foreach ( $gallery as $image ) : $count++;
		if ( $count != 1 ) : ?>
		<a class="gallery-image" data-fancybox="<?php echo 'gallery-' . get_the_ID(); ?>" data-type="image" data-fancybox-group="<?php echo 'gallery-' . get_the_ID(); ?>" data-caption="<?php echo __( 'Scenes from ' ) . $title; ?>" href="<?php echo $image['url']; ?>" title="<?php echo __( 'Scenes from ', 'affp-theme' ) . $title; ?>">
			 <img src="<?php echo $image['sizes']['large']; ?>" alt="<?php echo $image['alt']; ?>" />
		</a>
		<?php endif; if (++$count == 16) break; endforeach; endif; ?>

	<?php if ( $count > 8 ) : ?>
	<a class="fancybox-notice" data-fancybox="<?php echo 'gallery-' . get_the_ID(); ?>" data-src="<?php echo '#fancybox-page-link-' . get_the_ID(); ?>" href="javascript:;"></a>
	<div class="fancybox-page-link" id="<?php echo 'fancybox-page-link-' . get_the_ID(); ?>" data-type="image" data-fancybox-group="<?php echo 'gallery-' . get_the_ID(); ?>" data-caption="<?php echo __( 'Scenes from ' ) . $title; ?>">
		<h3><?php the_title(); ?></h3>
		<p><?php _e( 'More photos, video & info available on this project\'s page.', 'affp-theme' ); ?></p>
		<p><a class="fancybox-link" href="<?php the_permalink(); ?>"><?php _e( 'Take me there', 'affp-theme' ); ?></a> | <a href="javascript:jQuery.fancybox.close();"><?php _e( 'Close', 'affp-theme' ); ?></a></p>
	</div>
	<?php endif;
}

/**
 * Posted on
 *
 * Prints HTML with meta information for the current post-date/time.
 *
 * @since  1.0.0
 * @access public
 * @return string Returns the date posted.
 */
function posted_on() {

	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( DATE_W3C ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		/* translators: %s: post date. */
		esc_html_x( 'Posted on %s', 'post date', 'affp-theme' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

}

/**
 * Posted by
 *
 * Prints HTML with meta information for the current author.
 *
 * @since  1.0.0
 * @access public
 * @return string Returns the author name.
 */
function posted_by() {

	$byline = sprintf(
		esc_html_x( 'by %s', 'post author', 'affp-theme' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

}

/**
 * Entry footer
 *
 * Prints HTML with meta information for the categories, tags and comments.
 *
 * @since  1.0.0
 * @access public
 * @return string Returns various post-related links.
 */
function entry_footer() {

	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {

		$categories_list = get_the_category_list( esc_html__( ', ', 'affp-theme' ) );
		if ( $categories_list ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'affp-theme' ) . '</span>', $categories_list );
		}

		$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'affp-theme' ) );

		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'affp-theme' ) . '</span>', $tags_list );
		}

	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {

		echo '<span class="comments-link">';
		comments_popup_link(
			sprintf(
				wp_kses(
					__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'affp-theme' ),
					[
						'span' => [
							'class' => [],
						],
					]
				),
				get_the_title()
			)
		);
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			wp_kses(
				__( ' Edit <span class="screen-reader-text">%s</span>', 'affp-theme' ),
				[
					'span' => [
						'class' => [],
					],
				]
			),
			get_the_title()
		),
		'<span class="edit-link">',
		'</span>'
	);

}

/**
 * Post thumbnail
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 *
 * @since  1.0.0
 * @access public
 * @return string Returns HTML for the post thumbnail.
 */
function post_thumbnail() {

	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	// Check for the large 16:9 video image size.
	if ( has_image_size( 'image-name' ) ) {
		$size = 'large-video';
	} else {
		$size = 'post-thumbnail';
	}

	// Thumbnail image arguments.
	$args = [
		'alt'  => '',
		'role' => 'presentation'
	];


	if ( is_singular() ) :
		?>

		<div class="post-thumbnail">
			<?php the_post_thumbnail( $size, $args ); ?>
		</div>

		<?php
	else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php the_post_thumbnail( $size, $args ); ?>
		</a>

		<?php
	endif;
}

/**
 * Open template tags.
 *
 * Following are template tags for further development
 * by the theme author, child themes, or plugins.
 *
 * These are primarily provided as examples.
 *
 * @todo Possibly add more open tags but perhaps not,
 *       as this is a starter theme.
 *
 * @since  1.0.0
 * @access public
 */

// Fires after opening `body` and before `#page`.
function before_page() {
	do_action( 'before_page' );
}

// Fires after `#page` and before `wp_footer`.
function after_page() {
	do_action( 'after_page' );
}