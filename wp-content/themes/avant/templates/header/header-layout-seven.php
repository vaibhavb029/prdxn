<?php
/**
 * @package Avant
 */
global $woocommerce; ?>

<?php if ( !get_theme_mod( 'avant-header-remove-topbar', customizer_library_get_default( 'avant-header-remove-topbar' ) ) ) : ?>
	<div class="site-top-bar site-header-layout-seven <?php echo ( get_theme_mod( 'avant-header-topbar-switch' ) ) ? sanitize_html_class( 'site-top-bar-switch' ) : ''; ?>">
		
		<div class="site-container">
			
			<div class="site-top-bar-left">
			
				<?php if ( !get_theme_mod( 'avant-header-remove-no', customizer_library_get_default( 'avant-header-remove-no' ) ) ) : ?>
					<span class="site-topbar-no"><?php echo ( get_theme_mod( 'avant-website-head-no-icon' ) ) ? '<i class="fa ' . sanitize_html_class( get_theme_mod( 'avant-website-head-no-icon' ) ) . '"></i>' : '<i class="fa fa-phone"></i>'; ?> <?php echo wp_kses_post( get_theme_mod( 'avant-website-head-no', __( 'Call Us: +2782 444 YEAH', 'avant' ) ) ) ?></span>
				<?php endif; ?>
				
				<?php if ( !get_theme_mod( 'avant-header-remove-add', customizer_library_get_default( 'avant-header-remove-add' ) ) ) : ?>
	            	<span class="site-topbar-ad"><?php echo ( get_theme_mod( 'avant-website-site-add-icon' ) ) ? '<i class="fa ' . sanitize_html_class( get_theme_mod( 'avant-website-site-add-icon' ) ) . '"></i>' : '<i class="fa fa-map-marker"></i>'; ?> <?php echo wp_kses_post( get_theme_mod( 'avant-website-site-add', 'Cape Town, South Africa' ) ) ?></span>
				<?php endif; ?>
				
			</div>
			
			<div class="site-top-bar-right">
				
				<?php if ( !get_theme_mod( 'avant-header-search', customizer_library_get_default( 'avant-header-search' ) ) ) : ?>
					<div class="menu-search">
				    	<i class="fa fa-search search-btn"></i>
				    </div>
				<?php endif; ?>
				
				<?php if ( !get_theme_mod( 'avant-header-remove-social', customizer_library_get_default( 'avant-header-remove-social' ) ) ) : ?>
					<?php get_template_part( '/templates/social-links' ); ?>
				<?php endif; ?>
				
				<?php wp_nav_menu( array( 'theme_location' => 'top-bar-menu', 'container_class' => 'avant-header-nav', 'fallback_cb' => false ) ); ?>
				
			</div>
			<div class="clearboth"></div>
			
			<?php if ( !get_theme_mod( 'avant-header-search', customizer_library_get_default( 'avant-header-search' ) ) ) : ?>
			    <div class="search-block">
			        <?php get_search_form(); ?>
			    </div>
			<?php endif; ?>
			
		</div>
		
	</div>
<?php endif; ?>

<?php if ( is_front_page() ) : ?>
	
	<?php if ( get_theme_mod( 'avant-slider-type' ) == 'avant-no-slider' ) : ?>
		<header id="masthead" class="site-header site-header-layout-seven site-header-nobanner <?php echo ( get_theme_mod( 'avant-header-switch' ) ) ? sanitize_html_class( 'site-header-switch' ) : ''; ?>">
	<?php elseif ( get_theme_mod( 'avant-slider-type' ) == 'avant-shortcode-slider' ) : ?>
		<header id="masthead" class="site-header site-header-layout-seven <?php echo ( get_theme_mod( 'avant-header-switch' ) ) ? sanitize_html_class( 'site-header-switch' ) : ''; ?> <?php echo ( get_theme_mod( 'avant-slider-shortcode' ) ) ? '' : sanitize_html_class( 'site-header-nobanner' ); ?>">
	<?php elseif ( get_theme_mod( 'avant-slider-type' ) == 'avant-home-featured-image' ) : ?>
		<header id="masthead" class="site-header site-header-layout-seven <?php echo ( get_theme_mod( 'avant-header-switch' ) ) ? sanitize_html_class( 'site-header-switch' ) : ''; ?> <?php echo ( has_post_thumbnail() ) ? '' : sanitize_html_class( 'site-header-nobanner' ); ?>">
	<?php else : ?>
		<header id="masthead" class="site-header site-header-layout-seven <?php echo ( get_theme_mod( 'avant-header-switch' ) ) ? sanitize_html_class( 'site-header-switch' ) : ''; ?>">
	<?php endif; ?>
	
