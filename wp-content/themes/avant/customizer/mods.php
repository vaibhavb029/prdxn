<?php
/**
 * Functions used to implement options
 *
 * @package Customizer Library Avant
 */

/**
 * Enqueue Google Fonts Example
 */
function customizer_avant_fonts() {

	// Font options
	$fonts = array(
		get_theme_mod( 'avant-title-font', customizer_library_get_default( 'avant-title-font' ) ),
		get_theme_mod( 'avant-tagline-font', customizer_library_get_default( 'avant-tagline-font' ) ),
		get_theme_mod( 'avant-body-font', customizer_library_get_default( 'avant-body-font' ) ),
		get_theme_mod( 'avant-heading-font', customizer_library_get_default( 'avant-heading-font' ) )
	);

	$font_uri = customizer_library_get_google_font_uri( $fonts );

	// Load Google Fonts
	wp_enqueue_style( 'customizer_avant_fonts', $font_uri, array(), null, 'screen' );

}
add_action( 'wp_enqueue_scripts', 'customizer_avant_fonts' );
