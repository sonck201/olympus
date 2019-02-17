@extends('admin.layout.master')

@section('pageTitle')
{!!$titlePage!!} | @parent
@endsection

@section('content')
<section id="menu" class="page">
	<div class="row">
		@if ( count($types) > 0 )
		@foreach ( $types as $t )
		@if ( !isset($t->disabled) || $t->disabled != true )
		<div class="col-xs-2 form-group hasTooltip" title="{{ $t->description }}">
			@php $hyperlink = $param->action == 'add' ? route('adminMenuAdd', ['type' => str_slug($t->label)]) : route('adminMenuEdit', ['id' => $id, 'type' => str_slug($t->label)]) @endphp
			<a href="{{ $hyperlink }}" class="btn btn-primary btn-block">{{ $t->label }}</a>
		</div>
		@endif
		@endforeach
		@endif
	</div>
</section>
@endsection