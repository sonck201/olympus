<div class="wrapping">
	<h3 class="h3 text-center">{{$title}} data</h3>
	@if ( count($data) > 0 )
	<table class="table table-bordered table-condensed table-hover table-responsive table-striped tableGetData">
		<thead>
			<tr>
				<th>Title</th>
				<th class="text-right">ID</th>
			</tr>
		</thead>
		<tbody>
			@include('admin.menu.get-data-row', $data)
		</tbody>
		@if ( $showMore == true )
		<tfoot>
			<tr>
				<td colspan="2"><a href="#" class="btn btn-block btn-primary btnLoadMoreMenuData">More</a></td>
			</tr>
		</tfoot>
		@endif
	</table>
	{!! Form::hidden('appPage', $appPage, ['id' => 'appPage']) !!}
	@else
	No data... Please add data first!
	@endif
</div>