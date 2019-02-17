@extends('admin.layout.master')

@section('pageTitle')
{!!$titlePage!!} | @parent
@endsection

@section('content')
<section id="widget" class="page">
	<div class="row">
		@if ( count($types) > 0 )
		@foreach ( $types as $t )
		<div class="col-xs-3 form-group hasTooltip" title="{{ $t['description'] }}">
			<a href="{{ route('adminWidgetAdd', ['type' => str_slug($t['label'])]) }}" class="btn btn-primary btn-block">{{ $t['label'] }}</a>
		</div>
		@endforeach
		@endif
	</div>
</section>
@endsection