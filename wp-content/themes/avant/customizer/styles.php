<?php
/**
 * Implements styles set in the theme customizer
 *
 * @package Customizer Library Avant
 */

if ( ! function_exists( 'customizer_library_avant_build_styles' ) && class_exists( 'Customizer_Library_Styles' ) ) :
/**
 * Process user options to generate CSS needed to implement the choices.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function customizer_library_avant_build_styles() {
	
	// Primary Color
	$setting = 'avant-primary-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-top-border,
				#comments .form-submit #submit,
				.search-block .search-submit,
				.side-aligned-social a.social-icon,
				.no-results-btn,
				button,
				input[type="button"],
				input[type="reset"],
				input[type="submit"],
				.widget-title-style-underline-short .widget-area .widget-title:after,
				.woocommerce ul.products li.product a.add_to_cart_button, .woocommerce-page ul.products li.product a.add_to_cart_button,
				.woocommerce ul.products li.product .onsale, .woocommerce-page ul.products li.product .onsale,
				.woocommerce button.button.alt,
				.woocommerce-page button.button.alt,
				.woocommerce input.button.alt:hover,
				.woocommerce-page #content input.button.alt:hover,
				.woocommerce .cart-collaterals .shipping_calculator .button,
				.woocommerce-page .cart-collaterals .shipping_calculator .button,
				.woocommerce a.button,
				.woocommerce-page a.button,
				.woocommerce input.button,
				.woocommerce-page #content input.button,
				.woocommerce-page input.button,
				.woocommerce #review_form #respond .form-submit input,
				.woocommerce-page #review_form #respond .form-submit input,
				.woocommerce-cart .wc-proceed-to-checkout a.checkout-button:hover,
				.single-product span.onsale,
				.main-navigation ul ul a:hover,
				.main-navigation ul ul li.current-menu-item > a,
				.main-navigation ul ul li.current_page_item > a,
				.main-navigation ul ul li.current-menu-parent > a,
				.main-navigation ul ul li.current_page_parent > a,
				.main-navigation ul ul li.current-menu-ancestor > a,
				.main-navigation ul ul li.current_page_ancestor > a,
				.main-navigation.avant-nav-style-solid .current_page_item > a,
				.woocommerce .widget_price_filter .ui-slider .ui-slider-range,
				.woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
				.wpcf7-submit,
				.wp-paginate li a:hover,
				.wp-paginate li a:active,
				.wp-paginate li .current,
				.wp-paginate.wpp-modern-grey li a:hover,
				.wp-paginate.wpp-modern-grey li .current'
			),
			'declarations' => array(
				'background' => 'inherit',
                'background-color' => $color
			)
		) );
	}
	
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'a,
				.content-area .entry-content a,
				#comments a,
				.post-edit-link,
				.site-title a,
				.error-404.not-found .page-header .page-title span,
				.search-button .fa-search,
				.header-cart-checkout.cart-has-items .fa-shopping-cart,
				.site-header-top-right .social-icon:hover,
				.site-footer-bottom-bar .social-icon:hover,
				.main-navigation.avant-nav-style-plain ul > li > a:hover,
				.main-navigation.avant-nav-style-plain ul > li.current-menu-item > a,
				.main-navigation.avant-nav-style-plain ul > li.current-menu-ancestor > a,
				.main-navigation.avant-nav-style-plain ul > li.current-menu-parent > a,
				.main-navigation.avant-nav-style-plain ul > li.current_page_parent > a,
				.main-navigation.avant-nav-style-plain ul > li.current_page_ancestor > a,
				.main-navigation.avant-nav-style-plain .current_page_item > a'
			),
			'declarations' => array(
                'color' => $color
			)
		) );
	}
	
	

	// Secondary Color
	$setting = 'avant-secondary-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.main-navigation button:hover,
				#comments .form-submit #submit:hover,
				.search-block .search-submit:hover,
				.no-results-btn:hover,
				button,
				input[type="button"],
				input[type="reset"],
				input[type="submit"],
				.woocommerce input.button.alt,
				.woocommerce-page #content input.button.alt,
				.woocommerce .cart-collaterals .shipping_calculator .button,
				.woocommerce-page .cart-collaterals .shipping_calculator .button,
				.woocommerce a.button:hover,
				.woocommerce-page a.button:hover,
				.woocommerce input.button:hover,
				.woocommerce-page #content input.button:hover,
				.woocommerce-page input.button:hover,
				.woocommerce ul.products li.product a.add_to_cart_button:hover, .woocommerce-page ul.products li.product a.add_to_cart_button:hover,
				.woocommerce button.button.alt:hover,
				.woocommerce-page button.button.alt:hover,
				.woocommerce #review_form #respond .form-submit input:hover,
				.woocommerce-page #review_form #respond .form-submit input:hover,
				.woocommerce-cart .wc-proceed-to-checkout a.checkout-button,
				.woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content,
				.wpcf7-submit:hover'
			),
			'declarations' => array(
				'background' => 'inherit',
                'background-color' => $color
			)
		) );
	}
	
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'a:hover,
				.avant-header-nav ul li a:hover,
				.content-area .entry-content a:hover,
				.header-social .social-icon:hover,
				.widget-area .widget a:hover,
				.site-footer-widgets .widget a:hover,
				.site-footer .widget a:hover,
				.search-btn:hover,
				.search-button .fa-search:hover,
				.woocommerce #content div.product p.price,
				.woocommerce-page #content div.product p.price,
				.woocommerce-page div.product p.price,
				.woocommerce #content div.product span.price,
				.woocommerce div.product span.price,
				.woocommerce-page #content div.product span.price,
				.woocommerce-page div.product span.price,
				.woocommerce #content div.product .woocommerce-tabs ul.tabs li.active,
				.woocommerce div.product .woocommerce-tabs ul.tabs li.active,
				.woocommerce-page #content div.product .woocommerce-tabs ul.tabs li.active,
				.woocommerce-page div.product .woocommerce-tabs ul.tabs li.active'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
	}

	// Site Boxed Background Color
	$setting = 'avant-boxed-bg-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.content-boxed'
			),
			'declarations' => array(
				'background-color' => $color
			)
		) );
	}
	
	// Body Font
	$setting = 'avant-body-font';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	$stack = customizer_library_get_font_stack( $mod );

	if ( $mod != customizer_library_get_default( $setting ) ) {

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'body,
				.widget-area .widget a'
			),
			'declarations' => array(
				'font-family' => $stack
			)
		) );

	}
	
	// Body Font Color
	$setting = 'avant-body-font-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'body,
                .widget-area .widget a,
                .woocommerce .woocommerce-breadcrumb a,
                .woocommerce .woocommerce-breadcrumb,
                .woocommerce-page .woocommerce-breadcrumb,
                .woocommerce #content ul.products li.product span.price,
                .woocommerce-page #content ul.products li.product span.price,
                .woocommerce div.product .woocommerce-tabs ul.tabs li a'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
	}

	// Heading Font
	$setting = 'avant-heading-font';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	$stack = customizer_library_get_font_stack( $mod );

	if ( $mod != customizer_library_get_default( $setting ) ) {

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'h1, h2, h3, h4, h5, h6,
                h1 a, h2 a, h3 a, h4 a, h5 a, h6 a,
                .widget-area .widget-title,
                .main-navigation ul li a,
                .woocommerce table.cart th,
                .woocommerce-page #content table.cart th,
                .woocommerce-page table.cart th,
                .woocommerce input.button.alt,
                .woocommerce-page #content input.button.alt,
                .woocommerce table.cart input,
                .woocommerce-page #content table.cart input,
                .woocommerce-page table.cart input,
                button, input[type="button"],
                input[type="reset"],
                input[type="submit"]',
			),
			'declarations' => array(
				'font-family' => $stack
			)
		) );

	}
	
	// Heading Font Color
	$setting = 'avant-heading-font-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'h1, h2, h3, h4, h5, h6,
                h1 a, h2 a, h3 a, h4 a, h5 a, h6 a,
                .widget-area .widget-title'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
	}
	
	// Site Title Font
	$setting = 'avant-title-font';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	$stack = customizer_library_get_font_stack( $mod );

	if ( $mod != customizer_library_get_default( $setting ) ) {

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-title a'
			),
			'declarations' => array(
				'font-family' => $stack
			)
		) );

	}
	// Site Title Font Size
	$setting = 'avant-title-font-size';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$title_font_size = esc_attr( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-title'
			),
			'declarations' => array(
				'font-size' => $title_font_size . 'px'
			)
		) );
	}
	$setting = 'avant-site-tagline-case-normal';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	$stack = customizer_library_get_font_stack( $mod );

	if ( $mod != customizer_library_get_default( $setting ) ) {

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-description'
			),
			'declarations' => array(
				'text-transform' => 'none'
			)
		) );

	}
	// Site Tagline Font
	$setting = 'avant-tagline-font';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	$stack = customizer_library_get_font_stack( $mod );

	if ( $mod != customizer_library_get_default( $setting ) ) {

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-description'
			),
			'declarations' => array(
				'font-family' => $stack
			)
		) );

	}
	// Site Title Font Size
	$setting = 'avant-tagline-font-size';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$title_font_size = esc_attr( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-description'
			),
			'declarations' => array(
				'font-size' => $title_font_size . 'px'
			)
		) );
	}
	// Site Title Bottom Margin
	$setting = 'avant-title-bottom-margin';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$title_bottom_margin = esc_attr( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-title'
			),
			'declarations' => array(
				'margin-bottom' => $title_bottom_margin . 'px'
			)
		) );
	}
	
	// Site Logo Max Width
	$setting = 'avant-logo-max-width';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$logo_max_width = esc_attr( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-branding a.custom-logo-link'
			),
			'declarations' => array(
				'max-width' => $logo_max_width . 'px'
			)
		) );
	}
	
	// Site Logo Top Padding
	$setting = 'avant-branding-top-pad';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$logo_top_pad = esc_attr( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-branding'
			),
			'declarations' => array(
				'padding-top' => $logo_top_pad . 'px'
			)
		) );
	}
	// Site Logo Bottom Padding
	$setting = 'avant-branding-bottom-pad';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$logo_bottom_pad = esc_attr( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-branding'
			),
			'declarations' => array(
				'padding-bottom' => $logo_bottom_pad . 'px'
			)
		) );
	}
	$setting = 'avant-header-nav-case-normal';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	$stack = customizer_library_get_font_stack( $mod );

	if ( $mod != customizer_library_get_default( $setting ) ) {

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.main-navigation li'
			),
			'declarations' => array(
				'text-transform' => 'none'
			)
		) );

	}
	// Sidebar Widegt Title Size
	$setting = 'avant-blog-widget-title-size';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$widget_title_size = esc_attr( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.widget-area .widget-title'
			),
			'declarations' => array(
				'font-size' => $widget_title_size . 'px'
			)
		) );
	}
	
	// Header Background Color
	$setting = 'avant-header-bg-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-top-bar.site-header-layout-one .search-block,
				.site-header.site-header-layout-one .site-header-top,
				.site-header.site-header-layout-one .search-block,
				.site-header.site-header-layout-one .main-navigation ul ul,
				.site-header.site-header-layout-two,
				.site-header.site-header-layout-two .site-header-top,
				.site-header.site-header-layout-two .main-navigation ul ul,
				.site-header.site-header-layout-four,
				.site-header.site-header-layout-four .main-navigation ul ul,
				.site-header.site-header-layout-five,
				.site-header.site-header-layout-five .main-navigation ul ul,
				.site-header.site-header-layout-three,
				.site-header.site-header-layout-three .site-header-top,
				.site-header.site-header-layout-three .main-navigation ul ul,
				.site-header-side-container-inner,
				.site-top-bar.site-header-layout-six,
				.site-header.site-header-layout-six,
				.site-header.site-header-layout-six .main-navigation ul ul,
				.site-header-side-container .search-block'
			),
			'declarations' => array(
				'background-color' => $color
			)
		) );
	}
	// Transparent Header Background Color
	$setting = 'avant-header-bg-color';
	$setting_opacity = 'avant-header-bg-opacity';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	$mod_opacity = get_theme_mod( $setting_opacity, customizer_library_get_default( $setting_opacity ) );

	if ( $mod !== customizer_library_get_default( $setting ) || $mod_opacity !== customizer_library_get_default( $setting_opacity ) ) {

		$color = sanitize_hex_color( $mod );
		$rgba_color = customizer_library_hex_to_rgb( $color );
		$opacity = esc_attr( $mod_opacity );
		
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-header.site-header-layout-seven,
				.site-header.site-header-layout-seven .main-navigation ul ul'
			),
			'declarations' => array(
				'background-color' => 'rgba(' . $rgba_color['r'] . ', ' . $rgba_color['g'] . ', ' . $rgba_color['b'] . ', 0.' . $opacity . ');'
			)
		) );
	}
	// Header Font Color
	$setting = 'avant-header-font-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-header-top,
				.site-header-social,
				.site-header-search,
				.site-header-layout-one .header-cart,
				.site-header-layout-six .header-cart,
				.main-navigation ul li a,
				.site-header-top .social-icon,
				.site-header.site-header-layout-six .site-top-bar-right-extra-txt'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
	}
	// Top Bar Background Color
	$setting = 'avant-topbar-bg-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-top-bar.site-header-layout-one,
				.site-top-bar.site-header-layout-one .site-top-bar-left,
				.site-top-bar.site-header-layout-one .site-top-bar-right,
				.site-top-bar.site-header-layout-one .avant-header-nav ul ul,
				.site-top-bar.site-header-layout-two,
				.site-top-bar.site-header-layout-two .site-top-bar-left,
				.site-top-bar.site-header-layout-two .site-top-bar-right,
				.site-top-bar.site-header-layout-two .avant-header-nav ul ul,
				.site-top-bar.site-header-layout-two .search-block,
				.site-top-bar.site-header-layout-three,
				.site-top-bar.site-header-layout-three .site-top-bar-left,
				.site-top-bar.site-header-layout-three .site-top-bar-right,
				.site-top-bar.site-header-layout-three .avant-header-nav ul ul,
				.site-top-bar.site-header-layout-three .search-block,
				.site-top-bar.site-header-layout-four,
				.site-top-bar.site-header-layout-four .site-top-bar-left,
				.site-top-bar.site-header-layout-four .site-top-bar-right,
				.site-top-bar.site-header-layout-four .avant-header-nav ul ul,
				.site-top-bar.site-header-layout-four .search-block,
				.site-top-bar.site-header-layout-five,
				.site-top-bar.site-header-layout-five .site-top-bar-left,
				.site-top-bar.site-header-layout-five .site-top-bar-right,
				.site-top-bar.site-header-layout-five .avant-header-nav ul ul,
				.site-top-bar.site-header-layout-five .search-block,
				.site-top-bar.site-header-layout-six,
				.site-top-bar.site-header-layout-six .avant-header-nav ul ul,
				.site-top-bar.site-header-layout-seven,
				.site-top-bar.site-header-layout-seven .site-top-bar-left,
				.site-top-bar.site-header-layout-seven .site-top-bar-right,
				.site-top-bar.site-header-layout-seven .search-block
				'
			),
			'declarations' => array(
				'background-color' => $color
			)
		) );
	}
	// Top Bar Font Color
	$setting = 'avant-topbar-font-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-top-bar'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
	}
	
	// Header 2 & 4 Nav Colors
	$setting = 'avant-navi-bg-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-header.site-header-layout-two .site-header-top,
				.site-header.site-header-layout-two .main-navigation ul ul,
				.site-header.site-header-layout-three .site-header-top,
				.site-header.site-header-layout-three .main-navigation ul ul,
				.site-header.site-header-layout-six .site-header-top,
				.site-header.site-header-layout-six .main-navigation ul ul'
			),
			'declarations' => array(
				'background-color' => $color
			)
		) );
	}
	$setting = 'avant-navi-font-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-header.site-header-layout-two .site-header-top,
				.site-header.site-header-layout-two .main-navigation ul li a,
				.site-header.site-header-layout-three .site-header-top,
				.site-header.site-header-layout-three .main-navigation ul li a,
				.site-header.site-header-layout-six .site-header-top,
				.site-header.site-header-layout-six .main-navigation ul li a,
				.site-header-layout-six .header-cart'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
	}
	// Navigation Drop Down Background Color
	$setting = 'avant-nav-drop-bg-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-header.site-header-layout-one .main-navigation ul ul,
				.site-header.site-header-layout-two .main-navigation ul ul,
				.site-header.site-header-layout-three .main-navigation ul ul,
				.site-header.site-header-layout-four .main-navigation ul ul,
				.site-header.site-header-layout-five .main-navigation ul ul,
				.site-header.site-header-layout-six .main-navigation ul ul'
			),
			'declarations' => array(
				'background-color' => $color
			)
		) );
	}
	// Transparent Header Background Color
	$setting = 'avant-nav-drop-bg-color';
	$setting_opacity = 'avant-nav-drop-opacity';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
	$mod_opacity = get_theme_mod( $setting_opacity, customizer_library_get_default( $setting_opacity ) );

	if ( $mod !== customizer_library_get_default( $setting ) || $mod_opacity !== customizer_library_get_default( $setting_opacity ) ) {

		$color = sanitize_hex_color( $mod );
		$rgba_color = customizer_library_hex_to_rgb( $color );
		$opacity = esc_attr( $mod_opacity );
		
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-header.site-header-layout-seven .main-navigation ul ul'
			),
			'declarations' => array(
				'background-color' => 'rgba(' . $rgba_color['r'] . ', ' . $rgba_color['g'] . ', ' . $rgba_color['b'] . ', 0.' . $opacity . ');'
			)
		) );
	}
	// Navigation Drop Down Font Color
	$setting = 'avant-nav-drop-font-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-header.site-header-layout-one .main-navigation ul ul li a,
				.site-header.site-header-layout-two .main-navigation ul ul li a,
				.site-header.site-header-layout-three .main-navigation ul ul li a,
				.site-header.site-header-layout-four .main-navigation ul ul li a,
				.site-header.site-header-layout-five .main-navigation ul ul li a,
				.site-header.site-header-layout-six .main-navigation ul ul li a,
				.site-header.site-header-layout-seven .main-navigation ul ul li a'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
	}
	// Navigation Active Color
	$setting = 'avant-navi-selected-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.main-navigation ul ul a:hover,
				.main-navigation ul ul li.current-menu-item > a,
				.main-navigation ul ul li.current_page_item > a,
				.main-navigation ul ul li.current-menu-parent > a,
				.main-navigation ul ul li.current_page_parent > a,
				.main-navigation ul ul li.current-menu-ancestor > a,
				.main-navigation ul ul li.current_page_ancestor > a'
			),
			'declarations' => array(
				'background-color' => $color
			)
		) );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.header-cart-checkout.cart-has-items .fa-shopping-cart,
				.main-navigation.avant-nav-style-plain ul > li > a:hover,
				.main-navigation.avant-nav-style-plain ul > li.current-menu-item > a,
				.main-navigation.avant-nav-style-plain ul > li.current-menu-ancestor > a,
				.main-navigation.avant-nav-style-plain ul > li.current-menu-parent > a,
				.main-navigation.avant-nav-style-plain ul > li.current_page_parent > a,
				.main-navigation.avant-nav-style-plain ul > li.current_page_ancestor > a,
				.main-navigation.avant-nav-style-plain .current_page_item > a'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
	}
	
	// Footer Background Color
	$setting = 'avant-footer-bg-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-footer-standard,
				.site-footer.site-footer-social,
				.site-footer.site-footer-custom'
			),
			'declarations' => array(
				'background-color' => $color
			)
		) );
	}
	// Footer Font Color
	$setting = 'avant-footer-font-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-footer'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
	}
	// Footer Heading Font Color
	$setting = 'avant-footer-heading-font-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-footer .widgettitle,
				.site-footer .widget-title'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-footer .widgettitle,
				.site-footer .widget-title'
			),
			'declarations' => array(
				'border-bottom' => '1px dotted ' . $color
			)
		) );
	}
	// Footer Bottom Bar Background Color
	$setting = 'avant-footer-bottombar-bg-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-footer-bottom-bar'
			),
			'declarations' => array(
				'background-color' => $color
			)
		) );
	}
	// Footer Bottom Bar Font Color
	$setting = 'avant-footer-bottombar-font-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-footer-bottom-bar'
			),
			'declarations' => array(
				'color' => $color
			)
		) );
	}
	
	// Pages Background Color
	$setting = 'avant-content-bg-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$page_bg_color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.woocommerce #container,
				.woocommerce-page #container,
				.content-area,
				.widget-area,
				.blog-break-blocks article.hentry,
				.widget-area.sidebar-break-blocks .widget,
				.blog-break-blocks .blog-blocks-wrap article.blog-blocks-layout .blog-blocks-content,
				.blog-break-blocks .blog-post-blocks-inner.blog-post-shape-round'
			),
			'declarations' => array(
				'background-color' => $page_bg_color
			)
		) );
	}
	
	// Page Title Color
	$setting = 'avant-page-title-font-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$title_color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-main > .entry-header h2,
				.woocommerce-products-header h1,
				.single .entry-title'
			),
			'declarations' => array(
				'color' => $title_color
			)
		) );
	}
	// Blog List Title Color
	$setting = 'avant-bloglist-title-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$title_color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.post-loop-content .entry-title a,
				.blog-style-postblock .blog-post-blocks-inner h3 a,
				.blog-style-imgblock .blog-blocks-content-inner h3,
				.blog-style-imgblock .blog-blocks-content-inner .entry-meta'
			),
			'declarations' => array(
				'color' => $title_color
			)
		) );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.blog-style-imgblock .blog-blocks-content-inner'
			),
			'declarations' => array(
				'border-color' => $title_color
			)
		) );
	}
	// Sidebar Widget Title Color
	$setting = 'avant-sidebar-widget-title-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$title_color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.widget-area .widget-title'
			),
			'declarations' => array(
				'color' => $title_color
			)
		) );
	}
	// WooCommerce Title Size
	$setting = 'avant-wc-product-title-size';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$title_size = esc_attr( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.woocommerce ul.products li.product h3,
				.woocommerce-page ul.products li.product h3,
				.woocommerce ul.products li.product .woocommerce-loop-category__title,
				.woocommerce ul.products li.product .woocommerce-loop-product__title'
			),
			'declarations' => array(
				'font-size' => $title_size . 'px'
			)
		) );
	}
	// WooCommerce Title Color
	$setting = 'avant-wc-product-title-color';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$title_color = sanitize_hex_color( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.woocommerce ul.products li.product h3,
				.woocommerce-page ul.products li.product h3,
				.woocommerce ul.products li.product .woocommerce-loop-category__title,
				.woocommerce ul.products li.product .woocommerce-loop-product__title'
			),
			'declarations' => array(
				'color' => $title_color
			)
		) );
	}

	// Remove WC Categories Count
	$setting = 'avant-remove-cats-count';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$cat_count = esc_attr( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'ul.products mark.count'
			),
			'declarations' => array(
				'display' => 'none'
			)
		) );
	}
	// Widget Spacing
	$setting = 'avant-page-widget-spacing';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$widget_spacing = esc_attr( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.widget-area .widget'
			),
			'declarations' => array(
				'margin' => '0 0 ' . $widget_spacing . 'px'
			)
		) );
	}
	// Content Border Radius
	$setting = 'avant-page-content-spacing';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$content_bradius = esc_attr( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.woocommerce .avant-site-full-width #container,
				.avant-site-full-width .content-area,
				.avant-site-full-width .widget-area,
				.avant-site-full-width .widget-area.sidebar-break-blocks .widget,
				.blog-break-blocks article.hentry,
				.blog-break-blocks .site-main > .entry-header,
				.blog-style-imgblock .blog-post-blocks-inner,
				.blog-style-postblock .blog-post-blocks-inner'
			),
			'declarations' => array(
				'border-radius' => $content_bradius . 'px',
				'overflow' => 'hidden'
			)
		) );
	}
	$setting = 'avant-wc-mobile-prod-full-width';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$title_bottom_margin = esc_attr( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.woocommerce ul.products,
    			.woocommerce-page ul.products'
			),
			'declarations' => array(
				'margin' => '0 0 10px !important'
			),
			'media' => '(max-width: 580px)'
		) );
		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.woocommerce ul.products li.product,
    			.woocommerce-page ul.products li.product'
			),
			'declarations' => array(
				'width' => '100% !important',
				'margin' => '0 0 24px !important'
			),
			'media' => '(max-width: 580px)'
		) );
	}
	$setting = 'avant-site-title-uc';
	$mod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

	if ( $mod !== customizer_library_get_default( $setting ) ) {

		$container_width = esc_attr( $mod );

		Customizer_Library_Styles()->add( array(
			'selectors' => array(
				'.site-title'
			),
			'declarations' => array(
				'text-transform' => 'uppercase'
			)
		) );
	}

}
endif;

add_action( 'customizer_library_styles', 'customizer_library_avant_build_styles' );

if ( ! function_exists( 'customizer_library_avant_styles' ) ) :
/**
 * Generates the style tag and CSS needed for the theme options.
 *
 * By using the "Customizer_Library_Styles" filter, different components can print CSS in the header.
 * It is organized this way to ensure there is only one "style" tag.
 *
 * @since  1.0.0.
 *
 * @return void
 */
function customizer_library_avant_styles() {

	do_action( 'customizer_library_styles' );

	// Echo the rules
	$css = Customizer_Library_Styles()->build();

	if ( ! empty( $css ) ) {
		echo "\n<!-- Begin Custom CSS -->\n<style type=\"text/css\" id=\"avant-custom-css\">\n";
		echo $css;
		echo "\n</style>\n<!-- End Custom CSS -->\n";
	}
}
endif;

add_action( 'wp_head', 'customizer_library_avant_styles', 11 );