<?php
/**
 * AMS Child Theme.
 *
 * This file adds functions to the AMS Child Theme Theme.
 *
 * @package AMS Child Theme
 * @author  AM Solutions
 * @license GPL-2.0-or-later
 * @link    https://allmarketingsolutions.co.uk/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

add_action( 'after_setup_theme', 'ams_localization_setup' );
/**
 * Sets localization (do not remove).
 *
 * @since 1.0.0
 */
function ams_localization_setup() {

	load_child_theme_textdomain( genesis_get_theme_handle(), get_stylesheet_directory() . '/languages' );

}

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/enqueue.php';

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

add_action( 'after_setup_theme', 'genesis_child_gutenberg_support' );
/**
 * Adds Gutenberg opt-in features and styling.
 *
 * @since 2.7.0
 */
function genesis_child_gutenberg_support() { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- using same in all child themes to allow action to be unhooked.
	require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';
}

// Registers the responsive menus.
if ( function_exists( 'genesis_register_responsive_menus' ) ) {
	genesis_register_responsive_menus( genesis_get_config( 'responsive-menus' ) );
}

add_action( 'wp_enqueue_scripts', 'ams_enqueue_scripts_styles' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function ams_enqueue_scripts_styles() {

	$appearance = genesis_get_config( 'appearance' );

	wp_enqueue_style(
		genesis_get_theme_handle() . '-fonts',
		$appearance['fonts-url'],
		[],
		genesis_get_theme_version()
	);

	if ( genesis_is_amp() ) {
		wp_enqueue_style(
			genesis_get_theme_handle() . '-amp',
			get_stylesheet_directory_uri() . '/lib/amp/amp.css',
			[ genesis_get_theme_handle() ],
			genesis_get_theme_version()
		);
	}

}

add_action( 'after_setup_theme', 'ams_theme_support', 9 );
/**
 * Add desired theme supports.
 *
 * See config file at `config/theme-supports.php`.
 *
 * @since 3.0.0
 */
function ams_theme_support() {

	$theme_supports = genesis_get_config( 'theme-supports' );

	foreach ( $theme_supports as $feature => $args ) {
		add_theme_support( $feature, $args );
	}

}

add_action( 'after_setup_theme', 'ams_post_type_support', 9 );
/**
 * Add desired post type supports.
 *
 * See config file at `config/post-type-supports.php`.
 *
 * @since 3.0.0
 */
function ams_post_type_support() {

	$post_type_supports = genesis_get_config( 'post-type-supports' );

	foreach ( $post_type_supports as $post_type => $args ) {
		add_post_type_support( $post_type, $args );
	}

}

// Adds image sizes.
add_image_size( 'sidebar-featured', 75, 75, true );
add_image_size( 'genesis-singular-images', 702, 526, true );

// Removes header right widget area.
//unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 10 );

add_filter( 'wp_nav_menu_args', 'ams_secondary_menu_args' );
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function ams_secondary_menu_args( $args ) {

	if ( 'secondary' === $args['theme_location'] ) {
		$args['depth'] = 1;
	}

	return $args;

}

add_filter( 'genesis_author_box_gravatar_size', 'ams_author_box_gravatar' );
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function ams_author_box_gravatar( $size ) {

	return 90;

}

add_filter( 'genesis_comment_list_args', 'ams_comments_gravatar' );
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function ams_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}


/** Remove Site Header from blog page **/
add_action( 'get_header', 'remove_titles_home_page' );
function remove_titles_home_page() {

	remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
	//* Remove the entry meta in the entry header (requires HTML5 theme support)
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	//* Remove the entry meta in the entry footer (requires HTML5 theme support)
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );


	//Removes Title and Description on CPT Archive
remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
//Removes Title and Description on Blog Archive
remove_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );
//Removes Title and Description on Date Archive
remove_action( 'genesis_before_loop', 'genesis_do_date_archive_title' );
//Removes Title and Description on Archive, Taxonomy, Category, Tag
remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
//Removes Title and Description on Author Archive
remove_action( 'genesis_before_loop', 'genesis_do_author_title_description', 15 );
//Removes Title and Description on Blog Template Page
remove_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );
	
}