<?php elseif ( is_home() || is_archive() || is_search() ) : ?>
	
	<?php
	$this_page_id = get_option( 'page_for_posts' );
	if ( avant_is_woocommerce_activated() ) :
        if ( is_woocommerce() ) :
            $this_page_id = get_option( 'woocommerce_shop_page_id' );
        else :
            $this_page_id = get_option( 'page_for_posts' );
        endif;
    else :
        $this_page_id = get_option( 'page_for_posts' );
    endif; ?>
	
	<header id="masthead" class="site-header site-header-layout-seven <?php echo ( get_theme_mod( 'avant-header-switch' ) ) ? sanitize_html_class( 'site-header-switch' ) : ''; ?> <?php echo ( has_post_thumbnail( $this_page_id ) && get_theme_mod( 'avant-page-fimage-layout' ) == 'avant-page-fimage-layout-banner' ) ? '' : sanitize_html_class( 'site-header-nobanner' ); ?>">
	
<?php elseif ( is_page() ) : ?>
	
	<?php $the_page_id = get_the_ID(); ?>
	
	<header id="masthead" class="site-header site-header-layout-seven <?php echo ( get_theme_mod( 'avant-header-switch' ) ) ? sanitize_html_class( 'site-header-switch' ) : ''; ?> <?php echo ( has_post_thumbnail( $the_page_id ) && get_theme_mod( 'avant-page-fimage-layout' ) == 'avant-page-fimage-layout-banner' ) ? '' : sanitize_html_class( 'site-header-nobanner' ); ?>">
	
<?php else : ?>
	
	<?php $single_page_id = get_the_ID(); ?>
	
	<header id="masthead" class="site-header site-header-layout-seven <?php echo ( get_theme_mod( 'avant-header-switch' ) ) ? sanitize_html_class( 'site-header-switch' ) : ''; ?> <?php echo ( has_post_thumbnail( $single_page_id ) && get_theme_mod( 'avant-single-page-fimage-layout' ) == 'avant-single-page-fimage-layout-banner' ) ? '' : sanitize_html_class( 'site-header-nobanner' ); ?>">
	
<?php endif; ?>

	<div class="site-container">
		
		<div class="site-branding">
			
			<?php if ( has_custom_logo() ) : ?>
	            <?php the_custom_logo(); ?>
	        <?php else : ?>
	            <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
	            <h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
	        <?php endif; ?>
			
		</div><!-- .site-branding -->
		
		<div class="site-header-top">
			
			<nav id="site-navigation" class="main-navigation avant-nav-style-plain" role="navigation">
				<span class="header-menu-button"><i class="fa fa-bars"></i><span><?php echo esc_attr( get_theme_mod( 'avant-header-menu-text', __( 'menu', 'avant' ) ) ); ?></span></span>
				<div id="main-menu" class="main-menu-container">
					<span class="main-menu-close"><i class="fa fa-angle-right"></i><i class="fa fa-angle-left"></i></span>
					<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
				</div>
			</nav><!-- #site-navigation -->
			
			<?php if ( avant_is_woocommerce_activated() ) : ?>
				<?php if ( !get_theme_mod( 'avant-header-remove-cart', customizer_library_get_default( 'avant-header-remove-cart' ) ) ) : ?>
					<div class="header-cart">
						
			            <a class="header-cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'avant' ); ?>">
				            <span class="header-cart-amount">
				                <?php echo sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'avant' ), WC()->cart->get_cart_contents_count() ); ?><span> - <?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span>
				            </span>
				            <span class="header-cart-checkout <?php echo ( WC()->cart->get_cart_contents_count() > 0 ) ? sanitize_html_class( 'cart-has-items' ) : ''; ?>">
				                <i class="fa <?php echo ( get_theme_mod( 'avant-cart-icon' ) ) ? sanitize_html_class( get_theme_mod( 'avant-cart-icon' ) ) : sanitize_html_class( 'fa-shopping-cart' ); ?>"></i>
				            </span>
				        </a>
						
					</div>
				<?php endif; ?>
			<?php endif; ?>
			
		</div>
		<div class="clearboth"></div>
		
	</div>
	
</header><!-- #masthead -->