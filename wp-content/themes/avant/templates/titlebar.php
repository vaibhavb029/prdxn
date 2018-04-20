<?php if ( !is_front_page() ) : ?>
    <?php if ( !get_theme_mod( 'avant-page-remove-titlebar' ) ) : ?>
    
        <header class="entry-header">
            
            <?php if ( is_home() ) :
                $blog_page_id = get_option( 'page_for_posts' );  ?>
                
                <?php echo '<h2>' . esc_html( get_page( $blog_page_id )->post_title ) . '</h2>'; ?>
            
            <?php elseif ( is_archive() ) : ?>
                
                <?php
                the_archive_title( '<h2>', '</h2>' );
                the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
            
            <?php elseif ( is_search() ) : ?>
                
                <h2><?php printf( esc_html__( 'Search Results for: %s', 'avant' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
            
            <?php elseif ( is_singular() ) : ?>
                
                <?php echo '<h2>' . get_the_title( get_the_ID() ) . '</h2>'; ?>
                
            <?php elseif ( avant_is_woocommerce_activated() ) : ?>
                
                <?php if ( is_shop() ) :
                    $shop_id = get_option( 'woocommerce_shop_page_id' ); ?>
                    
                    <?php echo '<h2>' . esc_html( get_page( $shop_id )->post_title ) . '</h2>'; ?>
                <?php endif; ?>
            
            <?php else : ?>
                
                <h2><?php the_title(); ?></h2>
                
            <?php endif; ?>
            
            <?php if ( ! is_front_page() ) : ?>
        
    	        <?php if ( function_exists( 'bcn_display' ) ) : ?>
    		        <div class="breadcrumbs">
    		            <?php bcn_display(); ?>
    		        </div>
    	        <?php endif; ?>
    	        
    	    <?php endif; ?>
            
        </header><!-- .entry-header -->
    
    <?php endif; ?>
<?php endif; ?>