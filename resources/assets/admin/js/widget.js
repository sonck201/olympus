$( function(){
	// Expand all extra parameter into a variable
	var arrParameter = [];
	$.each( $( '.page#widget .parameterGroup :input' ), function(){
		attr = $( this ).prop( 'name' );
		if ( attr != 'parameterField' && $.inArray( attr, arrParameter ) === -1 ) {
			arrParameter.push( attr );
		}
	} );
	
	$( '.page#widget #parameterField' ).val( arrParameter.join( ',' ) );
	
	// Select All & Clear selection in ext_assignment
	$( '#btnSelectAll' ).on( 'click', function(){
		$( 'input[name="selectAssignment"]' ).val( 'all' );
		$( '#assignment option' ).attr( 'selected', 'selected' );
		$( '#assignment' ).attr( 'disabled', 'disabled' );
	} );
	
	$( '#btnSelectPage' ).on( 'click', function(){
		$( 'input[name="selectAssignment"]' ).val( null );
		$( '#assignment' ).removeAttr( 'disabled' );
	} );
	
	$( '#btnClearSelection' ).on( 'click', function(){
		$( 'input[name="selectAssignment"]' ).val( null );
		$( '#assignment' ).removeAttr( 'disabled' );
		$( '#assignment option' ).removeAttr( 'selected' );
	} );
	
	if ( $( 'input[name="selectAssignment"]' ).val() == 'all' ) {
		$( '#btnSelectAll' ).trigger( 'click' );
	}
} );