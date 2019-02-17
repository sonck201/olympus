<div class="form-group input-group">
	{!! Form::text('addFeature', null, ['class' => 'form-control', 'placeholder' => 'Input feature name to add to list']) !!}
	<span class="input-group-btn">
		<button class="btn btn-success" id="btnAddFeature" type="button"><i class="fa fa-plus"></i> Add</button>
		<button class="btn btn-warning hidden" id="btnReloadFeature" type="button"><i class="fa fa-refresh"></i> Reload</button>
	</span>
</div>
<div class="form-group">
	{!! Form::label('featureList', 'Feature list') !!}
	<div class="row">
		<div class="col-xs-9">{!! Form::select('featureList', [], null, ['id' => 'featureList', 'class' => 'form-control', 'placeholder' => 'Select feature from list to create custom data...', 'disabled' => 'disabled']) !!}</div>
		<div class="col-xs-3">
			<div class="btn-group btn-group-justified">
				<div class="btn-group">
					<button id="btnCreateFeature" class="btn btn-info" type="button" disabled="disabled"><i class="fa fa-plus"></i> Create</button>
				</div>
				<div class="btn-group">
					<button id="btnDeleteFeature" class="btn btn-danger" type="button" disabled="disabled"><i class="fa fa-ban"></i> Delete</button>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="form-group">
	<div id="featureData" class="row"></div>
</div>
<div class="form-group hidden">
	{!! Form::textarea('feature', isset($post->feature) ? $post->feature:null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
	{!! Form::hidden('urlLoadFeatureList', route('adminPostLoadFeatureList'), ['id' => 'urlLoadFeatureList']) !!}
	{!! Form::hidden('urlAddFeature', route('adminPostAddFeature'), ['id' => 'urlAddFeature']) !!}
	{!! Form::hidden('urlDeleteFeature', route('adminPostDeleteFeature'), ['id' => 'urlDeleteFeature']) !!}
	{!! Form::hidden('urlCreateFeature', route('adminPostCreateFeature'), ['id' => 'urlCreateFeature']) !!}
	{!! Form::hidden('urlGenerateFeature', route('adminPostGenerateFeature'), ['id' => 'urlGenerateFeature']) !!}
</div>