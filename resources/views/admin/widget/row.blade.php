<tr class="widget" id="{{$w->id}}">
	<td class="text-center">{!!Form::checkbox('item', null, null, ['id' => $w->id])!!}</td>
	<td class="title">
		<a href="{{$w->id != 100 ? route('adminWidgetEdit', ['id' => $w->id]) : null}}">{{ str_limit($w->title, 100) }}</a>
	</td>
	<td class="status">@include('admin.common.status', ['status' => $w->status])</td>
	<td class="text-center priority">@include('admin.common.priority', ['priority' => $w->priority, 'min' => $w->min, 'max' => $w->max])</td>
	<td>{{ $w->position }}</td>
	<td>{{ studly_case($w->type) }}</td>
	<td class="text-right">{{$w->id}}</td>
</tr>