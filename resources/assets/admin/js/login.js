$( function(){
	// Set top for admin_login_form
	var loginFormOffset = {
	    'left': 0,
	    'top': 0
	};
	
	var authDeviation = 2, authHeight = $( '.authLogin .page' ).outerHeight( true ), authWidth = $( '.authLogin .page' ).outerWidth( true ), authMessageHeight = $( '#message' ).outerHeight( true );
	
	loginFormOffset.top = ( $( window ).height() - authHeight ) / authDeviation - authMessageHeight;
	$( '.authLogin .page' ).css( {
	    'display': 'block',
	    'top': loginFormOffset.top,
	    'left': ( $( window ).width() - authWidth ) / authDeviation
	} );
	
	// Recalculate on resizing
	$( window ).resize( function(){
		loginFormOffset.top = ( $( window ).height() - authHeight ) / authDeviation - authMessageHeight;
		$( '.authLogin .page' ).css( {
			'top': loginFormOffset.top
		} );
	} );
	
	// Focus on email field in login page
	if ( $( 'input [type="text"]' ).length > 0 ) {
		$( 'input[type="text"]' )[0].focus();
	}
	
	// Login process
	$( '.authLogin form .btn' ).on( 'click', function( e ){
		e.preventDefault();
		
		var input = {};
		$.each( $( ':input' ), function(){
			$( this ).prop( 'name' ) != '' ? input[$( this ).prop( 'name' )] = $( this ).val() : null;
		} );
		
		// Add loading to body for submit ajax request
		$.ajax( {
		    url: siteuri + '/auth/login',
		    type: 'POST',
		    dataType: 'json',
		    data: input,
		    beforeSend: function(){
			    $( 'body' ).append( loading );
			    $( '.authLogin .page' ).hide();
		    },
		    success: function( r ){
			    // Remove loading block
			    $( '#loadingBlock' ).remove();
			    
			    // Disabled form
			    $( '.authLogin form :input' ).attr( 'disabled', true );
			    
			    // Redirect when finish task
			    window.location.href = r.url;
		    }
		} );
	} );
} );