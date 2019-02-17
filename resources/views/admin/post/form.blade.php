@extends('admin.layout.master') 

@section('pageTitle') 
{!! $titlePage !!} | @parent 
@endsection 

@section('content')
<section id="post" class="page">
	{!! Form::open( ['route' => ['adminPostUpdate'], 'class' => 'validate'] ) !!}
	
	<div class="form-group btn-group btn-group-justified btnFormat" role="group">
		@foreach ( $formats as $k => $f )
		<div class="btn-group" role="group">
			{!! Form::button($f, ['class' => 'btn btn-primary', 'id' => $k .'Format', ($param->action == 'edit' ? 'disabled':null)]) !!}
		</div>
		@endforeach
		{!! Form::hidden('format', isset($post->format) ? $post->format : null, ['id' => 'format']) !!}
	</div>
	
	<ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#formGeneral" aria-controls="formGeneral" role="tab" data-toggle="tab">General</a></li>
		<li role="presentation" class=""><a href="#formImage" aria-controls="formImage" role="tab" data-toggle="tab">Image</a></li>
		<li role="presentation" class=""><a href="#formFeature" aria-controls="formFeature" role="tab" data-toggle="tab">Feature</a></li>
	</ul>
	<div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="formGeneral">@include('admin.post.form.general')</div>
		<div role="tabpanel" class="tab-pane" id="formImage">@include('admin.post.form.image')</div>
		<div role="tabpanel" class="tab-pane" id="formFeature">@include('admin.post.form.feature')</div>
	</div>
	
	<div class="form-group">
		{!! Form::hidden('id', isset($post->id) ? $post->id : null, ['id' => 'id']) !!}
		{!! Form::hidden('urlUpdate', route('adminPostUpdate'), ['id' => 'urlUpdate']) !!}
		{!! Form::hidden('urlAll', route('adminPost'), ['id' => 'urlAll']) !!}
		{!! Form::hidden('urlNew', route('adminPostAdd'), ['id' => 'urlAdd']) !!}
		{!! Form::hidden('urlExtraFormat', route('adminPostExtraFormat'), ['id' => 'urlExtraFormat']) !!}
		{!! Form::hidden('urlImageBoxHolder', route('adminPostImageBoxHolder'), ['id' => 'urlImageBoxHolder']) !!}
		
		@if( $param->action == 'edit' ) 
		{!! Form::hidden('urlEdit', route('adminPostEdit', ['id' => $post->id]), ['id' => 'urlEdit']) !!} 
		@endif
	</div>
	{!! Form::close() !!}
</section>
@endsection 

@section('css')
<link rel="stylesheet" href="{{asset('public/plugins/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" />
<link rel="stylesheet" href="{{asset('public/plugins/fancybox/jquery.fancybox.min.css')}}" />
<link rel="stylesheet" href="{{asset('public/plugins/fileupload/css/jquery.fileupload.css')}}" />
@endsection

@section('js')
<script src="{{asset('public/assets/js/moment.min.js')}}"></script>
<script src="{{asset('public/plugins/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('public/plugins/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
<script src="{{asset('public/plugins/fancybox/jquery.fancybox.min.js')}}"></script>
<script src="{{asset('public/plugins/jqueryui/jquery-ui.min.js')}}"></script>
<script src="{{asset('public/plugins/fileupload/js/jquery.iframe-transport.js')}}"></script>
<script src="{{asset('public/plugins/fileupload/js/jquery.fileupload.min.js')}}"></script>

<script type="text/javascript">var urlUpload = '{{route("adminFileUpload")}}'</script>
<script src="{{asset('public/templates/'. $setting->adminTemplate .'/js/post.js')}}"></script>
@endsection