/**
 * Add custom taxonomy for Post
 */
register_taxonomy(
	'brand',
	'post',
	array(
		'labels' => array(
			'name' => 'Brand',
			'add_new_item' => 'Add New Brand',
			'new_item_name' => "New Brand"
		),
		'show_ui' => true,
		'show_tagcloud' => true,
		'hierarchical' => true,
		'has_archive' => true,
		'show_in_rest' => true
	)
);
/** Featured Image option **/
function featured_header_content() {
	global $post;
	$post_id = $post->ID;
	$url_img = wp_get_attachment_url( get_post_thumbnail_id($post->ID));
	$value_title = get_field( "title" );
	$value_description = get_field( "description" );
	$category = get_queried_object();
	$author_id = $post->post_author;
	$prev_post = get_adjacent_post(false, '', true);
	$next_post = get_adjacent_post(false, '', false);

	if ( is_front_page() || is_home() ) {
		echo  '<div class="blog-page-inner" style="background-image: url('. wp_get_attachment_url( get_post_thumbnail_id('17')) .');"><div class="wrap"><h1>'. get_the_title('17') .'</h1></div></div>';
		echo  '<div class="inner-page-contxt"><div class="wrap"><h2>'. get_field( "title" , '17') .'</h2>'. get_field( "description" , '17') .'</div></div>';
	}
	if ( is_single() ){
		echo  '<div class="blog-page-inner" style="background-image: url('. $url_img .');"><div class="wrap"><b>'. get_the_title('17') .'</b></div></div>';
		echo '<div class="post-meta-contxt"><div class="wrap">
		<div class="custom-breadcrumbs-single"><a href="#">Home</a> > <a href="#">Blog</a> > <span>'. get_the_title($post_id) .'</span></div>';
		echo '<div class="post-next-pre-contxt">';
		if(!empty($prev_post)) {
			echo '<a href="' . get_permalink($prev_post->ID) . '" title="' . $prev_post->post_title . '" class="pre-post">Previous</a>';
		}
		echo '| <span>Article</span> |';
		if(!empty($next_post)) {
			echo '<a href="' . get_permalink($next_post->ID) . '" title="' . $next_post->post_title . '" class="next-post">Next</a>';
		}
		echo '</div><div class="post-info-meta-contxt">';

		echo 'By <a href="'. get_author_posts_url( $author_id ) .'"> '. get_the_author_meta( 'nicename', $author_id ) .' </a> on <time datetime="'. get_the_date($post_id) .'" itemprop="datePublished">'. get_the_date( 'm/j/Y' , $post_id) .'</time>

		</div></div></div>';
		
		echo  '<div class="inner-page-contxt"><div class="wrap"><h1>'. get_the_title($post_id) .'</h1>'.$value_description.'</div></div>';
	}
	if ( is_author() ) {
		echo  '<div class="blog-page-inner archive-cwp-loop" style="background-image: url('. wp_get_attachment_url( get_post_thumbnail_id('17')) .');"><div class="wrap"><h1>'. get_the_author_meta( 'nicename', $author_id ) .'</h1></div></div>';
	}
	if ( is_category('category') ) {
		echo  '<div class="blog-page-inner archive-cwp-loop" style="background-image: url('. wp_get_attachment_url( get_post_thumbnail_id('17')) .');"><div class="wrap"><h1>'. $category->name .'</h1></div></div>';
	}
	if ( is_tag('post_tag') ) {
		echo  '<div class="blog-page-inner archive-cwp-loop" style="background-image: url('. wp_get_attachment_url( get_post_thumbnail_id('17')) .');"><div class="wrap"><h1>'. $category->name .'</h1></div></div>';
	}
	if ( is_archive( 'brand' ) && !is_author() ) {
		echo  '<div class="blog-page-inner archive-cwp-loop" style="background-image: url('. wp_get_attachment_url( get_post_thumbnail_id('17')) .');"><div class="wrap"><h1>'. $category->name .'</h1></div></div>';
	}
	if ( is_404() ) {
		echo  '<div class="blog-page-inner archive-cwp-loop" style="background-image: url('. wp_get_attachment_url( get_post_thumbnail_id('17')) .');"><div class="wrap"><h1>404</h1></div></div>';
	}
	if ( is_search() ) {
		echo  '<div class="blog-page-inner archive-cwp-loop" style="background-image: url('. wp_get_attachment_url( get_post_thumbnail_id('17')) .');"><div class="wrap"><b>Search Results for:</b></div></div>';
	}
}
add_action( 'genesis_after_header', 'featured_header_content' );

