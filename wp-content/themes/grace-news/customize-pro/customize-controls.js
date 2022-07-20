( function( api ) {
	// Extends our custom "grace-news" section.
	api.sectionConstructor['grace-news'] = api.Section.extend( {
		// No events for this type of section.
		attachEvents: function () {},
		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );
} )( wp.customize );