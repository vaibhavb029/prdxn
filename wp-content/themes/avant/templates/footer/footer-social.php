<footer id="colophon" class="site-footer site-footer-social">
	
	<div class="site-footer-icons">
        <div class="site-container">
            
            <?php
			if( get_theme_mod( 'avant-social-email' ) ) :
			    echo '<a href="' . esc_url( 'mailto:' . antispambot( get_theme_mod( 'avant-social-email' ), 1 ) ) . '" title="' . esc_attr__( 'Send Us an Email', 'avant' ) . '" class="footer-social-icon footer-social-email"><i class="fa fa-envelope-o"></i></a>';
			endif;

			if( get_theme_mod( 'avant-social-skype' ) ) :
			    echo '<a href="skype:' . esc_html( get_theme_mod( 'avant-social-skype' ) ) . '?userinfo" title="' . esc_attr__( 'Contact Us on Skype', 'avant' ) . '" class="footer-social-icon footer-social-skype"><i class="fa fa-skype"></i></a>';
			endif;

			if( get_theme_mod( 'avant-social-facebook' ) ) :
			    echo '<a href="' . esc_url( get_theme_mod( 'avant-social-facebook' ) ) . '" target="_blank" title="' . esc_attr__( 'Find Us on Facebook', 'avant' ) . '" class="footer-social-icon footer-social-facebook"><i class="fa fa-facebook"></i></a>';
			endif;

			if( get_theme_mod( 'avant-social-twitter' ) ) :
			    echo '<a href="' . esc_url( get_theme_mod( 'avant-social-twitter' ) ) . '" target="_blank" title="' . esc_attr__( 'Follow Us on Twitter', 'avant' ) . '" class="footer-social-icon footer-social-twitter"><i class="fa fa-twitter"></i></a>';
			endif;
			
			if( get_theme_mod( 'avant-social-pinterest' ) ) :
			    echo '<a href="' . esc_url( get_theme_mod( 'avant-social-pinterest' ) ) . '" target="_blank" title="' . esc_attr__( 'Find Us on Pinterest', 'avant' ) . '" class="footer-social-icon footer-social-pinterest"><i class="fa fa-pinterest"></i></a>';
			endif;
			
			if( get_theme_mod( 'avant-social-linkedin' ) ) :
			    echo '<a href="' . esc_url( get_theme_mod( 'avant-social-linkedin' ) ) . '" target="_blank" title="' . esc_attr__( 'Find Us on LinkedIn', 'avant' ) . '" class="footer-social-icon footer-social-linkedin"><i class="fa fa-linkedin"></i></a>';
			endif;

			if( get_theme_mod( 'avant-social-tumblr' ) ) :
			    echo '<a href="' . esc_url( get_theme_mod( 'avant-social-tumblr' ) ) . '" target="_blank" title="' . esc_attr__( 'Find Us on Tumblr', 'avant' ) . '" class="footer-social-icon footer-social-tumblr"><i class="fa fa-tumblr"></i></a>';
			endif;

			if( get_theme_mod( 'avant-social-flickr' ) ) :
			    echo '<a href="' . esc_url( get_theme_mod( 'avant-social-flickr' ) ) . '" target="_blank" title="' . esc_attr__( 'Find Us on Flickr', 'avant' ) . '" class="footer-social-icon footer-social-flickr"><i class="fa fa-flickr"></i></a>';
			endif;
			
			if( get_theme_mod( 'avant-social-vk' ) ) :
			    echo '<a href="' . esc_url( get_theme_mod( 'avant-social-vk' ) ) . '" target="_blank" title="' . esc_attr__( 'Find Us on VK', 'avant' ) . '" class="footer-social-icon social-vk"><i class="fa fa-vk"></i></a>';
			endif;
			
			if( get_theme_mod( 'avant-social-github' ) ) :
			    echo '<a href="' . esc_url( get_theme_mod( 'avant-social-github' ) ) . '" target="_blank" title="' . esc_attr__( 'Find Us on GitHub', 'avant' ) . '" class="footer-social-icon footer-social-github"><i class="fa fa-github"></i></a>';
			endif; ?>
			
		<?php printf( __( '<div class="site-footer-social-copy">Theme: %1$s by %2$s', 'avant' ), 'Avant', '<a href="https://kairaweb.com/">Kaira</a></div><div class="clearboth"></div></div>' ); ?>
</div></footer><div class="site-social-bottom-bar site-footer-bottom-bar">
	<div class="site-container">
        <?php wp_nav_menu( array( 'theme_location' => 'footer-bar', 'container' => false, 'depth'  => 1 ) ); ?>
    </div><div class="clearboth"></div>
</div>