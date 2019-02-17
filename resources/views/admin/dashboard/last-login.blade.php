<div class="col-xs-4">
	<div class="thumbnail">
		<div class="caption">
			<h3>
				<a href="{{ route('adminUserEdit', ['id' => $u->id]) }}">{{ str_limit(!empty($u->name) ? $u->name : $u->email, 30) }}</a>
			</h3>
			<div class="clearfix">
				<small class="pull-left"><i class="fa fa-users"></i> {{$u->roleTitle}}</small>
				<small class="pull-right"><i class="fa fa-calendar"></i> {{$u->loginedAt}}</small>
			</div>
		</div>
	</div>
</div>