<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Avant
 */
get_header(); ?>

	<div id="primary" class="content-area <?php echo ( get_theme_mod( 'avant-blog-break-blocks' ) ) ? sanitize_html_class( 'blog-break-blocks' ) : ''; ?> <?php echo ( get_theme_mod( 'avant-blog-blocks-remove-border' ) ) ? sanitize_html_class( 'blog-blocks-no-border' ) : ''; ?>">
		<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>

				<?php get_template_part( '/templates/titlebar' ); ?>
				
				<?php
				// if archive pages are set to be blocks
				echo ( get_theme_mod( 'avant-blog-layout' ) == 'blog-blocks-layout' ) ? '<div class="blog-blocks-wrap blog-blocks-wrap-remove blog-style-postblock blog-columns-three">' : '';
					echo ( get_theme_mod( 'avant-blog-layout' ) == 'blog-blocks-layout' ) ? '<div class="blog-blocks-wrap-inner">' : ''; ?>
				
					<?php /* Start the Loop */ ?>
					<?php while ( have_posts() ) : the_post(); ?>
					
						<?php
							/* Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'templates/contents/content' );
						?>
						
					<?php endwhile; ?>
					
					<?php
					// Close the divs for the blocks layout
					echo ( get_theme_mod( 'avant-blog-layout' ) == 'blog-blocks-layout' ) ? '<div class="clearboth"></div></div>' : '';
				echo ( get_theme_mod( 'avant-blog-layout' ) == 'blog-blocks-layout' ) ? '</div>' : ''; ?>
				
				<?php
				if ( function_exists( 'wp_paginate' ) ):
				    wp_paginate();  
				else :
					the_posts_navigation();
				endif; ?>

			<?php else : ?>

				<?php get_template_part( 'templates/contents/content', 'none' ); ?>

			<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

	<?php get_sidebar(); ?>
	
	<div class="clearboth"></div>
	
<?php get_footer(); ?>