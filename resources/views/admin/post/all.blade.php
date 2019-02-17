@extends('admin.layout.master')

@section('pageTitle')
{{$titlePage}} | @parent
@endsection

@section('content')
<section id="post" class="page">
	@include('admin.common.filter-table', ['keyword' => true, 'category' => true, 'format' => true, 'status' => true, 'date' => true, 'visit' => true, 'pageview' => true])
	<table class="table table-bordered table-condensed table-hover table-responsive table-striped tableList">
		<thead>
			<tr>
				<th>{!!Form::checkbox('checkAll', null, null, ['id' => 'checkAll'])!!}</th>
				<th class="">Title</th>
				<th class="text-center">Status</th>
				<th class="text-left">Author</th>
				<th class="text-center">Date</th>
				<th class="text-right">Visit/Pageview</th>
				<th class="text-right">ID</th>
			</tr>
		</thead>
		<tbody>
	 		@each('admin.post.row.all', $posts, 'p', 'admin.common.no-data')
	 	</tbody>
	</table>
	<div class="paginationContainer">{!! $posts->links() !!}</div>
	<div class="form-group">
		{!!Form::token()!!}
		{!!Form::hidden('urlUpdateStatus', route('adminPostUpdateStatus'))!!}
		{!!Form::hidden('urlUpdateAll', route('adminPostUpdateAll'))!!}
	</div>
</section>
@endsection