/** Custom Page title option in h2 **/
function cwp_title_text() {
	if ( !is_singular() ) {
		echo '<header class="entry-header"><h2 class="entry-title" itemprop="headline">'. get_the_title($post->ID) .'</h2></header>';
	}
}
add_action('genesis_entry_content', 'cwp_title_text', 1 );


/** Add learn more button and category at archive page **/
function cwp_link_button_text() {
	if ( !is_singular() ) {
	echo '<div class="entry-footer-cwp">';
	echo '<div class="entry-button"><a class="button-cwp" href="'. get_the_permalink($post->ID) .'">LEARN MORE </a>⟶</div>';
	echo '<div class="entry-categories">';
	$categories = get_the_tags();
	$separator = ',';
	$output = '';
	if ( ! empty( $categories ) ) {
		foreach( $categories as $category ) {
			$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
		}
		echo trim( $output, $separator );
	}
	echo '</div>';
	echo '</div>';
	}
}
add_action('genesis_entry_content', 'cwp_link_button_text' );

/** Single Post Meta Info  option **/
function post_meta_info_content() {
	
	global $post;
	$post_id = $post->ID;
	$author_id = $post->post_author;

	$tags = get_the_tags();
	$separator = ',';
	$output = '';
	$categories = get_the_category();
	$outputs = '';
	$terms = get_the_terms($post_id, 'brand');
	$termsoutputs = '';
	if ( is_singular() ) {
		echo '<div class="post-meta-info-content-sing">';
		if ( ! empty( $categories ) ) {
			echo '<h3>Categories</h3>';
			foreach( $categories as $category ) {
				$outputs .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
			}
			echo trim( $outputs, $separator );
		}
		if ( ! empty( $tags ) ) {
			echo '<h3>Tags</h3>';
			foreach( $tags as $tag ) {
				$output .= '<span>' . esc_html( $tag->name ) . '</span>' . $separator;
			}
			echo trim( $output, $separator );
		}
		echo '<h3>Posted by</h3>';
		echo '<a href="'. get_author_posts_url( $author_id ) .'"> '. get_the_author_meta( 'nicename', $author_id ) .' </a>';
		echo '<h3>Date</h3>';
		echo '<time datetime="'. get_the_date($post_id) .'" itemprop="datePublished">'. get_the_date( 'M j ,Y' , $post_id) .'</time>';
		
		if ( ! empty( $terms ) ) {
			echo '<h3>Brand</h3>';
			foreach( $terms as $term ) {
				$termsoutputs .= '<a href="' . esc_url( get_category_link( $term->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $term->name ) ) . '">' . esc_html( $term->name ) . '</a>' . $separator;
			}
			echo trim( $termsoutputs, $separator );
		}
		echo '</div>';
	}
}
add_action('genesis_entry_content', 'post_meta_info_content' );

/** Featured Image option **/
function next_pre_content() {
	$prev_post = get_adjacent_post(false, '', true);
	$next_post = get_adjacent_post(false, '', false);
	if ( is_single() ){
	echo '<div class="post-next-pre-side">';
		if(!empty($prev_post)) {
			echo '<a href="' . get_permalink($prev_post->ID) . '" title="' . $prev_post->post_title . '" class="pre-post">Previous</a>';
		}
		echo '| <span>Article</span> |';

		if(!empty($next_post)) {
			echo '<a href="' . get_permalink($next_post->ID) . '" title="' . $next_post->post_title . '" class="next-post">Next</a>';
		}
	echo '</div>';
	}
}
add_action('genesis_entry_footer', 'next_pre_content' );
