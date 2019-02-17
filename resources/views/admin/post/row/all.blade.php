<tr class="category" id="{{$p->id}}">
	<td class="text-center">{!!Form::checkbox('item', null, null, ['id' => $p->id])!!}</td>
	<td class="title">
		<a href="{{route('adminPostEdit', ['id' => $p->id])}}">
			@if ( $p->format == 'image' ) <i class="fa fa-file-image-o"></i> @endif
			{{ str_limit($p->pTitle, 80) }}
			({{count(glob(public_path('images/post/'. $p->id .'/*')))}})
		</a>
	</td>
	<td class="status">@include('admin.common.status', ['status' => $p->status])</td>	 			
	<td class="text-left">{!! ( empty($p->name) ? $p->email : $p->name) !!}</td>
	<td class="text-center date">{!! date('y-m-d', strtotime($p->created_at)) !!}</td>
	<td class="text-right">
		<span class="pull-left badge">{{number_format($p->visit/$p->pageview*100)}}%</span>
		{{$p->visit}} / {{$p->pageview}}
	</td>
	<td class="text-right">{{$p->id}}</td>
</tr>