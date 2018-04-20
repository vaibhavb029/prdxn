<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Avant
 */
if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
} ?>
<div id="secondary" class="widget-area <?php echo ( get_theme_mod( 'avant-page-sidebar-blocks' ) ) ? sanitize_html_class( 'sidebar-break-blocks' ) : ''; ?>" role="complementary">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</div><!-- #secondary -->