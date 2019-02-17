@extends('admin.layout.master')

@section('pageTitle')
{{$titlePage}} | @parent
@endsection

@section('content')
<section id="category" class="page">
	<div class="form-group btn-group btn-group-justified">
		@foreach ( $types as $i => $t )
		<a href="{{ route('adminCategory', ['type' => $t]) }}" class="btn btn-default {{ $type == $t ? 'active' : null }}">{{ ucfirst($t) }}</a>
		@endforeach
	</div>
	 <table class="table table-bordered table-condensed table-hover table-responsive table-striped tableList">
	 	<thead>
	 		<tr>
	 			<th>{!!Form::checkbox('checkAll', null, null, ['id' => 'checkAll'])!!}</th>
	 			<th class="col-xs-6">Title</th>
	 			<th class="text-center">Status</th>
	 			<th class="text-center">Parent - Level</th>
	 			<th class="text-center">Priority</th>
	 			<th class="text-right">Visit/Pageview</th>
	 			<th class="text-right">ID</th>
	 		</tr>
	 	</thead>
	 	<tbody>
	 		@if ( count((array) $categories) > 0 )
	 		@foreach ( $categories as $c )
	 		<?php $space = ''?>
	 		@for ( $i = 2; $i < 1; $i++ )
	 		<?php $space .= '&nbsp;&nbsp;&nbsp;'?>
	 		@endfor
	 		<tr class="category" id="{{$c->id}}">
	 			<td class="text-center">{!!Form::checkbox('item', null, null, ['id' => $c->id])!!}</td>
	 			<td class="title">
	 				<a href="{{route('adminCategoryEdit', [Route::input( 'type' ), $c->id])}}">
	 					{{ str_limit($c->separate .' '. $c->title, 100) }}
	 				</a>
	 			</td>
	 			<td class="status">@include('admin.common.status', ['status' => $c->status])</td>	 			
	 			<td class="text-center">{{$c->parent}} - {{$c->level}}</td>
	 			<td class="text-center priority">@include('admin.common.priority', ['priority' => $c->priority, 'min' => $c->min, 'max' => $c->max])</td>
	 			<td class="text-right">
	 				<span class="pull-left badge">{{number_format($c->visit/$c->pageview*100)}}%</span>
					{{$c->visit}} / {{$c->pageview}}
	 			</td>
	 			<td class="text-right">{{$c->id}}</td>
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
		{!!Form::hidden('urlUpdateStatus', Url::route('adminCategoryUpdateStatus', ['type' => Route::input( 'type' )]))!!}
		{!!Form::hidden('urlUpdateAll', Url::route('adminCategoryUpdateAll', ['type' => Route::input( 'type' )]))!!}
		{!!Form::hidden('urlUpdatePriority', Url::route('adminCategoryUpdatePriority', ['type' => Route::input( 'type' )]))!!}
	</div>
</section>
@endsection