<div class="filterGroup">
	<div class="btn-group btn-group-justified btn-group-xs">
		<a class="btn btn-info" role="button" data-toggle="collapse" href="#filterList" aria-expanded="false" aria-controls="filterList"><i class="fa fa-fw fa-2x fa-filter"></i></a>
		<a class="btn btn-default" href="{{route('admin'. ucwords($param->controller))}}"><i class="fa fa-fw fa-2x fa-refresh"></i></a>
	</div>
	<div class="collapse" id="filterList">
		<div class="well well-sm">
			<div class="row">@include('admin.common.filter-table-content')</div>
		</div>
	</div>
</div>