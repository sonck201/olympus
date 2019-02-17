@if ( $title == 'Post' )
	@foreach ( $data as $p )
	<tr>
		<td>
			<a href="#" class="btnChooseId" id="{{ $p->id }}">
				@if ( $p->format == 'image' )
				<i class="fa fa-image"></i>
				@endif
				{{ $p->title }}
			</a>
		</td>
		<td class="text-right">{{ $p->id }}</td>
	</tr>
	@endforeach
@elseif ( $title == 'Category' )
	@foreach ( $data as $type => $category )
		<tr><td class="text-center text-danger" colspan="2"><b>{{ ucfirst($type) }}</b></td></tr>
		@foreach ( $category as $id => $c )
		<tr>
			<td><a href="#" class="btnChooseId" id="{{ $id }}">{{ $c }}</a></td>
			<td class="text-right">{{ $id }}</td>
		</tr>
		@endforeach
	@endforeach
@else
	<tr><td colspan="2">Undefined format!</td></tr>
@endif