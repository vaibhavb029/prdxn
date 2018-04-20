/**
 * Home Slider JS Functionality
 *
 */
( function( $ ) {
    
    $(window).resize(function () {
        
        avant_center_slider_elements();
        
    }).resize();
    
    $(window).load(function() {
        
        avant_home_slider();
        
    });
    
    // Home Page Slider
    function avant_home_slider() {
        var home_slider_auto = $( '.home-slider-wrap' ).data( 'auto' );
        var home_slider_scroll_effect = $( '.home-slider-wrap' ).data( 'scroll' );
        
        $( '.home-slider' ).carouFredSel({
            responsive: true,
            circular: true,
            infinite: false,
            width: 1200,
            height: 'variable',
            items: {
                visible: 1,
                width: 1200,
                height: 'variable'
            },
            onCreate: function(items) {
                avant_center_slider_elements();
                $( '.home-slider-wrap' ).removeClass( 'home-slider-remove' );
            },
            scroll: {
                fx: home_slider_scroll_effect,
                duration: 450
            },
            auto: home_slider_auto,
            pagination: '.home-slider-pager',
            prev: '.home-slider-prev',
            next: '.home-slider-next'
        });
    }
    
    // Center default slider elements
    function avant_center_slider_elements() {
        $( '.home-slider-block' ).each( function( i ){
            $( this ).find( '.home-slider-block-inner').height( $( this ).find( '.home-slider-block-bg').outerHeight() );
        });
    }
    
} )( jQuery );