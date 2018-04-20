/**
 * Custom Blocks Functionality
 *
 */
( function( $ ) {
    
    $(window).load(function() {
        
        // Initialize the Masonry plugin
        var grid = $( '.blog-blocks-wrap-inner' ).masonry({
            columnWidth: 'article.blog-blocks-layout',
            itemSelector: 'article.blog-blocks-layout',
            percentPosition: true
        });

        // Once all images within the grid have loaded lay out the grid
        $( '.blog-blocks-wrap-inner' ).imagesLoaded( function() {
            grid.masonry('layout');
        });

        // Once the layout is complete hide the loader. Triggering the window resize event fixes a small spacing issue on the grid 
        grid.one( 'layoutComplete', function() {
            $( '.blog-blocks-wrap' ).removeClass( 'blog-blocks-wrap-remove' );
            $(window).resize();
        } );
        
    });
    
} )( jQuery );