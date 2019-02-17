<dl class="dl-horizontal col-xs-6" data-feature="{{$feature}}">
	<dt>{!! Form::label($feature, ucfirst($feature)) !!}</dt>
	<dd>
		<div class="form-group form-group-sm optGroup">
			@if ( isset($options) )
			@foreach( $options as $o )
			<div class="input-group">
				{!! Form::text($feature .'[]', $o, ['id' => null, 'class' => 'form-control', 'placeholder' => 'Enter '. $feature .' value...']) !!}
				<span class="input-group-btn">
					<button class="btn btn-sm btn-default removeOption" type="button"><i class="fa fa-times"></i></button>
				</span>
			</div>
			@endforeach
			@endif
			
			<div class="input-group">
				{!! Form::text($feature .'[]', null, ['id' => null, 'class' => 'form-control', 'placeholder' => 'Enter '. $feature .' value...']) !!}
				<span class="input-group-btn">
					<button class="btn btn-sm btn-default removeOption" type="button"><i class="fa fa-times"></i></button>
				</span>
			</div>
		</div>
		<div class="btn-group btn-group-justified">
			<div class="btn-group">
				<button type="button" class="btn btn-link btn-xs btnAddOption"><i class="fa fa-fw fa-plus"></i> Add option</button>
			</div>
			<div class="btn-group">
				<button type="button" class="btn btn-danger btn-xs btnRemoveFeature"><i class="fa fa-fw fa-times"></i> Remove this feature</button>
			</div>
		</div>
	</dd>
</dl>