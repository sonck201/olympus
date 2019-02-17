<div class="form-group">
	{!! Form::label('href', 'Hyperlink') !!}
	<div class="input-group">
		{!! Form::text('href', isset($post->href) ? $post->href : null, ['class' => 'form-control', 'placeholder' => 'Input hyperlink for image']) !!}
		<span class="input-group-addon"><i class="fa fa-fw fa-globe"></i></span>
	</div>
</div>
<div class="form-group">
	{!! Form::label('target', 'Target') !!}
	{!! Form::select('target', ['_self' => 'Open in same window', '_blank' => 'Open in new window'], isset($post->target) ? $post->target : null, ['class' => 'form-control']) !!}
</div>