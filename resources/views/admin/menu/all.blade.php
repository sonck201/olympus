@extends('admin.layout.master')

@section('pageTitle')
{{$titlePage}} | @parent
@endsection

@section('content')
<section id="menu" class="page">
	 <table class="table table-bordered table-condensed table-hover table-responsive table-striped tableList">
	 	<thead>
	 		<tr>
	 			<th>{!!Form::checkbox('checkAll', null, null, ['id' => 'checkAll'])!!}</th>
	 			<th class="">Title</th>
	 			<th class="text-center">Status</th>
	 			<th>Type</th>
	 			<th>Data</th>
	 			<th class="text-center">Parent - Level</th>
	 			<th class="text-center">Priority</th>
	 			<th class="text-right">ID</th>
	 		</tr>
	 	</thead>
	 	<tbody>
	 		@if ( count((array) $menus) > 0 )
	 		@foreach ( $menus as $m )
	 		<?php $space = ''?>
	 		@for ( $i = 2; $i < 1; $i++ )
	 		<?php $space .= '&nbsp;&nbsp;&nbsp;'?>
	 		@endfor
	 		<tr class="menu" id="{{$m->id}}">
	 			<td class="text-center">{!!Form::checkbox('item', null, null, ['id' => $m->id])!!}</td>
	 			<td class="title">
	 				<a href="{{$m->id != 100 ? route('adminMenuEdit', ['id' => $m->id, 'type' => $m->type]) : null}}">{{ str_limit($m->separate .' '. $m->title, 100) }}</a>
	 			</td>
	 			<td class="status">@include('admin.common.status', ['status' => $m->status])</td>
	 			<td>{{ studly_case($m->type) }}</td>
	 			<td class="text-danger">{{ $m->data }}</td>	 			
	 			<td class="text-center">{{$m->parent}} - {{$m->level}}</td>
	 			<td class="text-center priority">@include('admin.common.priority', ['priority' => $m->priority, 'min' => $m->min, 'max' => $m->max])</td>
	 			<td class="text-right">{{$m->id}}</td>
	 		</tr>
	 		@endforeach
	 		@else
	 		<tr>
	 			<td colspan="8" class="text-center">No data</td>
	 		</tr>
	 		@endif
	 	</tbody>
	</table>
	<div class="form-group">
		{!!Form::token()!!}
		{!!Form::hidden('urlUpdateStatus', Url::route('adminMenuUpdateStatus'))!!}
		{!!Form::hidden('urlUpdateAll', Url::route('adminMenuUpdateAll'))!!}
		{!!Form::hidden('urlUpdatePriority', Url::route('adminMenuUpdatePriority'))!!}
	</div>
</section>
@endsection