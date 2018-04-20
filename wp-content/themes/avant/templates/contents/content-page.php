<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Avant
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
	<?php if ( !is_front_page() && get_theme_mod( 'avant-page-fimage-layout' ) == 'avant-page-fimage-layout-standard' ) : ?>
		
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="entry-content-img">
				<?php the_post_thumbnail( 'full' ); ?>
			</div>
		<?php endif; ?>
		
	<?php endif; ?>
	
	<div class="entry-content">
		
		<?php the_content(); ?>
		
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'avant' ),
				'after'  => '</div>',
			) );
		?>
		
	</div><!-- .entry-content -->

</article><!-- #post-## -->
