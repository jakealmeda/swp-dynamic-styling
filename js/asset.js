(function($) {
    
    $(document).ready(function() {
		
    	var DynaSty = swp_dynastyle.dynastyles;
    	
		$.each( DynaSty, function( index, value ){
			alert( index + " | " + value['target'] + " | " + value['selectors'] );
		});
        
    });

})( jQuery );

/*

// document is ready
jQuery( document ).ready( function() {
	ScreenSize();
});

// when resizing
jQuery( window ).resize( function() {
    ScreenSize();
});

function ScreenSize() {
    jQuery("#heightvalue").html( jQuery( window ).height() );
    jQuery("#widthvalue").html( jQuery( window ).width() );
}

*/