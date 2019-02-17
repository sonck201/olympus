$( function(){
	// Change post format
	$( '.btnFormat button' ).on( 'click', function(){
		// Active on ui
		$( '.btnFormat button' ).removeClass( 'active' );
		$( this ).addClass( 'active' );
		
		// Update hidden field
		$( '#format' ).val( $( this ).attr( 'id' ).replace( 'Format', '' ) );
		
		// Change view
		$.ajax( {
		    url: $( '#urlExtraFormat' ).val(),
		    type: 'POST',
		    dataType: 'html',
		    data: {
		        _token: $( 'input[name="_token"]' ).val(),
		        format: $( '#format' ).val(),
		        id: $( '#id' ).val()
		    },
		    success: function( r ){
			    // Update view
			    $( '#extraFormat' ).html( r );
			    if ( r != '' ) {
				    $( '#extraFormat' ).show();
			    } else {
				    $( '#extraFormat' ).hide();
			    }
		    }
		} );
	} );
	
	// Active format
	if ( $( '#format' ).val() == '' ) {
		$( '.btnFormat button#standardFormat' ).trigger( 'click' );
	} else {
		$( '.btnFormat button#' + $( '#format' ).val() + 'Format' ).trigger( 'click' );
	}
	
	// File upload
	if ( $.fn.fileupload && typeof urlUpload === 'string' && urlUpload.length > 0 ) {
		// Upload & show image
		$( '#fileupload' ).fileupload( {
		    url: urlUpload,
		    dataType: 'json',
		    disableImageResize: true,
		    imageCrop: true,
		    done: function( e, data ){
			    $.each( data.result.files, function( index, file ){
				    console.log( file.name );
				    $( '#imageBoxHolder' ).val( ( $( '#imageBoxHolder' ).val() != '' ? $( '#imageBoxHolder' ).val() + ',' : '' ) + file.name );
				    $( '#imageBoxHolder' ).trigger( 'loadImg', file.name );
			    } );
		    },
		    progressall: function( e, data ){
			    var progress = parseInt( data.loaded / data.total * 100, 10 );
			    $( '#progress .progress-bar' ).css( 'width', progress + '%' );
		    }
		} ).prop( 'disabled', !$.support.fileInput ).parent().addClass( $.support.fileInput ? undefined : 'disabled' );
	}
	
	// Auto load image on page load
	if ( $( '#imageBoxHolder' ).val() != '' ) {
		setTimeout( function(){
			$( '#imageBoxHolder' ).trigger( 'loadImg', [$( '#imageBoxHolder' ).val(), controller, $( '#id' ).val(), $( '#imageField' ).val()] );
		}, 100 );
	}
	
	// Load image box holder
	$( '#imageBoxHolder' ).on( 'loadImg', function( event, images, controller, id, active ){
		$.ajax( {
		    url: $( '#urlImageBoxHolder' ).val(),
		    type: 'POST',
		    dataType: 'html',
		    data: {
		        _token: $( 'input[name="_token"]' ).val(),
		        images: images,
		        controller: controller,
		        id: id,
		        active: active
		    },
		    success: function( r ){
			    if ( r != '' ) {
				    $( '#fileInputReturn' ).append( r );
			    }
		    }
		} );
	} );
	
	// do some actions in image box holder
	$( this ).on( 'click', '.doPrimary, .doDelete', function( e ){
		e.preventDefault();
		
		// Get image name
		var btnDo = $( this );
		var fileName = btnDo.closest( '.thumbnail' ).find( 'img' ).attr( 'src' );
		var urlProcess = btnDo.attr( 'href' );
		
		if ( $( this ).hasClass( 'doDelete' ) && !confirm( 'Delete this image?' ) ) { return false; }
		
		$.ajax( {
		    url: urlProcess,
		    type: 'POST',
		    data: {
		        _token: $( 'input[name="_token"]' ).val(),
		        filename: basename( fileName ),
		        controller: controller,
		        id: $( '#id' ).val()
		    },
		    success: function(){
			    if ( btnDo.hasClass( 'doDelete' ) ) {
				    btnDo.closest( '.thumbnail' ).parent().remove();
			    } else {
				    $( '#fileInputReturn .thumbnail' ).removeClass( 'has-primary' );
				    btnDo.closest( '.thumbnail' ).addClass( 'has-primary' );
			    }
			    
			    // Update image field
			    $( '#imageBoxHolder' ).trigger( 'updateImg' );
		    }
		} );
	} );
	
	// update image field
	$( '#imageBoxHolder' ).on( 'updateImg', function(){
		var arrImg = [];
		$.each( $( '#fileInputReturn .thumbnail img' ), function(){
			arrImg.push( basename( $( this ).attr( 'src' ) ) );
		} );
		
		$( '#imageBoxHolder' ).val( arrImg.join( ',' ) );
	} );
	
	/**
	 * Post FEATURE
	 */
	
	// Add feature
	$( '#btnAddFeature' ).on( 'click', function(){
		inputAddFeature = $( 'input[name="addFeature"]' );
		if ( inputAddFeature.val() != '' ) {
			$.ajax( {
			    url: $( '#urlAddFeature' ).val(),
			    type: 'POST',
			    data: {
			        _token: $( 'input[name="_token"]' ).val(),
			        feature: inputAddFeature.val()
			    },
			    success: function( r ){
				    // Make input empty
				    inputAddFeature.val( null );
				    
				    // Appear message
				    $( '#message' ).html( '<div class="alert alert-success animated fadeIn" role="alert">Feature added.</div>' );
				    
				    // Reload feature list
				    $( document ).trigger( 'loadFeatureList' );
			    }
			} );
		}
	} );
	
	// Delete feature
	$( '#btnDeleteFeature' ).on( 'click', function(){
		feature = $( '#featureList' ).val();
		
		$.ajax( {
		    url: $( '#urlDeleteFeature' ).val(),
		    type: 'POST',
		    data: {
		        _token: $( 'input[name="_token"]' ).val(),
		        feature: feature
		    },
		    success: function( r ){
			    // appear message
			    $( '#message' ).html( '<div class="alert alert-success animated fadeIn" role="alert">Feature deleted.</div>' );
			    
			    // Remove from list
			    $( '#featureList option[value="' + feature + '"]' ).remove();
		    }
		} );
	} );
	
	// Autoload feature list
	setTimeout( function(){
		$( document ).trigger( 'loadFeatureList' );
	}, 0 );
	
	// Load all feature and push to featureList
	$( this ).on( 'loadFeatureList', function(){
		// Delete maked feature from list
		// Do something
		// Endind
		
		// Load from database
		$.ajax( {
		    url: $( '#urlLoadFeatureList' ).val(),
		    type: 'POST',
		    data: {
		        _token: $( 'input[name="_token"]' ).val(),
		        feature: $( 'textarea[name="feature"]' ).val()
		    },
		    success: function( r ){
			    if ( r.features.length > 0 ) {
				    // Remove all options
				    $( '#featureList' ).find( 'option' ).remove();
			    }
			    
			    // Append options
			    $.each( r.features, function( k, v ){
				    $( '#featureList' ).append( '<option value="' + v + '">' + v + '</option>' );
			    } );
			    
			    if ( r.features.length > 0 ) {
				    // Enabled select
				    $( '#featureList, #btnCreateFeature, #btnDeleteFeature' ).prop( 'disabled', false );
			    }
		    }
		} );
	} );
	
	// make feature to form
	$( '#btnCreateFeature' ).on( 'click', function(){
		$( '#featureList, #btnCreateFeature, #btnDeleteFeature' ).prop( 'disabled', true );
		
		if ( $( '#featureList option' ).length == 0 ) {
			$( '#featureList' ).prop( 'disabled', true );
			return false;
		}
		
		feature = $( '#featureList' ).val();
		
		$.ajax( {
		    url: $( '#urlCreateFeature' ).val(),
		    type: 'POST',
		    data: {
		        _token: $( 'input[name="_token"]' ).val(),
		        feature: feature
		    },
		    success: function( html ){
			    // appear message
			    $( '#message' ).html( '<div class="alert alert-success animated fadeIn" role="alert">Feature created.</div>' );
			    
			    // Remove from list
			    $( '#featureList option[value="' + feature + '"]' ).remove();
			    
			    // appear html
			    $( '#featureData' ).append( html );
			    
			    // enable btn
			    $( '#featureList, #btnCreateFeature, #btnDeleteFeature' ).prop( 'disabled', false );
		    }
		} );
	} );
	
	// Remove feature in HTML form
	$( this ).on( 'click', '.btnRemoveFeature', function(){
		if ( !confirm( 'Delete this feature?' ) ) return false;
		
		$( this ).closest( 'dl' ).remove();
		$( document ).trigger( 'loadFeatureList' );
		$( document ).trigger( 'updateFeatureData' );
	} );
	
	// add option to feature HTML
	$( this ).on( 'click', '.btnAddOption', function(){
		dl = $( this ).closest( 'dl' );
		feature = dl.data( 'feature' );
		input = '<div class="input-group"><input class="form-control" placeholder="Enter ' + feature + ' value..." name="' + feature + '[]" type="text" /><span class="input-group-btn"><button class="btn btn-sm btn-default removeOption" type="button"><i class="fa fa-times"></i></button></span></div>';
		dl.find( '.form-group' ).append( input );
		
		// Focus on last created
		dl.find( '.optGroup input[type="text"]:last' ).focus();
	} );
	
	// remove option from feature HTML
	$( this ).on( 'click', '.removeOption', function(){
		// Check .. how many option remain... one left => dont kill
		if ( $( this ).closest( '.optGroup' ).children().length > 1 ) {
			$( this ).closest( '.input-group' ).remove();
			$( document ).trigger( 'updateFeatureData' );
		}
	} );
	
	// Generate feature HTML when have data
	if ( $( 'textarea[name="feature"]' ).val() != '' ) {
		$.ajax( {
		    url: $( '#urlGenerateFeature' ).val(),
		    type: 'POST',
		    data: {
		        _token: $( 'input[name="_token"]' ).val(),
		        feature: $( 'textarea[name="feature"]' ).val()
		    },
		    success: function( html ){
			    $( '#featureData' ).html( html );
		    }
		} );
	}
	
	// prepare data for saving
	$( this ).on( 'click', '.btnSave, .btnSaveAdd, .btnSaveClose', function(){
		$( document ).trigger( 'updateFeatureData' );
	} );
	
	// update feature data when changing feature option
	$( '#featureData input' )
	$( this ).on( 'keyup', '#featureData input[type="text"]', function(){
		$( document ).trigger( 'updateFeatureData' );
	} );
	
	// update feature data function
	$( this ).on( 'updateFeatureData', function(){
		// reset all data to null
		var objFeatureData = {};
		$( 'textarea[name="feature"]' ).val( '' );
		
		$( '#featureData dl' ).each( function( k, f ){
			var dl = $( this );
			dl.find( '.form-group input' ).each( function( k, o ){
				// Create array for sub element
				if ( !$.isArray( objFeatureData[dl.data( 'feature' )] ) ) {
					objFeatureData[dl.data( 'feature' )] = [];
				}
				
				// push value to element
				if ( o.value != '' ) {
					objFeatureData[dl.data( 'feature' )].push( o.value );
				}
			} );
		} );
		
		// store in a field
		$( 'textarea[name="feature"]' ).val( JSON.stringify( objFeatureData ) );
	} );
} );