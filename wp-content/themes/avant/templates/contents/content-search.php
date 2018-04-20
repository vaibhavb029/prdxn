<?php
/**
 * @package Avant
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php if ( get_theme_mod( 'avant-blog-layout' ) == 'blog-blocks-layout' ) : // Blocks Layout ?>
			
		<div class="blog-post-blocks-inner <?php echo ( get_theme_mod( 'avant-blog-post-shape' ) ) ? sanitize_html_class( get_theme_mod( 'avant-blog-post-shape' ) ) : sanitize_html_class( 'blog-post-shape-square' ); ?>">
		    
		    <?php if ( has_post_thumbnail() ) :
		    	$avant_image_cut = customizer_library_get_default( 'avant-blog-list-img-cut' );
				if ( get_theme_mod( 'avant-blog-list-img-cut' ) ) {
					$avant_image_cut = get_theme_mod( 'avant-blog-list-img-cut' );
				} ?>

			    <div class="blog-post-blocks-inner-img" <?php echo ( has_post_thumbnail() ) ? 'style="background-image: url(' . esc_url( get_the_post_thumbnail_url( $post->ID, $avant_image_cut ) ) . ');"' : ''; ?>>
			    	<a href="<?php echo esc_url( get_permalink() ); ?>">
					    
					    <?php if ( get_theme_mod( 'avant-blog-post-shape' ) == 'blog-post-shape-img' ) : ?>
					    
						    <?php if ( has_post_thumbnail() ) : ?>
						    	<img src="<?php echo esc_url( get_the_post_thumbnail_url( $post->ID, $avant_image_cut ) ); ?>" alt="<?php the_title(); ?>" />
						    <?php else : ?>
					    		<img src="<?php echo get_template_directory_uri(); ?>/images/blank_blocks_img.png" alt="<?php the_title(); ?>" />
					    	<?php endif; ?>
					    	
					    <?php else : ?>
					    
							<img src="<?php echo get_template_directory_uri(); ?>/images/blank_blocks_img.png" alt="<?php the_title(); ?>" />
							
						<?php endif; ?>
					
					</a>
				</div>

			<?php endif; ?>
			
			<div class="blog-blocks-content">
				<header class="entry-header">
					<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
					
					<?php if ( !get_theme_mod( 'avant-blog-blocks-remove-meta' ) ) : ?>
						<?php if ( 'post' == get_post_type() ) : ?>
						<div class="entry-meta">
							<?php avant_posted_on(); ?>
						</div><!-- .entry-meta -->
						<?php endif; ?>
					<?php endif; ?>
					
				</header><!-- .entry-header -->
				
				<?php if ( !get_theme_mod( 'avant-blog-blocks-remove-content' ) ) : ?>
					<div class="blog-blocks-content-inner">
						
						<?php
						if ( has_excerpt() ) :
							the_excerpt();
						else :
							the_content( sprintf(
								wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'avant' ), array( 'span' => array( 'class' => array() ) ) ),
								the_title( '<span class="screen-reader-text">"', '"</span>', false )
							) );
						endif; ?>
							
				    </div>
			    <?php endif; ?>
			    
			    <?php if ( !get_theme_mod( 'avant-blog-blocks-remove-tagcats' ) ) : ?>
				    <footer class="entry-footer">
						<?php avant_entry_footer(); ?>
					</footer><!-- .entry-footer -->
				<?php endif; ?>
			    
			</div>
			
		</div>
		
	<?php else : ?>

		<div class="blog-content-inner <?php echo ( get_theme_mod( 'avant-blog-post-shape' ) ) ? sanitize_html_class( get_theme_mod( 'avant-blog-post-shape' ) ) : sanitize_html_class( 'blog-post-shape-square' ); ?>">
		
			<?php if ( has_post_thumbnail() ) :
				$avant_image_cut = customizer_library_get_default( 'avant-blog-list-img-cut' );
				if ( get_theme_mod( 'avant-blog-list-img-cut' ) ) {
					$avant_image_cut = get_theme_mod( 'avant-blog-list-img-cut' );
				} ?>

				<a href="<?php the_permalink() ?>" class="post-loop-thumbnail" <?php echo ( has_post_thumbnail() ) ? 'style="background-image: url(' . esc_url( get_the_post_thumbnail_url( $post->ID, $avant_image_cut ) ) . ');"' : ''; ?>>
					
					<?php if ( get_theme_mod( 'avant-blog-post-shape' ) == 'blog-post-shape-img' ) : ?>
							    
					    <?php if ( has_post_thumbnail() ) : ?>
					    	<img src="<?php echo esc_url( get_the_post_thumbnail_url( $post->ID, $avant_image_cut ) ); ?>" alt="<?php the_title(); ?>" />
					    <?php else : ?>
				    		<img src="<?php echo get_template_directory_uri(); ?>/images/blank_blocks_img.png" alt="<?php the_title(); ?>" />
				    	<?php endif; ?>
				    	
				    <?php else : ?>
				    
						<img src="<?php echo get_template_directory_uri(); ?>/images/blank_blocks_img.png" alt="<?php the_title(); ?>" />
						
					<?php endif; ?>
					
				</a>

			<?php endif; ?>
			
			<div class="post-loop-content">
				
				<header class="entry-header">
					<?php the_title( sprintf( '<h3 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' ); ?>
					
					<?php if ( !get_theme_mod( 'avant-blog-blocks-remove-meta' ) ) : ?>
						<?php if ( 'post' == get_post_type() ) : ?>
						<div class="entry-meta">
							<?php avant_posted_on(); ?>
						</div><!-- .entry-meta -->
						<?php endif; ?>
					<?php endif; ?>
					
				</header><!-- .entry-header -->

				<div class="entry-content">
					
					<?php
					if ( has_excerpt() ) :
						the_excerpt();
					else :
						/* translators: %s: Name of current post */
						the_content( sprintf(
							wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'avant' ), array( 'span' => array( 'class' => array() ) ) ),
							the_title( '<span class="screen-reader-text">"', '"</span>', false )
						) );
					endif; ?>
					
					<?php
						wp_link_pages( array(
							'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'avant' ),
							'after'  => '</div>',
						) );
					?>
				</div><!-- .entry-content -->
				
				<?php if ( !get_theme_mod( 'avant-blog-blocks-remove-tagcats' ) ) : ?>
					<footer class="entry-footer">
						<?php avant_entry_footer(); ?>
					</footer><!-- .entry-footer -->
				<?php endif; ?>
				
			</div>
			<div class="clearboth"></div>
		
		</div>

	<?php endif; ?>
	
</article><!-- #post-## -->