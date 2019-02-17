@extends('admin.layout.master')

@section('pageTitle')
{{$titlePage}} | @parent
@endsection

@section('content')
<section id="user" class="page">
	<table class="table table-bordered table-condensed table-hover table-responsive table-striped tableList">
		<thead>
			<tr>
				<th>{!!Form::checkbox('checkAll', null, null, ['id' => 'checkAll'])!!}</th>
				<th class="col-xs-3">Role</th>
				<th class="">Accessable places</th>
			</tr>
		</thead>
		<tbody>
	 		@if ( isset($roles) )
	 		@foreach ( $roles as $r )
	 		<tr class="category" id="{{$r->id}}">
	 			<td class="text-center">{!!Form::checkbox('item', null, null, ['id' => $r->id])!!}</td>
	 			<td class="title"><a href="{{route('adminUserEdit', ['id' => $r->id])}}">{{ $r->title }}</a></td>	 			
	 			<td class="accessiblePlace">@include('admin.user.accessible-place', ['accessiblePlace' => json_decode($r->accessible_place)])</td>
	 		</tr>
	 		@endforeach
	 		@else
	 		<tr>
	 			<td colspan="3" class="text-center">No data</td>
	 		</tr>
	 		@endif
	 	</tbody>
	</table>
</section>
@endsection