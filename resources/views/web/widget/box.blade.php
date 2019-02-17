@php $config = json_decode($widget->param) @endphp
<div id="widget{{$widget->id}}" class="panel panel-default widget {{$config->class_sfx}}">
	@if ( $widget->show_title == "yes" )<div class="panel-heading"><h3 class="panel-title">{{$widget->title}}</h3></div>@endif
	
	@if ( $widget->show_content == "yes" && !empty($widget->content) )
	<div class="panel-body">{!! preg_replace('/(src="\/public)/i', 'src="'. asset('/public'), $widget->content) !!}</div>
	@endif
	
	@includeIf('web.widget.'. $widget->type .'.main', ['widget' => $widget, 'config' => $config])
</div>