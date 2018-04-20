<?php
/**
 * The template for displaying search results pages.
 *
 * @package Avant
 */
get_header(); ?>

	<section id="primary" class="content-area <?php echo ( get_theme_mod( 'avant-blog-break-blocks' ) ) ? sanitize_html_class( 'blog-break-blocks' ) : ''; ?> <?php echo ( get_theme_mod( 'avant-blog-blocks-remove-border' ) ) ? sanitize_html_class( 'blog-blocks-no-border' ) : ''; ?>">
		<main id="main" class="site-main" role="main">

			<?php if ( have_posts() ) : ?>

				<?php get_template_part( '/templates/titlebar' ); ?>
				
				<?php echo ( get_theme_mod( 'avant-blog-layout' ) == 'blog-blocks-layout' ) ? '<div class="blog-blocks-wrap blog-blocks-wrap-remove blog-style-postblock blog-columns-three">' : ''; ?>
					<?php echo ( get_theme_mod( 'avant-blog-layout' ) == 'blog-blocks-layout' ) ? '<div class="blog-blocks-wrap-inner">' : ''; ?>
					
						<?php /* Start the Loop */ ?>
						<?php while ( have_posts() ) : the_post(); ?>
							
							<?php
							/**
							 * Run the loop for the search to output the results.
							 * If you want to overload this in a child theme then include a file
							 * called content-search.php and that will be used instead.
							 */
							get_template_part( 'templates/contents/content', 'search' );
							?>

						<?php endwhile; ?>
						
					<?php echo ( get_theme_mod( 'avant-blog-layout' ) == 'blog-blocks-layout' ) ? '<div class="clearboth"></div></div>' : ''; ?>
				<?php echo ( get_theme_mod( 'avant-blog-layout' ) == 'blog-blocks-layout' ) ? '</div>' : ''; ?>

			<?php else : ?>

				<?php get_template_part( 'templates/contents/content', 'none' ); ?>

			<?php endif; ?>
			
			<?php
			if ( function_exists( 'wp_paginate' ) ):
			    wp_paginate();  
			else :
				the_posts_navigation();
			endif; ?>

		</main><!-- #main -->
	</section><!-- #primary -->

	<?php get_sidebar(); ?>
    
    <div class="clearboth"></div>
<?php get_footer(); ?>