( function( api ) {

	// Extends our custom "example-1" section.
	api.sectionConstructor['avant_premium'] = api.Section.extend( {
		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );
    
    var api_inter_link = wp.customize;
    api_inter_link.bind('ready', function() {
        $(['control', 'section', 'panel']).each(function(i, type) {
            $('a[rel="tc-'+type+'"]').click(function(e) {
                e.preventDefault();
                var id = $(this).attr('href').replace('#', '');
                if(api_inter_link[type].has(id)) {
                    api_inter_link[type].instance(id).focus();
                }
            });
        });
    });

} )( wp.customize );
