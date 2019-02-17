var loading = '<section id="loadingBlock"><div class="loader">Loading...</div></section>', icoInfo = '<i class="fa fa-fw fa-lg fa-info-circle"></i> ', icoErr = '<i class="fa fa-fw fa-lg fa-times-circle"></i> ', errDetect = 'Error detected... Wait a moments for refreshing application!!';
$( function(){
	// Show menu when hover
	$( '#navbarTop li.dropdown' ).hover( function(){
		$( this ).addClass( 'open' );
	}, function(){
		$( this ).removeClass( 'open' );
	} );
	
	// Active parent menu
	ctrlAct = controller.toLowerCase() + action.substr( 0, 1 ).toUpperCase() + action.substr( 1 );
	$( '#' + ctrlAct ).closest( '.dropdown' ).addClass( 'active' );
	// Active child menu
	$( '#' + ctrlAct ).addClass( 'active' );
	// Active menu in page-form
	var subCtrlAct = controller + 'All', arrFormAct = ['add', 'edit'];
	if ( subCtrlAct != ctrlAct && $.inArray( action, arrFormAct ) >= 0 ) {
		$( '#' + subCtrlAct ).addClass( 'active' );
		$( '#' + subCtrlAct ).closest( '.dropdown' ).addClass( 'active' );
	}
	
	// Setup default tooltip
	$( '.hasTooltip' ).tooltip();
	
	// Setup tinyMCE editor
	if ( typeof ( tinymce ) != "undefined" && tinymce !== null ) {
		tinymce.init( {
		    selector: '.tinymce',
		    height: 300,
		    relative_urls: false,
		    remove_script_host: true,
		    document_base_url: siteurl,
		    valid_elements: '*[*]',
		    entity_encoding: 'raw',
		    toolbar_items_size: 'small',
		    image_advtab: true,
		    plugins: ['advlist autolink lists link image charmap print preview hr anchor pagebreak', 'searchreplace wordcount visualblocks visualchars code fullscreen', 'insertdatetime media nonbreaking save table contextmenu directionality', 'emoticons template paste textcolor colorpicker textpattern imagetools codesample responsivefilemanager'],
		    toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media responsivefilemanager | forecolor backcolor | pagebreak code | wordcount',
		    filemanager_title: 'Wargon CMS - File manager',
		    filemanager_access_key: 'gCguUk5r',
		    external_filemanager_path: siteurl + 'public/plugins/filemanager/',
		    external_plugins: {
			    'filemanager': siteurl + 'public/plugins/filemanager/plugin.min.js'
		    },
		    content_css: [siteurl + 'public/assets/css/bootstrap.min.css']
		} );
	}
	
	// Setup datepicker
	if ( typeof ( datetimepicker ) != "undefined" && datetimepicker !== null ) {
		$( '#datetimepicker' ).datetimepicker( {
		    format: 'YYYY-MM-DD HH:mm:ss',
		    showTodayButton: true
		} );
	}
	
	// Setup fancybox
	if ( typeof ( $.fancybox ) === 'object' ) {
		$( '[data-fancybox]' ).fancybox();
	}
	
	// Setup default onclick for btnControl
	$( '.btnAdd, .btnCancel' ).on( 'click', function(){
		window.location.href = $( this ).attr( 'data-href' );
	} );
	
	// Reset form
	$( '.btnReset' ).on( 'click', function(){
		$( 'form' ).trigger( 'reset' );
	} );
	
	// ajaxError
	$.ajaxSetup( {
		error: function( r, status ){
			// Shake if error on getLogin
			$( '.authLogin .page' ).removeClass( 'fadeIn' ).addClass( 'shake' ).show();
			
			// Remove loading block
			$( '#loadingBlock' ).remove();
			
			var arrErr = [];
			if ( r.status == 500 ) {
				arrErr.push( '<p>' + icoErr + errDetect + '</p>' );
// setTimeout( function(){
// location.reload();
// }, 5000 );
			} else if ( r.status == 422 ) {
				var errors = r.responseJSON;
				console.log( errors );
				
				$.each( errors, function( i, e ){
					arrErr.push( '<p>' + icoErr + e + '</p>' );
				} );
			}
			
			m = arrErr.join( "\n" );
			if ( m !== '' ) {
				$( '#message' ).html( '<div class="alert alert-danger animated fadeIn" role="alert">' + m + '</div>' );
			}
		}
	} );
	
	// Active / Deactive an item
	$( this ).on( 'click', '.btnActive, .btnDeactive', function( e ){
		e.preventDefault();
		
		$.ajax( {
		    url: $( 'input[name="urlUpdateStatus"]' ).val(),
		    type: 'POST',
		    dataType: 'json',
		    data: {
		        action: $( this ).data( 'name' ),
		        id: $( this ).closest( 'tr' ).prop( 'id' ),
		        _token: $( 'input[name="_token"' ).val()
		    },
		    success: function( r ){
			    $( 'tr#' + r.id ).find( '.status' ).html( r.view );
			    
			    cName = $( 'tr#' + r.id + ' td:eq(1)' ).text().replace( /\|/g, '' ).replace( /—/g, '' );
			    
			    alertType = r.action == 'active' ? 'success' : 'warning';
			    $( '#message' ).html( '<div class="alert alert-' + alertType + ' animated fadeIn" role="alert">' + icoInfo + controller + '#' + r.id + ' <b>' + cName + '</b> ' + r.action + '!!</div>' );
		    }
		} );
	} );
	
	// Check all item on tableList
	$( '#checkAll' ).on( 'click', function(){
		if ( $( this ).prop( 'checked' ) === true ) {
			$( '.table' ).find( 'input[type="checkbox"]' ).prop( 'checked', true );
		} else {
			$( '.table' ).find( 'input[type="checkbox"]' ).prop( 'checked', false );
		}
	} );
	
	// Dont save form in default
	onChange = true;
	console.log( 'Auto prevent update form without change anything!! Change to false for promotion.' );
	onChangeAttemp = 1;
	$( this ).on( 'change', ':input', function(){
		onChange = true;
	} );
	
	// Update data
	$( '.btnSave, .btnSaveClose, .btnSaveAdd' ).on( 'click', function( e ){
		e.preventDefault();
		btnName = $( this ).attr( 'data-type' );
		
		// Set some default url
		urlEdit = $( '#urlEdit' ).val();
		urlAdd = $( '#urlAdd' ).val();
		urlAll = $( '#urlAll' ).val();
		
		// Return if form not change
		if ( onChange == false && btnName == 'btnSaveClose' ) {
			$( '.btnCancel' ).click();
			return;
		} else if ( onChange == false && btnName == 'btnSaveAdd' ) {
			window.location.href = urlAdd;
			return;
		} else if ( onChange == false ) {
			// Attemp 3 times
			onChangeAttemp >= 3 ? alert( 'Nothing change!!' ) : onChangeAttemp++;
			console.log( 'Nothing change!!' );
			return;
		}
		
		// Return false when empty urlUpdate
		urlUpdate = $( '#urlUpdate' ).val();
		if ( typeof urlUpdate === 'undefined' || urlUpdate === '' ) {
			alert( 'Let\'s set URL for submit data via ajax.' );
			return false;
		}
		
		var input = {
		    action: action,
		    id: $( '#id' ).val()
		};
		
		$.each( $( ':input' ), function(){
			inputId = $( this ).prop( 'name' );
			
			if ( inputId.indexOf( 'url' ) < 0 ) {
				if ( inputId.indexOf( '[]' ) >= 0 && $( this ).prop( 'type' ) != 'select-multiple' ) {
					input[inputId] = ( typeof input[inputId] != 'undefined' && input[inputId] instanceof Array ) ? input[inputId] : []
					if ( $( this ).is( ':checked' ) ) {
						input[inputId].push( $( this ).val() );
					}
				} else if ( $( this ).prop( 'type' ) == 'radio' || $( this ).prop( 'type' ) == 'checkbox' ) {
					input[inputId] = $( this ).is( ':checked' ) ? $( this ).val() : null;
				} else {
					input[inputId] = inputId != '' ? $( this ).val() : null;
				}
			}
		} );
		
		// Active tinymce & get value for these editors
		if ( typeof ( tinymce ) != "undefined" && tinymce !== null ) {
			tinyMCE.triggerSave();
			$.each( input, function( i, val ){
				var matches = i.match( /^(title|content)\w+/ );
				if ( typeof ( matches ) != "undefined" && matches !== null ) {
					input[matches['input']] = $( '#' + matches['input'] ).val();
				}
			} );
		}
		
		// Add loading to body for submit ajax request
		$.ajax( {
		    url: urlUpdate,
		    type: 'POST',
		    dataType: 'json',
		    data: input,
		    beforeSend: function(){
			    $( 'body' ).append( loading );
		    },
		    success: function( r ){
			    // Remove loading block
			    $( '#loadingBlock' ).remove();
			    
			    // Reset onChange when complete
			    onChange = true;
			    console.log( 'Change this to false for promotion!!' );
			    
			    // Appear flash message when action is not ADD
			    if ( action != 'add' ) $( '#message' ).html( '<div class="alert alert-success animated fadeIn" role="alert">' + icoInfo + r.message + '</div>' );
			    
			    // Redirect when finish task
			    if ( btnName == 'btnSave' && action == 'add' && urlAll.length > 0 ) {
				    $( '#message' ).hide();
				    window.location.href = urlAll + '/edit/' + r.id;
			    } else if ( btnName == 'btnSaveAdd' && urlAdd.length > 0 ) {
				    $( '#message' ).hide();
				    window.location.href = urlAdd;
			    } else if ( btnName == 'btnSaveClose' && urlAll.length > 0 ) {
				    $( '#message' ).hide();
				    window.location.href = urlAll;
			    }
		    }
		} );
	} );
	
	// Publish / Unpublish / Trash / Delete
	$( this ).on( 'click', '.btnPublish, .btnUnpublish, .btnTrash, .btnDelete', function( e ){
		e.preventDefault();
		
		if ( $( 'table.tableList input:checked' ).length == 0 ) {
			alert( 'Please first make a selection from the list' );
			return false;
		} else {
			arrId = [];
			$( 'table.tableList input:checked' ).each( function(){
				var id = $( this ).closest( 'tr' ).attr( 'id' );
				if ( id > 0 ) {
					arrId.push( id );
				}
			} );
		}
		
		// confirm to delete
		actionName = $.trim( $( this ).text() );
		if ( actionName == 'Delete' && !confirm( 'Are you sure to delete this item(s)?' ) ) { return false; }
		
		$.ajax( {
		    url: $( 'input[name="urlUpdateAll"]' ).val(),
		    type: 'POST',
		    dataType: 'json',
		    data: {
		        action: actionName,
		        arrId: arrId,
		        _token: $( 'input[name="_token"' ).val()
		    },
		    success: function( r ){
			    if ( r.action == 'Delete' ) {
				    // Remove chosen category
				    $.each( r.arrId, function( index, value ){
					    $( 'tr#' + value ).remove();
				    } );
				    
				    // disabled priority control - for some page only
				    $( '.downP, .upP' ).addClass( 'disabled' );
				    window.location.reload();
			    } else {
				    // Repalce current status
				    $.each( r.arrId, function( index, value ){
					    $( 'tr#' + value ).find( '.status' ).html( r.view );
				    } );
				    
				    alertType = r.action == 'active' ? 'success' : 'warning';
				    $( '#message' ).html( '<div class="alert alert-' + alertType + ' animated fadeIn" role="alert">' + icoInfo + r.message + '!!</div>' );
			    }
			    
			    // Recheck all
			    $( '.table' ).find( 'input[type="checkbox"]' ).prop( 'checked', false );
		    }
		} );
	} );
	
	// Move priority
	$( this ).on( 'click', '.downP, .upP', function( e ){
		e.preventDefault();
		
		var cId = $( this ).closest( 'tr' ).prop( 'id' );
		var row = $( this ).parents( 'tr:first' );
		var directionP = $( this ).data( 'direction' );
		
		$.ajax( {
		    url: $( 'input[name="urlUpdatePriority"]' ).val(),
		    type: 'POST',
		    dataType: 'json',
		    data: {
		        direction: directionP,
		        id: cId,
		        _token: $( 'input[name="_token"' ).val()
		    },
		    success: function( response ){
			    // reload page
			    if ( response.reloaded == true ) {
				    location.reload();
				    return;
			    }
			    
			    // Create alert message
			    cName = $( 'tr#' + cId + ' td:eq(1)' ).text().replace( /\|/g, '' ).replace( /—/g, '' );
			    
			    $( '#message' ).html( '<div class="alert alert-success animated fadeIn" role="alert">' + icoInfo + ' <b>' + cName + '#' + cId + '</b> move ' + directionP + '!!</div>' );
			    
			    // Update priority realtime
			    $( 'tr#' + cId ).find( '.priority' ).html( response.view );
			    
			    // Move table
			    if ( directionP == 'up' ) {
				    row.prev().find( '.priority' ).html( response.viewRelated );
				    row.insertBefore( row.prev() );
			    } else {
				    row.next().find( '.priority' ).html( response.viewRelated );
				    row.insertAfter( row.next() );
			    }
		    }
		} );
	} );
	
	// Filter group
	$( '.filterGroup button' ).on( 'click', function(){
		filterGroup();
	} );
	$( '.filterGroup select' ).on( 'change', function(){
		filterGroup();
	} );
	
	var filterGroup = function(){
		var arrFilter = [];
		$.each( $( '.filterGroup :input' ), function(){
			filterType = $( this ).prop( 'name' ).replace( 'filter', '' ).toLowerCase();
			if ( filterType != '' ) {
				arrFilter.push( filterType + '=' + $( this ).val() );
			}
		} );
		
		window.location = siteuri + '/' + controller + '?' + arrFilter.join( '&' );
	}

	// Default color chart js
	// primary: rgb(51, 122, 183)
	// danger: rgb(217, 83, 79)
	// info: rgb(91, 192, 222)
	// warning: rgb(240, 173, 78)
	// success: rgb(92, 184, 192)
	// blue: rgb(51, 102, 204)
	// red: rgb(220, 57, 18)
	// orange: rgb(255, 153, 0)
	// green: rgb(16, 150, 24)
	// violet: rgb(153, 0, 153)
} );

function responsive_filemanager_callback( field_id ){
	$( '#imgPreview' ).prop( 'src', $( '#' + field_id ).val() );
}

function basename( path ){
	return path.replace( /\\/g, '/' ).replace( /.*\//, '' );
}

function dirname( path ){
	return path.replace( /\\/g, '/' ).replace( /\/[^\/]*$/, '' );
}