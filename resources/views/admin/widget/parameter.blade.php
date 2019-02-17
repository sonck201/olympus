@foreach ( $params as $p )
<div class="form-group">
	
	@if ( !isset($value) && !empty($p['default']) )
		@php $v = $p['default'] @endphp
	@elseif ( isset($value) && isset($p['name']) && isset($value->$p['name']) )
		@php $v = $value->$p['name'] @endphp
	@else
		@php $v = null @endphp
	@endif
	
	@if ( isset( $p['name'] ) )
	{!! Form::label($p['name'], $p['label']) !!}
	@endif
	
	@if ( $p['type'] == 'spacer' )
	
		@if ( isset($p['label']) ) <div class="text-primary text-center">{{ $p['label'] }}</div> @else <hr /> @endif
	
	@elseif ( $p['type'] == 'text' )
	
		{!! Form::text($p['name'], $v, ['class' => 'form-control hasTooltip', 'title' => $p['description'], 'placeholder' => $p['description']]) !!}
	
	@elseif ( $p['type'] == 'select' )
		
		{!! Form::select($p['name'], [$p['description'] => $p['options']], $v, ['class' => 'form-control hasTooltip', 'title' => $p['description']]) !!}
	
	@elseif ( $p['type'] == 'database' )
	
		@php
		$model = str_replace('/', '\\', $p['model']);
		$class = $p['class'];
		
		$category = $model::$class([
			'lang' => $param->lang,
			'uncategory' => false,
			'select' => ['content.id', 'content.title', 'parent'],
			'where' => ['`status` = "active"']
		]);
		@endphp
		
		@if ( isset($p['multiple']) == true )
		<div class="categoryGroup">
			<ul class="nav nav-tabs" role="tablist">
				@foreach ( $category as $type => $c )
				<li role="presentation" class="{{$type == 'Post' ? 'active' : null}}"><a href="#{{$type}}Category" aria-controls="{{$type}}" role="tab" data-toggle="tab">{{ucfirst($type)}}</a></li>
				@endforeach
			</ul>
			<div class="tab-content">
				@foreach ( $category as $type => $category )
				<div role="tabpanel" class="tab-pane {{$type == 'Post' ? 'active' : null}}" id="{{$type}}Category">
					@foreach( $category as $id => $c )
					<label>{!! Form::checkbox($p['name'] . '[]', $id, (in_array($id, $v)) ? true : false) !!} {{str_limit($c, 70)}}</label>
					@endforeach
				</div>
				@endforeach
			</div>
		</div>
		@else
		{!! Form::select($p['name'], $category, $v, ['class' => 'form-control hasTooltip', 'title' => $p['description']]) !!}
		@endif
	
	@endif
</div>
@endforeach