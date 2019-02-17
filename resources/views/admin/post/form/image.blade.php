<span class="btn btn-success fileinput-button">
	<i class="fa fa-fw fa-plus"></i>
	<span>Select files...</span>
	<input id="fileupload" type="file" name="files[]" multiple>
</span>

<br />
<br />

<div id="progress" class="progress"><div class="progress-bar progress-bar-striped active"></div></div>
<div id="fileInputReturn" class="row"></div>
<div class="form-group">
	{!! Form::hidden('imageField', (isset($post->image) ? basename($post->image) : null), ['id' => 'imageField', 'class' => 'form-control']) !!}
	{!! Form::hidden('imageBoxHolder', (isset($images) ? $images : null), ['id' => 'imageBoxHolder']) !!}
</div>