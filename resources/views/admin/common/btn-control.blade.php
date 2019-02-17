@foreach ( $arrBtn as $btn )
	<?php $btnName = 'btn' . ucfirst( $btn )?>
	
	<div class="btn-group">
	@if ( $btn == 'add' )
		{!! Form::button( '<i class="fa fa-plus"></i> ' . ucwords( $btn ), ['class' => 'btn btn-success btn-xs ' . $btnName, 'data-href' => \URL::route( $routeName, $arrParam ) . '/add'] ) !!}
	@elseif ( $btn == 'cancel' )
		{!! Form::button( '<i class="fa fa-remove"></i> ' . ucwords( $btn ), ['class' => 'btn btn-danger btn-xs ' . $btnName, 'data-href' => \URL::route( $routeName, $arrParam )] ) !!}
	@elseif ( $btn == 'publish' )
		{!! Form::button( '<i class="fa fa-check"></i> ' . ucwords( $btn ), ['class' => 'btn btn-default btn-xs ' . $btnName] ) !!}
	@elseif ( $btn == 'unpublish' )
		{!! Form::button( '<i class="fa fa-ban"></i> ' . ucwords( $btn ), ['class' => 'btn btn-default btn-xs ' . $btnName] ) !!}
	@elseif ( $btn == 'trash' )
		{!! Form::button( '<i class="fa fa-recycle"></i> ' . ucwords( $btn ), ['class' => 'btn btn-warning btn-xs ' . $btnName] ) !!}
	@elseif ( $btn == 'delete' )
		{!! Form::button( '<i class="fa fa-trash"></i> ' . ucwords( $btn ), ['class' => 'btn btn-danger btn-xs ' . $btnName] ) !!}
	@elseif ( $btn == 'reset' )
		{!! Form::button( '<i class="fa fa-refresh"></i> ' . ucwords( $btn ), ['class' => 'btn btn-info btn-xs ' . $btnName] ) !!}
	@elseif ( $btn == 'save' )
		{!! Form::button( '<i class="fa fa-edit"></i> Save', ['class' => 'btn btn-primary btn-xs ' . $btnName, 'data-type' => $btnName] ) !!}
	@elseif ( $btn == 'saveClose' )
		{!! Form::button( '<i class="fa fa-check"></i> Save & Close', ['class' => 'btn btn-default btn-xs ' . $btnName, 'data-type' => $btnName] ) !!}
	@elseif ( $btn == 'saveAdd' )
		{!! Form::button( '<i class="fa fa-plus"></i> Save & Add', ['class' => 'btn btn-default btn-xs ' . $btnName, 'data-type' => $btnName] ) !!}
	@else
		{!! Form::button( 'Undefined button', ['class' => 'btn btn-default btn-xs'] ) !!}
	@endif
	</div>
@endforeach