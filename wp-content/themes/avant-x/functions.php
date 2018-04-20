<?php
/**
 * Avant-X Child functions and definitions
 */
define( 'AVANTX_THEME_VERSION' , '1.0.1' );

/**
 * Enqueue parent theme style
 */
function avantx_child_enqueue_styles() {
    wp_enqueue_style( 'avant-default-fonts', '//fonts.googleapis.com/css?family=Abel|Open+Sans:300,300i,400,400i,700,700i', array(), AVANTX_THEME_VERSION );
    wp_enqueue_style( 'avant-style', get_template_directory_uri() . '/style.css', array(), AVANTX_THEME_VERSION );
    
    if ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-seven' ) :
        wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-seven.css", array(), AVANTX_THEME_VERSION );
    elseif ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-six' ) :
        wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-six.css", array(), AVANTX_THEME_VERSION );
    elseif ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-five' ) :
        wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-five.css", array(), AVANTX_THEME_VERSION );
    elseif ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-three' ) :
        wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-three.css", array(), AVANTX_THEME_VERSION );
    elseif ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-one' ) :
        wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-one.css", array(), AVANTX_THEME_VERSION );
    elseif ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-two' ) :
        wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-two.css", array(), AVANTX_THEME_VERSION );
    else :
        wp_enqueue_style( 'avant-header-style', get_template_directory_uri()."/templates/header/css/header-four.css", array(), AVANTX_THEME_VERSION );
    endif;
    
    wp_enqueue_style( 'avant-child-style-avantx', get_stylesheet_uri(), array( 'avant-style' ), AVANTX_THEME_VERSION );
}
add_action( 'wp_enqueue_scripts', 'avantx_child_enqueue_styles' );

/**
 * Enqueue Avant-X custom customizer styling.
 */
function avantx_load_customizer_settings() {
    global $wp_customize;
    $wp_customize->get_setting( 'avant-header-layout' )->default = 'avant-header-layout-four';
    $wp_customize->get_setting( 'avant-topbar-bg-color' )->default = '#000000';
    $wp_customize->get_setting( 'avant-topbar-font-color' )->default = '#e5e5e5';
    $wp_customize->get_setting( 'avant-primary-color' )->default = '#000000';
    $wp_customize->get_setting( 'avant-secondary-color' )->default = '#a8a8a8';
}
add_action( 'customize_controls_init', 'avantx_load_customizer_settings' );
add_action( 'customize_preview_init', 'avantx_load_customizer_settings' );