<footer id="colophon" class="site-footer site-footer-none">
	<div class="site-footer-bottom-bar <?php echo ( get_theme_mod( 'avant-bottombar-switch' ) ) ? sanitize_html_class( 'site-bottombar-switch' ) : ''; ?>">
		<?php printf( __( '<div class="site-container"><div class="site-footer-bottom-bar-left">Theme: %1$s by %2$s</div><div class="site-footer-bottom-bar-right">', 'avant' ), 'Avant', '<a href="https://kairaweb.com/">Kaira</a>' ); ?>
	        <?php wp_nav_menu( array( 'theme_location' => 'footer-bar', 'container' => false, 'fallback_cb' => false, 'depth'  => 1 ) ); ?>
        <?php get_template_part( '/templates/social-links' ); ?>
    </div></div><div class="clearboth"></div></div>
</footer>