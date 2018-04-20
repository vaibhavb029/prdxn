<?php
/**
 * Functions for users wanting to upgrade to premium
 *
 * @package Avant
 */

/**
 * Display the upgrade to Premium page & load styles.
 */
function avant_premium_admin_menu() {
    global $avant_upgrade_page;
    $avant_upgrade_page = add_theme_page( __( 'About Avant', 'avant' ), '<span class="premium-link">' . __( 'About Avant', 'avant' ) . '</span>', 'edit_theme_options', 'avant_theme_info', 'avant_render_upgrade_page' );
}
add_action( 'admin_menu', 'avant_premium_admin_menu' );

/**
 * Enqueue admin stylesheet only on upgrade page.
 */
function avant_load_upgrade_page_scripts() {
    global $pagenow;
	if ( $pagenow == 'themes.php' ) {
		wp_enqueue_style( 'avant-upgrade-css', get_template_directory_uri() . '/upgrade/css/upgrade-admin.css' );
	    wp_enqueue_script( 'caroufredsel', get_template_directory_uri() . '/js/caroufredsel/jquery.carouFredSel-6.2.1-packed.js', array( 'jquery' ), AVANT_THEME_VERSION, true );
	    wp_enqueue_script( 'avant-upgrade-js', get_template_directory_uri() . '/upgrade/js/upgrade-custom.js', array( 'jquery' ), AVANT_THEME_VERSION, true );
	}
}
add_action( 'admin_enqueue_scripts', 'avant_load_upgrade_page_scripts' );

/**
 * Render the premium page to download premium upgrade plugin
 */
function avant_render_upgrade_page() {
	get_template_part( 'upgrade/tpl/upgrade-page' );
}