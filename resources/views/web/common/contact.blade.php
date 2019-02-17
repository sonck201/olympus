@extends('web.layout.master')

@section('pageTitle')
{{$titlePage}} | @parent
@endsection

@section('breadcrumb')
{!!$breadcrumb!!}
@endsection

@section('content')
@include('web.common.contact-form')
@endsection