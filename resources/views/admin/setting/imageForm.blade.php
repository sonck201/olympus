<div class="row">
	<div class="col-xs-6">
		<div class="form-group">
			{!!Form::label('watermark', 'Watermark')!!}
			{!!Form::select('watermark', [1 => 'Yes', 0 => 'No'], $setting->watermark, ['class' => 'form-control'])!!}
		</div>
		<div class="form-group">
			{!!Form::label('watermarkText', 'Watermark text')!!}
			{!!Form::text('watermarkText', $setting->watermarkText, ['class' => 'form-control', 'placeholder' => 'Wargon'])!!}
		</div>
		<div class="form-group">
			{!!Form::label('watermarkFont', 'Watermark font')!!}
			{!!Form::text('watermarkFont', $setting->watermarkFont, ['class' => 'form-control', 'placeholder' => ''])!!}
		</div>
		<div class="form-group">
			{!!Form::label('watermarkDynamicColor', 'Watermark dynamic color')!!}
			{!!Form::select('watermarkDynamicColor', [1 => 'Yes', 0 => 'No'], $setting->watermarkDynamicColor, ['class' => 'form-control', 'title' => 'Watermark color will generate depend on background color.'])!!}
		</div>
		<div class="form-group">
			{!!Form::label('watermarkColorCode', 'Watermark color code')!!}
			{!!Form::text('watermarkColorCode', $setting->watermarkColorCode, ['class' => 'form-control', 'placeholder' => '444d58'])!!}
		</div>
	</div>
	<div class="col-xs-6">
		<div class="form-group imageSize">
			{!!Form::label('maxPost', 'Post image')!!}
			<div class="row">
				<div class="col-xs-5">
					{!!Form::text('maxPostWidth', $setting->maxPostWidth, ['class' => 'form-control hasTooltip', 'placeholder' => 'Width: 800', 'title' => 'Width'])!!}
				</div>
				<div class="col-xs-2 text-center"><i class="fa fa-times fa-fw"></i></div>
				<div class="col-xs-5">
					{!!Form::text('maxPostHeight', $setting->maxPostHeight, ['class' => 'form-control hasTooltip', 'placeholder' => 'Height: 600', 'title' => 'Height'])!!}
				</div>
			</div>
		</div>
	</div>
</div>