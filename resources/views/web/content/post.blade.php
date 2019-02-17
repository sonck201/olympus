@extends('web.layout.master')

@section('pageTitle')
{{$titlePage}} | @parent
@endsection

@section('breadcrumb')
{!!$breadcrumb!!}
@endsection

@section('content')
<h3 class="pageTitle">@if(auth::check())<a href="{{route('adminPostEdit', ['id' => $post->id])}}" class="btn btn-danger btn-xs" target="_blank"><i class="fa fa-pencil-square-o"></i></a>@endif {{$titlePage}}</h3>
{!! str_replace('<p><!-- pagebreak --></p>', '', preg_replace('/(src="\/public)/i', 'src="'. asset('/public'), $post->data[$param->lang]->content)) !!}
@endsection