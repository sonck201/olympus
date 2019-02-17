@extends('admin.layout.master')

@section('pageTitle')
{{$titlePage}} | @parent
@endsection

@section('content')
<section id="widget" class="page">
	@include('admin.common.filter-table', ['keyword' => true, 'status' => true, 'position' => true, 'widgetType' => true])
	<table class="table table-bordered table-condensed table-hover table-responsive table-striped tableList">
	 	<thead>
	 		<tr>
	 			<th>{!!Form::checkbox('checkAll', null, null, ['id' => 'checkAll'])!!}</th>
	 			<th class="col-xs-4">Title</th>
	 			<th class="text-center">Status</th>
	 			<th class="text-center">Priority</th>
	 			<th class="">Position</th>
	 			<th class="">Type</th>
	 			<th class="text-right">ID</th>
	 		</tr>
	 	</thead>
	 	<tbody>
	 		@each('admin.widget.row', $widgets, 'w', 'admin.common.no-data')
	 	</tbody>
	</table>
	<div class="paginationContainer">{!! $widgets->links() !!}</div>
	<div class="form-group">
		{!!Form::token()!!}
		{!!Form::hidden('urlUpdateStatus', Url::route('adminWidgetUpdateStatus'))!!}
		{!!Form::hidden('urlUpdateAll', Url::route('adminWidgetUpdateAll'))!!}
		{!!Form::hidden('urlUpdatePriority', Url::route('adminWidgetUpdatePriority'))!!}
	</div>
</section>
@endsection