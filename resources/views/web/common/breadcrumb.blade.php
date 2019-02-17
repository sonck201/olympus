<div class="container">
	<ol class="breadcrumb">
		<li><a href="{{url('/')}}">{{__('Web/global.web.homepage')}}</a></li>
		@php $lastBreadcrumb = (object) array_pop($data) @endphp
		@foreach($data as $b)
		@php $opt = count($param->languages) > 1 ? ['id' => $b->id, 'title' => $b->alias, 'lang' => $param->lang] : ['id' => $b->id, 'title' => $b->alias] @endphp
		<li><a href="{{route($b->route, $opt)}}">{{$b->title}}</a></li>
		@endforeach
		<li class="active">{{$lastBreadcrumb->title}}</li>
	</ol>
</div>