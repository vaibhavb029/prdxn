<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @package Avant
 */

/**
 * Add theme support for Infinite Scroll.
 * See: https://jetpack.me/support/infinite-scroll/
 */
function avant_jetpack_setup() {
	add_theme_support( 'infinite-scroll', array(
		'container' => 'main',
		'render'    => 'avant_infinite_scroll_render',
		'footer'    => 'page',
	) );
} // end function avant_jetpack_setup
add_action( 'after_setup_theme', 'avant_jetpack_setup' );

function avant_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();
		get_template_part( 'templates/contents/content' );
	}
} // end function avant_infinite_scroll_render