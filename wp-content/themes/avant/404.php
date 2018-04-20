<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Avant
 */
get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<div>
					<i class="fa fa-ban"></i>
				</div>
				<header class="page-header">
					<h1 class="page-title"><?php echo wp_kses_post( get_theme_mod( 'avant-website-error-head', __( 'Oops! <span>404</span>', 'avant' ) ) ); ?></h1>
				</header><!-- .page-header -->
				<div class="page-content">
					<p><?php echo wp_kses_post( get_theme_mod( 'avant-website-error-msg', __( 'It looks like that page does not exist. <br />Return home or try a search', 'avant' ) ) ); ?></p>
				</div><!-- .page-content -->
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>