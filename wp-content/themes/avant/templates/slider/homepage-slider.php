<?php if ( get_theme_mod( 'avant-slider-type' ) == 'avant-no-slider' ) : ?>
    
    <!-- No Slider -->
    
<?php elseif ( get_theme_mod( 'avant-slider-type' ) == 'avant-home-featured-image' ) : ?>
    
    <?php
    $home_page_id = get_option( 'page_on_front' );
    if ( 'page' == get_option( 'show_on_front' ) && has_post_thumbnail( $home_page_id ) ) : ?>
        
        <?php echo ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-six' ) ? '<div class="site-side-layout-container">' : ''; ?>
        
            <?php echo ( !get_theme_mod( 'avant-slidermage-fullwidth', customizer_library_get_default( 'avant-slidermage-fullwidth' ) ) ) ? '<div class="site-container">' : ''; ?>
                
                <div class="page-fimage-banner <?php echo ( get_theme_mod( 'avant-slidermage-size' ) == 'avant-slidermage-size-actual' ) ? sanitize_html_class( 'slidermage-banner-actual' ) : ''; ?>" <?php echo ( get_theme_mod( 'avant-slidermage-size' ) != 'avant-slidermage-size-actual' ) ? 'style="background-image: url(' . esc_url( get_the_post_thumbnail_url( $home_page_id ) ) . ');"' : ''; ?>>
                    
                    <?php if ( get_theme_mod( 'avant-slidermage-size' ) == 'avant-slidermage-size-actual' ) : ?>
                        <img src="<?php echo get_the_post_thumbnail_url( $home_page_id ); ?>" />
                    <?php elseif ( get_theme_mod( 'avant-slidermage-size' ) == 'avant-slidermage-size-extra-small' ) : ?>
                        <img src="<?php echo get_template_directory_uri() ?>/images/slider_blank_img_extra_small.gif" />
                    <?php elseif ( get_theme_mod( 'avant-slidermage-size' ) == 'avant-slidermage-size-small' ) : ?>
                        <img src="<?php echo get_template_directory_uri() ?>/images/slider_blank_img_small.gif" />
                    <?php elseif ( get_theme_mod( 'avant-slidermage-size' ) == 'avant-slidermage-size-large' ) : ?>
                        <img src="<?php echo get_template_directory_uri() ?>/images/slider_blank_img_large.gif" />
                    <?php else : ?>
                        <img src="<?php echo get_template_directory_uri() ?>/images/slider_blank_img_medium.gif" />
                    <?php endif; ?>
                    
                </div> <!-- .page-fimage-banner -->
                
            <?php echo ( !get_theme_mod( 'avant-slidermage-fullwidth', customizer_library_get_default( 'avant-slidermage-fullwidth' ) ) ) ? '</div>' : ''; ?>
        
        <?php echo ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-six' ) ? '</div>' : ''; ?>
        
    <?php endif; ?>

<?php elseif ( get_theme_mod( 'avant-slider-type' ) == 'avant-shortcode-slider' ) : ?>
    
    <?php
    $slider_code = '';
    if ( get_theme_mod( 'avant-slider-shortcode' ) ) {
        $slider_code = get_theme_mod( 'avant-slider-shortcode' );
    } ?>
    
    <?php echo ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-six' ) ? '<div class="site-side-layout-container">' : ''; ?>
    
        <?php if ( $slider_code ) : ?>
            <?php echo do_shortcode( sanitize_text_field( $slider_code ) ); ?>
        <?php else : ?>
            <?php if ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-six' ) : ?>
                <div class="home-slider-empty"></div>
            <?php endif; ?>
        <?php endif; ?>
        
    <?php echo ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-six' ) ? '</div>' : ''; ?>
    
