/**
 * Customizer Custom Functionality
 *
 */
( function( $ ) {
    
    $( window ).load( function() {
        
        // Show / Hide Site Boxed Color Setting
        var avant_site_boxed_select_value = $( '#customize-control-avant-site-layout select' ).val();
        avant_site_boxed_value_check( avant_site_boxed_select_value );

        $( '#customize-control-avant-site-layout select' ).on( 'change', function() {
            var avant_sboxed_select_value = $( this ).val();
            avant_site_boxed_value_check( avant_sboxed_select_value );
        } );

        function avant_site_boxed_value_check( avant_sboxed_select_value ) {
            if ( avant_sboxed_select_value == 'avant-site-boxed' ) {
                $( '#sub-accordion-section-colors #customize-control-avant-boxed-bg-color' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-site #customize-control-avant-add-sidebar-line' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-site #customize-control-avant-remove-content-bgborder' ).hide();
                $( '#sub-accordion-section-avant-blog-section-blog #customize-control-avant-blog-break-blocks' ).hide();
            } else {
                $( '#sub-accordion-section-colors #customize-control-avant-boxed-bg-color' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-site #customize-control-avant-add-sidebar-line' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-site #customize-control-avant-remove-content-bgborder' ).show();
                $( '#sub-accordion-section-avant-blog-section-blog #customize-control-avant-blog-break-blocks' ).show();
            }
        }
        
        // Show / Hide Header Layout Settings
        var avant_header_layout_value = $( '#customize-control-avant-header-layout select' ).val();
        avant_header_layout_type_check( avant_header_layout_value );

        $( '#customize-control-avant-header-layout select' ).on( 'change', function() {
            var avant_header_select_value = $( this ).val();
            avant_header_layout_type_check( avant_header_select_value );
        });

        function avant_header_layout_type_check( avant_header_select_value ) {
            if ( avant_header_select_value == 'avant-header-layout-seven' ) {
                $( '#sub-accordion-section-avant-panel-colors-section-header #customize-control-avant-header-bg-opacity' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-topbar-switch' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-switch' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-site #customize-control-avant-site-layout' ).show();
                $( '#sub-accordion-section-avant-panel-colors-section-nav #customize-control-avant-nav-drop-opacity' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-remove-slider-space' ).hide();
                $( '#sub-accordion-section-avant-panel-colors-section-nav #customize-control-avant-navi-bg-color' ).hide();
                $( '#sub-accordion-section-avant-panel-colors-section-nav #customize-control-avant-navi-font-color' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-footer #customize-control-avant-footer-side-fullwidth' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-nav-align' ).hide();
            } else if ( avant_header_select_value == 'avant-header-layout-six' ) {
                $( '#sub-accordion-section-avant-site-layout-section-footer #customize-control-avant-footer-side-fullwidth' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-nav-align' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-topbar-switch' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-switch' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-remove-slider-space' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-site #customize-control-avant-site-layout' ).hide();
                $( '#sub-accordion-section-avant-panel-colors-section-header #customize-control-avant-header-bg-opacity' ).hide();
                $( '#sub-accordion-section-avant-panel-colors-section-nav #customize-control-avant-navi-bg-color' ).hide();
                $( '#sub-accordion-section-avant-panel-colors-section-nav #customize-control-avant-navi-font-color' ).hide();
                $( '#sub-accordion-section-avant-panel-colors-section-nav #customize-control-avant-nav-drop-opacity' ).hide();
            } else if ( avant_header_select_value == 'avant-header-layout-three' ) {
                $( '#sub-accordion-section-avant-panel-colors-section-nav #customize-control-avant-navi-bg-color' ).show();
                $( '#sub-accordion-section-avant-panel-colors-section-nav #customize-control-avant-navi-font-color' ).show();
                $( '#sub-accordion-section-avant-panel-colors-section-header #customize-control-avant-header-bg-opacity' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-topbar-switch' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-switch' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-remove-slider-space' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-site #customize-control-avant-site-layout' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-footer #customize-control-avant-footer-side-fullwidth' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-nav-align' ).hide();
                $( '#sub-accordion-section-avant-panel-colors-section-nav #customize-control-avant-nav-drop-opacity' ).hide();
            } else if ( avant_header_select_value == 'avant-header-layout-four' || avant_header_select_value == 'avant-header-layout-five' ) {
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-remove-slider-space' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-topbar-switch' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-switch' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-site #customize-control-avant-site-layout' ).show();
                $( '#sub-accordion-section-avant-panel-colors-section-header #customize-control-avant-header-bg-opacity' ).hide();
                $( '#sub-accordion-section-avant-panel-colors-section-nav #customize-control-avant-navi-bg-color' ).hide();
                $( '#sub-accordion-section-avant-panel-colors-section-nav #customize-control-avant-navi-font-color' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-footer #customize-control-avant-footer-side-fullwidth' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-nav-align' ).hide();
                $( '#sub-accordion-section-avant-panel-colors-section-nav #customize-control-avant-nav-drop-opacity' ).hide();
            } else if ( avant_header_select_value == 'avant-header-layout-two' ) {
                $( '#sub-accordion-section-avant-panel-colors-section-nav #customize-control-avant-navi-bg-color' ).show();
                $( '#sub-accordion-section-avant-panel-colors-section-nav #customize-control-avant-navi-font-color' ).show();
                $( '#sub-accordion-section-avant-panel-colors-section-header #customize-control-avant-header-bg-opacity' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-topbar-switch' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-switch' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-remove-slider-space' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-site #customize-control-avant-site-layout' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-footer #customize-control-avant-footer-side-fullwidth' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-nav-align' ).hide();
                $( '#sub-accordion-section-avant-panel-colors-section-nav #customize-control-avant-nav-drop-opacity' ).hide();
            } else {
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-topbar-switch' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-switch' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-site #customize-control-avant-site-layout' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-remove-slider-space' ).hide();
                $( '#sub-accordion-section-avant-panel-colors-section-header #customize-control-avant-header-bg-opacity' ).hide();
                $( '#sub-accordion-section-avant-panel-colors-section-nav #customize-control-avant-navi-bg-color' ).hide();
                $( '#sub-accordion-section-avant-panel-colors-section-nav #customize-control-avant-navi-font-color' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-footer #customize-control-avant-footer-side-fullwidth' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-header #customize-control-avant-header-nav-align' ).hide();
                $( '#sub-accordion-section-avant-panel-colors-section-nav #customize-control-avant-nav-drop-opacity' ).hide();
            }
        }
        
        // Show / Hide Slider Settings
        var avant_the_slider_select_value = $( '#customize-control-avant-slider-type select' ).val();
        avant_customizer_slider_check( avant_the_slider_select_value );

        $( '#customize-control-avant-slider-type select' ).on( 'change', function() {
            var avant_slider_select_value = $( this ).val();
            avant_customizer_slider_check( avant_slider_select_value );
        } );

        function avant_customizer_slider_check( avant_slider_select_value ) {
            if ( avant_slider_select_value == 'avant-no-slider' ) {
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-cats' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-size' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-scroll-effect' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-full-width' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-linkto-post' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-remove-title' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-remove-sub-title' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-auto-scroll' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-remove-pagination' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-shortcode' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slidermage-size' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slidermage-fullwidth' ).hide();
            } else if ( avant_slider_select_value == 'avant-shortcode-slider' ) {
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-cats' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-size' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-scroll-effect' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-full-width' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-linkto-post' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-remove-title' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-remove-sub-title' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-auto-scroll' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-remove-pagination' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slidermage-size' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slidermage-fullwidth' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-shortcode' ).show();
            } else if ( avant_slider_select_value == 'avant-home-featured-image' ) {
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-cats' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-size' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-scroll-effect' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-full-width' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-linkto-post' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-remove-title' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-remove-sub-title' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-auto-scroll' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-remove-pagination' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-shortcode' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slidermage-size' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slidermage-fullwidth' ).show();
            } else {
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slidermage-size' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slidermage-fullwidth' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-shortcode' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-cats' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-size' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-scroll-effect' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-full-width' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-linkto-post' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-remove-title' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-remove-sub-title' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-auto-scroll' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-slider #customize-control-avant-slider-remove-pagination' ).show();
            }
        }

        // Show / Hide blog blocks options
        var avant_blocks_layout_value = $( '#customize-control-avant-blog-layout select' ).val();
        var avant_blocks_style_value = $( '#customize-control-avant-blog-blocks-style select' ).val();
        avant_blocks_layout_type_check( avant_blocks_layout_value, avant_blocks_style_value );

        $( '#customize-control-avant-blog-layout select' ).on( 'change', function() {
            var avant_blocks_style_value = $( '#customize-control-avant-blog-blocks-style select' ).val();
            var avant_blocks_select_value = $( this ).val();
            avant_blocks_layout_type_check( avant_blocks_select_value, avant_blocks_style_value );
        });
        $( '#customize-control-avant-blog-blocks-style select' ).on( 'change', function() {
            var avant_blocks_select_value = $( '#customize-control-avant-blog-layout select' ).val();
            var avant_blocks_style_value = $( this ).val();
        });
        
        function avant_blocks_layout_type_check( avant_blocks_select_value, avant_blocks_style_value ) {
            if ( avant_blocks_select_value == 'blog-blocks-layout' ) {
                $( '#sub-accordion-section-avant-blog-section-blog #customize-control-avant-blog-blocks-remove-border' ).show();
                $( '#sub-accordion-section-avant-blog-section-blog #customize-control-avant-blog-blocks-remove-content' ).show();
            } else {
                $( '#sub-accordion-section-avant-blog-section-blog #customize-control-avant-blog-blocks-remove-border' ).hide();
                $( '#sub-accordion-section-avant-blog-section-blog #customize-control-avant-blog-blocks-remove-content' ).hide();
            }
        }
        
        // Show / Hide footer layout settings
        var avant_foot_select_value = $( '#customize-control-avant-footer-layout select' ).val();
        avant_foot_value_check( avant_foot_select_value );

        $( '#customize-control-avant-footer-layout select' ).on( 'change', function() {
            var foot_select_value = $( this ).val();
            avant_foot_value_check( foot_select_value );
        } );

        function avant_foot_value_check( foot_select_value ) {
            if ( foot_select_value == 'avant-footer-layout-none' ) {
                $( '#sub-accordion-section-avant-site-layout-section-footer #customize-control-avant-bottombar-switch' ).show();
                $( '#sub-accordion-section-avant-panel-colors-section-footer #customize-control-avant-footer-bg-color' ).hide();
                $( '#sub-accordion-section-avant-panel-colors-section-footer #customize-control-avant-footer-heading-font-color' ).hide();
                $( '#sub-accordion-section-avant-panel-colors-section-footer #customize-control-avant-footer-font-color' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-footer #customize-control-avant-noteon-footer-standard' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-footer #customize-control-avant-noteon-footer-social' ).hide();
            } else if ( foot_select_value == 'avant-footer-layout-standard' ) {
                $( '#sub-accordion-section-avant-panel-colors-section-footer #customize-control-avant-footer-bg-color' ).show();
                $( '#sub-accordion-section-avant-panel-colors-section-footer #customize-control-avant-footer-heading-font-color' ).show();
                $( '#sub-accordion-section-avant-panel-colors-section-footer #customize-control-avant-footer-font-color' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-footer #customize-control-avant-bottombar-switch' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-footer #customize-control-avant-noteon-footer-standard' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-footer #customize-control-avant-noteon-footer-social' ).hide();
            } else {
                $( '#sub-accordion-section-avant-panel-colors-section-footer #customize-control-avant-footer-bg-color' ).show();
                $( '#sub-accordion-section-avant-panel-colors-section-footer #customize-control-avant-footer-font-color' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-footer #customize-control-avant-noteon-footer-social' ).show();
                $( '#sub-accordion-section-avant-site-layout-section-footer #customize-control-avant-bottombar-switch' ).hide();
                $( '#sub-accordion-section-avant-panel-colors-section-footer #customize-control-avant-footer-heading-font-color' ).hide();
                $( '#sub-accordion-section-avant-site-layout-section-footer #customize-control-avant-noteon-footer-standard' ).hide();
            }
        }

        // Show / Hide Page Featured Image Layout
        var avant_page_layout_value = $( '#customize-control-avant-page-fimage-layout select' ).val();
        avant_page_layout_type_check( avant_page_layout_value );

        $( '#customize-control-avant-page-fimage-layout select' ).on( 'change', function() {
            var avant_page_select_value = $( this ).val();
            avant_page_layout_type_check( avant_page_select_value );
        });

        function avant_page_layout_type_check( avant_page_select_value ) {
            if ( avant_page_select_value == 'avant-page-fimage-layout-banner' ) {
                $( '#sub-accordion-section-avant-site-layout-section-page #customize-control-avant-page-fimage-size' ).show();
            } else {
                $( '#sub-accordion-section-avant-site-layout-section-page #customize-control-avant-page-fimage-size' ).hide();
            }
        }
        
        // Show / Hide Single Post Featured Image Layout
        var avant_single_page_layout_value = $( '#customize-control-avant-single-page-fimage-layout select' ).val();
        avant_single_page_layout_type_check( avant_single_page_layout_value );

        $( '#customize-control-avant-single-page-fimage-layout select' ).on( 'change', function() {
            var avant_single_page_select_value = $( this ).val();
            avant_single_page_layout_type_check( avant_single_page_select_value );
        });

        function avant_single_page_layout_type_check( avant_single_page_select_value ) {
            if ( avant_single_page_select_value == 'avant-single-page-fimage-layout-banner' ) {
                $( '#sub-accordion-section-avant-blog-section-post #customize-control-avant-single-page-fimage-size' ).show();
            } else {
                $( '#sub-accordion-section-avant-blog-section-post #customize-control-avant-single-page-fimage-size' ).hide();
            }
        }

    } );

} )( jQuery );