@extends('admin.layout.master')

@section('pageTitle')
{{$titlePage}} | @parent
@endsection

@section('content')
<section id="user" class="page">
	@include('admin.common.filter-table', ['keyword' => true, 'role' => true, 'status' => true, 'date' => true, 'updated' => true, 'logged' => true])
	<table class="table table-bordered table-condensed table-hover table-responsive table-striped tableList">
		<thead>
			<tr>
				<th>{!!Form::checkbox('checkAll', null, null, ['id' => 'checkAll'])!!}</th>
				<th class="col-xs-6">Name — Email</th>
				<th class="text-center">Status</th>
				<th class="text-left">Group</th>
				<th class="text-center">Logged time</th>
				<th class="text-right">ID</th>
			</tr>
		</thead>
		<tbody>
	 		@each('admin.user.row', $users, 'u', 'admin.common.no-data')
	 	</tbody>
	</table>
	<div class="paginationContainer">
		{!! $users->links() !!}
	</div>
	<div class="form-group">
		{!!Form::token()!!}
		{!!Form::hidden('urlUpdateStatus', Url::route('adminUserUpdateStatus'))!!}
		{!!Form::hidden('urlUpdateAll', Url::route('adminUserUpdateAll'))!!}
	</div>
</section>
@endsection