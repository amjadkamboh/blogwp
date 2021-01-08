<?php
/**
 * AMS Child Theme appearance settings.
 *
 * @package AMS Child Theme
 * @author  AM Solutions
 * @license GPL-2.0-or-later
 * @link    https://allmarketingsolutions.co.uk/
 */

$ams_default_colors = [
	'link'   => '#0073e5',
	'accent' => '#0073e5',
];

$ams_link_color = get_theme_mod(
	'ams_link_color',
	$ams_default_colors['link']
);

$ams_accent_color = get_theme_mod(
	'ams_accent_color',
	$ams_default_colors['accent']
);

$ams_link_color_contrast   = ams_color_contrast( $ams_link_color );
$ams_link_color_brightness = ams_color_brightness( $ams_link_color, 35 );

return [
	'fonts-url'            => 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,700&display=swap',
	'content-width'        => 1062,
	'button-bg'            => $ams_link_color,
	'button-color'         => $ams_link_color_contrast,
	'button-outline-hover' => $ams_link_color_brightness,
	'link-color'           => $ams_link_color,
	'default-colors'       => $ams_default_colors,
	'editor-color-palette' => [
		[
			'name'  => __( 'Custom color', 'genesis-sample' ), // Called “Link Color” in the Customizer options. Renamed because “Link Color” implies it can only be used for links.
			'slug'  => 'theme-primary',
			'color' => $ams_link_color,
		],
		[
			'name'  => __( 'Accent color', 'genesis-sample' ),
			'slug'  => 'theme-secondary',
			'color' => $ams_accent_color,
		],
	],
	'editor-font-sizes'    => [
		[
			'name' => __( 'Small', 'genesis-sample' ),
			'size' => 12,
			'slug' => 'small',
		],
		[
			'name' => __( 'Normal', 'genesis-sample' ),
			'size' => 18,
			'slug' => 'normal',
		],
		[
			'name' => __( 'Large', 'genesis-sample' ),
			'size' => 20,
			'slug' => 'large',
		],
		[
			'name' => __( 'Larger', 'genesis-sample' ),
			'size' => 24,
			'slug' => 'larger',
		],
	],
];
