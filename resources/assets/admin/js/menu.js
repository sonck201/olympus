$( function(){
	if ( typeof ( $.fancybox ) === 'object' ) {
		// active dialog in menu page
		$( this ).on( 'click', '.page#menu .btnGetData', function(){
			$.fancybox.open( {
			    src: $( '#urlGetData' ).val(),
			    type: 'ajax',
			    opts: {
				    ajax: {
				        settings: {
					        data: {
					            appTitle: $( '#appTitle' ).val(),
					            appModel: $( '#appModel' ).val(),
					            appClass: $( '#appClass' ).val(),
					            appType: $( '#appType' ).val(),
					            appPrefix: $( '#appPrefix' ).val()
					        }
				        }
				    }
			    }
			} );
		} );
	}
	
	// Load more data in menu page
	$( this ).on( 'click', '.btnLoadMoreMenuData', function( e ){
		e.preventDefault();
		$.ajax( {
		    url: $( '#urlGetDataMore' ).val(),
		    dataType: 'json',
		    data: {
		        appTitle: $( '#appTitle' ).val(),
		        appModel: $( '#appModel' ).val(),
		        appClass: $( '#appClass' ).val(),
		        appType: $( '#appType' ).val(),
		        appPrefix: $( '#appPrefix' ).val(),
		        appPage: ( parseInt( $( '#appPage' ).val() ) + 1 )
		    },
		    complete: function( r ){
			    $( '.tableGetData tbody' ).find( 'tr' ).remove();
			    $( '.tableGetData tbody' ).append( r.responseText );
		    }
		} );
	} );
	
	// Choose id from data
	$( this ).on( 'click', '.btnChooseId', function( e ){
		e.preventDefault();
		$( '#data' ).val( $( this ).prop( 'id' ) );
		$.fancybox.close();
	} );
} );