<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Avant
 */
global $woocommerce;
?><!DOCTYPE html><!-- Avant.ORG -->
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php if ( get_theme_mod( 'avant-site-add-side-social', customizer_library_get_default( 'avant-site-add-side-social' ) ) ) : ?>
	<div class="side-aligned-social hide-side-social">
		<?php get_template_part( '/templates/social-links' ); ?>
	</div>
<?php endif; ?>
<div id="page" class="hfeed site <?php echo ( get_theme_mod( 'avant-site-layout' ) == 'avant-site-boxed' ) ? sanitize_html_class( 'boxed-site' ) : ''; ?> <?php echo ( get_theme_mod( 'avant-slider-type' ) ) ? sanitize_html_class( get_theme_mod( 'avant-slider-type' ) ) : sanitize_html_class( 'avant-slider-default' ); ?> <?php echo ( get_theme_mod( 'avant-site-layout' ) ) ? sanitize_html_class( get_theme_mod( 'avant-site-layout' ) ) : sanitize_html_class( 'avant-site-full-width' ); ?>">
	
<?php echo ( get_theme_mod( 'avant-header-layout' ) != 'avant-header-layout-six' && get_theme_mod( 'avant-site-layout' ) == 'avant-site-boxed' ) ? '<div class="content-boxed">' : ''; ?>
	
<?php echo ( get_theme_mod( 'avant-header-layout' ) != 'avant-header-layout-six' && get_theme_mod( 'avant-site-layout' ) == 'avant-site-boxed' ) ? '<div class="site-boxed">' : ''; ?>
	
	<?php echo ( !get_theme_mod( 'avant-remove-topborder', customizer_library_get_default( 'avant-remove-topborder' ) ) ) ? '<div class="site-top-border"></div>' : ''; // Site Top Bar ?>
	
	<?php get_template_part( '/templates/header/header' ); // Get Site Headers ?>
	
<?php echo ( get_theme_mod( 'avant-header-layout' ) != 'avant-header-layout-six' && get_theme_mod( 'avant-site-layout' ) == 'avant-site-boxed' ) ? '</div>' : ''; ?>
	
	<?php if ( is_front_page() ) : ?>
		
		<?php get_template_part( '/templates/slider/homepage-slider' ); // Home Page Slider ?>
		
	<?php endif; ?>

<?php echo ( get_theme_mod( 'avant-header-layout' ) != 'avant-header-layout-six' && get_theme_mod( 'avant-site-layout' ) == 'avant-site-boxed' ) ? '<div class="site-boxed">' : ''; ?>

	<?php echo ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-six' ) ? '<div class="site-side-layout-container">' : ''; // Site Side Layout ?>
	
	<?php if ( !is_front_page() ) : ?>
		<?php if ( is_home() || is_archive() || is_search() || is_page() ) : ?>
			<?php get_template_part( '/templates/page-banner' ); ?>
		<?php else : ?>
			<?php get_template_part( '/templates/page-banner-single' ); ?>
		<?php endif; ?>
	<?php endif; ?>

	<div class="site-container <?php echo ( ! is_active_sidebar( 'sidebar-1' ) ) ? sanitize_html_class( 'content-no-sidebar' ) : sanitize_html_class( 'content-has-sidebar' ); ?> <?php echo ( get_theme_mod( 'avant-remove-product-border' ) ) ? sanitize_html_class( 'avant-products-noborder' ) : ''; ?> <?php echo ( get_theme_mod( 'avant-remove-wc-results-sorting' ) ) ? sanitize_html_class( 'avant-remove-results-sorting' ) : ''; ?> <?php echo ( get_theme_mod( 'avant-align-product-titles' ) ) ? sanitize_html_class( 'avant-wc-title-align' ) : ''; ?> <?php echo ( get_theme_mod( 'avant-remove-content-bgborder' ) ) ? sanitize_html_class( 'avant-content-nobgborder' ) : ''; ?> <?php echo ( get_theme_mod( 'avant-add-sidebar-line' ) ) ? sanitize_html_class( 'avant-add-sidebar-line' ) : ''; ?> <?php echo ( get_theme_mod( 'avant-blog-widget-title-leftalign' ) ) ? sanitize_html_class( 'avant-leftalign-widget-title' ) : ''; ?> <?php echo ( get_theme_mod( 'avant-blog-widget-title-style' ) ) ? sanitize_html_class( get_theme_mod( 'avant-blog-widget-title-style' ) ) : sanitize_html_class( 'widget-title-style-plain' ); ?>">