<?php
/**
 * AMS Child Theme.
 *
 * This file adds the default theme settings to the AMS Child Theme Theme.
 *
 * @package AMS Child Theme
 * @author  AM Solutions
 * @license GPL-2.0-or-later
 * @link    https://allmarketingsolutions.co.uk/
 */

add_filter( 'simple_social_default_styles', 'ams_social_default_styles' );
/**
 * Set Simple Social Icon defaults.
 *
 * @since 1.0.0
 *
 * @param array $defaults Social style defaults.
 * @return array Modified social style defaults.
 */
function ams_social_default_styles( $defaults ) {

	$args = genesis_get_config( 'simple-social-icons-settings' );

	return wp_parse_args( $args, $defaults );

}