<?php else : ?>
    
    <?php
    $slider_cats = '';
    if ( get_theme_mod( 'avant-slider-cats' ) ) {
        $slider_cats = get_theme_mod( 'avant-slider-cats' );
    } ?>
    
    <?php if ( $slider_cats ) : ?>
        
        <?php $slider_query = new WP_Query( 'cat=' . esc_html( $slider_cats ) . '&posts_per_page=-1&orderby=date&order=DESC' ); ?>
        
        <?php if ( $slider_query->have_posts() ) : ?>
            
                <div class="home-slider-wrap home-slider-remove <?php echo ( get_theme_mod( 'avant-site-layout' ) == 'avant-site-boxed' ) ? sanitize_html_class( 'slider-site-boxed' ) : ''; ?> <?php echo ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-six' ) ? sanitize_html_class( 'home-slider-header-six' ) : ''; ?>" data-auto="<?php echo ( get_theme_mod( 'avant-slider-auto-scroll' ) ) ? esc_attr( 'false' ) : esc_attr( '6500' ); ?>" data-scroll="<?php echo ( get_theme_mod( 'avant-slider-scroll-effect' ) ) ? esc_attr( get_theme_mod( 'avant-slider-scroll-effect' ) ) : esc_attr( 'crossfade' ); ?>">
                    
                    <?php echo ( !get_theme_mod( 'avant-slider-full-width', customizer_library_get_default( 'avant-slider-full-width' ) ) ) ? '<div class="site-container">' : ''; ?>
                        <div class="home-slider-prev"><i class="fa fa-angle-left"></i></div>
                        <div class="home-slider-next"><i class="fa fa-angle-right"></i></div>
                        
                        <div class="home-slider">
                            
                            <?php while ( $slider_query->have_posts() ) : $slider_query->the_post();
                                $slider_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>
                                
                                <?php if ( get_theme_mod( 'avant-slider-linkto-post' ) ) : ?>
                                <a class="home-slider-block" href="<?php the_permalink(); ?>" <?php echo ( has_post_thumbnail() ) ? 'style="background-image: url(' . esc_url( $slider_thumbnail['0'] ) . ');"' : ''; ?>>
                                <?php else : ?>
                                <div class="home-slider-block"<?php echo ( has_post_thumbnail() ) ? ' style="background-image: url(' . esc_url( $slider_thumbnail['0'] ) . ');"' : ''; ?>>
                                <?php endif; ?>
                                
                                    <?php if ( get_theme_mod( 'avant-slider-size' ) == 'avant-slider-size-small' ) : ?>
                                        <img src="<?php echo get_template_directory_uri() ?>/images/slider_blank_img_small.gif" />
                                    <?php elseif ( get_theme_mod( 'avant-slider-size' ) == 'avant-slider-size-large' ) : ?>
                                        <img src="<?php echo get_template_directory_uri() ?>/images/slider_blank_img_large.gif" />
                                    <?php else : ?>
                                        <img src="<?php echo get_template_directory_uri() ?>/images/slider_blank_img_medium.gif" />
                                    <?php endif; ?>
                                    
                                    <?php if ( !get_theme_mod( 'avant-slider-remove-title', customizer_library_get_default( 'avant-slider-remove-title' ) ) ) : ?>
                                    
                                        <div class="home-slider-block-inner">
                                            <div class="home-slider-block-bg">
                                                <h3>
                                                    <?php the_title(); ?>
                                                </h3>
                                                <?php if ( !get_theme_mod( 'avant-slider-remove-sub-title', customizer_library_get_default( 'avant-slider-remove-sub-title' ) ) ) : ?>
                                                    <?php if ( has_excerpt() ) : ?>
                                                        <p><?php the_excerpt(); ?></p>
                                                    <?php else : ?>
                                                        <p><?php the_content(); ?></p>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        
                                    <?php endif; ?>
                                    
                                <?php if ( get_theme_mod( 'avant-slider-linkto-post' ) ) : ?>
                                </a>
                                <?php else : ?>
                                </div>
                                <?php endif; ?>
                            
                            <?php endwhile; ?>
                            
                        </div>
                        
                    <?php echo ( !get_theme_mod( 'avant-slider-full-width', customizer_library_get_default( 'avant-slider-full-width' ) ) ) ? '</div>' : ''; ?>
                    
                    <?php if ( !get_theme_mod( 'avant-slider-remove-pagination', customizer_library_get_default( 'avant-slider-remove-pagination' ) ) ) : ?>
                        <div class="home-slider-pager"></div>
                    <?php endif; ?>
                </div>
                <?php do_action ( 'avant_after_default_slider' ); ?>
            
        <?php else : ?>
            
            <?php if ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-six' ) : ?>
                <div class="home-slider-empty"></div>
            <?php endif; ?>
            
        <?php endif; wp_reset_postdata(); ?>
        
    <?php else : ?>
        
        <div class="home-slider-wrap home-slider-remove <?php echo ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-six' ) ? sanitize_html_class( 'home-slider-header-six' ) : ''; ?>" data-auto="<?php echo ( get_theme_mod( 'avant-slider-auto-scroll' ) ) ? esc_attr( 'false' ) : esc_attr( '6500' ); ?>" data-scroll="<?php echo ( get_theme_mod( 'avant-slider-scroll-effect' ) ) ? esc_attr( get_theme_mod( 'avant-slider-scroll-effect' ) ) : esc_attr( 'crossfade' ); ?>">
            <div class="home-slider-wrap-hint">
                <?php _e( 'See how to', 'avant' ); ?> <a href="https://kairaweb.com/documentation/setting-up-the-default-slider/" target="_blank"><?php _e( 'Add your own slides here', 'avant' ); ?></a>
            </div>
            
            <?php echo ( !get_theme_mod( 'avant-slider-full-width', customizer_library_get_default( 'avant-slider-full-width' ) ) ) ? '<div class="site-container">' : ''; ?>
                <div class="home-slider-prev"><i class="fa fa-angle-left"></i></div>
                <div class="home-slider-next"><i class="fa fa-angle-right"></i></div>
                
                <div class="home-slider">
                    
                    <div class="home-slider-block" style="background-image: url(<?php echo get_stylesheet_directory_uri() ?>/images/demo/slider_default_01.jpg);">
                        
                        <?php if ( get_theme_mod( 'avant-slider-size' ) == 'avant-slider-size-small' ) : ?>
                            <img src="<?php echo get_template_directory_uri() ?>/images/slider_blank_img_small.gif" />
                        <?php elseif ( get_theme_mod( 'avant-slider-size' ) == 'avant-slider-size-large' ) : ?>
                            <img src="<?php echo get_template_directory_uri() ?>/images/slider_blank_img_large.gif" />
                        <?php else : ?>
                            <img src="<?php echo get_template_directory_uri() ?>/images/slider_blank_img_medium.gif" />
                        <?php endif; ?>
                        
                        <?php if ( !get_theme_mod( 'avant-slider-remove-title', customizer_library_get_default( 'avant-slider-remove-title' ) ) ) : ?>
                            
                            <div class="home-slider-block-inner">
                                <div class="home-slider-block-bg">
                                    <h3>
                                        <?php _e( 'Paint A Picture', 'avant' ); ?>
                                    </h3>
                                    <?php if ( !get_theme_mod( 'avant-slider-remove-sub-title', customizer_library_get_default( 'avant-slider-remove-sub-title' ) ) ) : ?>
                                        <p><?php _e( 'Are you shopping anywhere, changed the color of your hair, are you busy?', 'avant' ); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                        <?php endif; ?>
                        
                    </div>
                    
                </div>
                
            <?php echo ( !get_theme_mod( 'avant-slider-full-width', customizer_library_get_default( 'avant-slider-full-width' ) ) ) ? '</div>' : ''; ?>
            
            <?php if ( !get_theme_mod( 'avant-slider-remove-pagination', customizer_library_get_default( 'avant-slider-remove-pagination' ) ) ) : ?>
                <div class="home-slider-pager"></div>
            <?php endif; ?>
            
        </div>
            
    <?php endif; ?>
    
<?php endif; ?>