<?php
/**
 * AMS Child Theme.
 *
 * This file adds the Customizer additions to the AMS Child Theme Theme.
 *
 * @package AMS Child Theme
 * @author  AM Solutions
 * @license GPL-2.0-or-later
 * @link    https://allmarketingsolutions.co.uk/
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Remove Genesis child theme style sheet
 *
 * @uses  genesis_meta  <genesis/lib/css/load-styles.php>
*/

remove_action( 'genesis_meta', 'genesis_load_stylesheet' );

	/**
	 * Load theme's JavaScript and CSS sources.
	 */
function ams_scripts() {
	// Get the theme data.
	$the_theme     = wp_get_theme();
	$theme_version = $the_theme->get( 'Version' );

	$css_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . '/css/style.min.css' );
	wp_enqueue_style( 'ams-styles', get_stylesheet_directory_uri() . '/css/style.min.css', [], $css_version );

	$js_version = $theme_version . '.' . filemtime( get_stylesheet_directory() . '/js/theme.min.js' );
	wp_enqueue_script( 'ams-scripts', get_stylesheet_directory_uri() . '/js/theme.min.js', [], $js_version, true );
}

add_action( 'wp_enqueue_scripts', 'ams_scripts' );
