<div class="postItem row col-xs-12 clearfix">
	<div class="col-xs-4 postImage"><img src="{{asset(file_exists($p->image) ? $p->image : 'public/images/dummy.jpg')}}" class="img-responsive img-thumbnail" /></div>
	<div class="col-xs-8 postDetail">
		@php $opt = count($param->languages) > 1 ? ['id' => $p->id, 'title' => $p->alias, 'lang' => $param->lang] : ['id' => $p->id, 'title' => $p->alias] @endphp
		<a href="{{route('post', $opt)}}">{{$p->title}}</a>
		{!! strip_tags(explode('<p><!-- pagebreak --></p>', $p->content)[0], '<p><div>') !!}
	</div>
</div>