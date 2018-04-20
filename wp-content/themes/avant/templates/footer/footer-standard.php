<footer id="colophon" class="site-footer site-footer-standard">
	
	<div class="site-footer-widgets">
        <div class="site-container">
            <?php if ( is_active_sidebar( 'avant-site-footer-standard' ) ) : ?>
	            <ul>
	                <?php dynamic_sidebar( 'avant-site-footer-standard' ); ?>
	            </ul>
	        <?php else : ?>
	        	<div class="site-footer-no-widgets">
	        		<?php _e( 'Add your own widgets here', 'avant' ); ?>
	        	</div>
	    	<?php endif; ?>
            <div class="clearboth"></div>
        </div>
    </div>
	
</footer>
<div class="site-footer-bottom-bar <?php echo ( get_theme_mod( 'avant-bottombar-switch' ) ) ? sanitize_html_class( 'site-bottombar-switch' ) : ''; ?>">
	<?php printf( __( '<div class="site-container"><div class="site-footer-bottom-bar-left">Theme: %1$s by %2$s</div><div class="site-footer-bottom-bar-right">', 'avant' ), 'Avant', '<a href="https://kairaweb.com/">Kaira</a>' ); ?>
            <?php wp_nav_menu( array( 'theme_location' => 'footer-bar', 'container' => false, 'fallback_cb' => false, 'depth'  => 1 ) ); ?>
    <?php get_template_part( '/templates/social-links' ); ?></div></div><div class="clearboth"></div>
</div>