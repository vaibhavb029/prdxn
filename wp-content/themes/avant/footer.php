<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Avant
 */
?>
		<div class="clearboth"></div>
	</div><!-- #content -->
	
	<?php
	if ( get_theme_mod( 'avant-footer-side-fullwidth' ) ) :
		echo ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-six' ) ? '</div><div class="clearboth"></div>' : ''; // Site Side Layout
	endif; ?>
	
	<?php if ( get_theme_mod( 'avant-footer-layout' ) == 'avant-footer-layout-social' ) : ?>

	    <?php get_template_part( '/templates/footer/footer-social' ); ?>

	<?php elseif ( get_theme_mod( 'avant-footer-layout' ) == 'avant-footer-layout-none' ) : ?>

	    <?php get_template_part( '/templates/footer/footer-none' ); ?>

	<?php else : ?>

		<?php get_template_part( '/templates/footer/footer-standard' ); ?>

	<?php endif; ?>
	
	<?php
	if ( !get_theme_mod( 'avant-footer-side-fullwidth' ) ) :
		echo ( get_theme_mod( 'avant-header-layout' ) == 'avant-header-layout-six' ) ? '</div><div class="clearboth"></div>' : ''; // Site Side Layout
	endif; ?>

<?php echo ( get_theme_mod( 'avant-header-layout' ) != 'avant-header-layout-six' && get_theme_mod( 'avant-site-layout' ) == 'avant-site-boxed' ) ? '</div>' : ''; ?>

<?php echo ( get_theme_mod( 'avant-header-layout' ) != 'avant-header-layout-six' && get_theme_mod( 'avant-site-layout' ) == 'avant-site-boxed' ) ? '</div>' : ''; ?>

</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>