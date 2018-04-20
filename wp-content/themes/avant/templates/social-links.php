<?php
if( get_theme_mod( 'avant-social-email' ) ) :
    echo '<a href="' . esc_url( 'mailto:' . antispambot( get_theme_mod( 'avant-social-email' ), 1 ) ) . '" title="' . esc_attr__( 'Send Us an Email', 'avant' ) . '" class="social-icon social-email"><i class="fa fa-envelope-o"></i></a>';
endif;

if( get_theme_mod( 'avant-social-skype' ) ) :
    echo '<a href="skype:' . esc_html( get_theme_mod( 'avant-social-skype' ) ) . '?userinfo" title="' . esc_attr__( 'Contact Us on Skype', 'avant' ) . '" class="social-icon social-skype"><i class="fa fa-skype"></i></a>';
endif;

if( get_theme_mod( 'avant-social-facebook' ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'avant-social-facebook' ) ) . '" target="_blank" title="' . esc_attr__( 'Find Us on Facebook', 'avant' ) . '" class="social-icon social-facebook"><i class="fa fa-facebook"></i></a>';
endif;

if( get_theme_mod( 'avant-social-twitter' ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'avant-social-twitter' ) ) . '" target="_blank" title="' . esc_attr__( 'Follow Us on Twitter', 'avant' ) . '" class="social-icon social-twitter"><i class="fa fa-twitter"></i></a>';
endif;

if( get_theme_mod( 'avant-social-pinterest' ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'avant-social-pinterest' ) ) . '" target="_blank" title="' . esc_attr__( 'Find Us on Pinterest', 'avant' ) . '" class="social-icon social-pinterest"><i class="fa fa-pinterest"></i></a>';
endif;

if( get_theme_mod( 'avant-social-linkedin' ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'avant-social-linkedin' ) ) . '" target="_blank" title="' . esc_attr__( 'Find Us on LinkedIn', 'avant' ) . '" class="social-icon social-linkedin"><i class="fa fa-linkedin"></i></a>';
endif;

if( get_theme_mod( 'avant-social-tumblr' ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'avant-social-tumblr' ) ) . '" target="_blank" title="' . esc_attr__( 'Find Us on Tumblr', 'avant' ) . '" class="social-icon social-tumblr"><i class="fa fa-tumblr"></i></a>';
endif;

if( get_theme_mod( 'avant-social-flickr' ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'avant-social-flickr' ) ) . '" target="_blank" title="' . esc_attr__( 'Find Us on Flickr', 'avant' ) . '" class="social-icon social-flickr"><i class="fa fa-flickr"></i></a>';
endif;

if( get_theme_mod( 'avant-social-vk' ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'avant-social-vk' ) ) . '" target="_blank" title="' . esc_attr__( 'Find Us on VK', 'avant' ) . '" class="social-icon social-vk"><i class="fa fa-vk"></i></a>';
endif;

if( get_theme_mod( 'avant-social-github' ) ) :
    echo '<a href="' . esc_url( get_theme_mod( 'avant-social-github' ) ) . '" target="_blank" title="' . esc_attr__( 'Find Us on GitHub', 'avant' ) . '" class="social-icon social-github"><i class="fa fa-github"></i></a>';
endif;