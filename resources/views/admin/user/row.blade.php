<tr class="user" id="{{$u->id}}">
	<td class="text-center">{!!Form::checkbox('item', null, null, ['id' => $u->id])!!}</td>
	<td class="title">
		<a href="{{route('adminUserEdit', ['id' => $u->id])}}">
			{{isset($u->name) && !empty($u->name) ? $u->name : $u->email}}
			@if( isset($u->name) && !empty($u->name) )<small class="text-muted">{!! $u->email !!}</small>@endif
		</a>
	</td>
	<td class="status">@include('admin.common.status', ['status' => $u->status])</td>	 			
	<td class="text-left">{{ $u->title }}</td>
	<td class="text-center date">
		@if ( !is_null($u->logged_at) ) <small class="hasTooltip" title="Logged at">{{ date('y-m-d H:i', strtotime($u->logged_at)) }}</small><br /> @endif
		@if ($u->logged_at != $u->created_at) <small class="hasTooltip" title="Created at">{{ date('y-m-d H:i', strtotime($u->created_at)) }}</small><br /> @endif
		<small class="hasTooltip hidden" title="Updated at">{{ date('y-m-d H:i:s', strtotime($u->logged_at)) }}</small>
	</td>
	<td class="text-right">{{$u->id}}</td>
</tr>