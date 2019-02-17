@extends('web.layout.master')

@section('pageTitle')
{{$titlePage}} | @parent
@endsection

@section('breadcrumb')
{!!$breadcrumb!!}
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('public/plugins/fancybox/jquery.fancybox.min.css')}}" />
@endsection

@section('js')
<script src="{{asset('public/plugins/fancybox/jquery.fancybox.min.js')}}"></script>
@endsection

@section('content')
<h3 class="pageTitle">@if(auth::check())<a href="{{route('adminCategoryEdit', ['id' => $category->id, 'type' => $category->type])}}" class="btn btn-danger btn-xs" target="_blank"><i class="fa fa-pencil-square-o"></i></a>@endif {{$titlePage}}</h3>
<div class="postGroup">
	<div class="row">
	@each('web.content.grid.'. $category->type, $post, 'p', 'web.error.empty')
	</div>
</div>
<div class="text-center">{{$post->links()}}</div>
@endsection