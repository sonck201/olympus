<div class="row">
	<div class="col-xs-8">
		<ul class="nav nav-tabs" role="tablist">
			@foreach($param->languages as $k => $lang)
			<li role="presentation" class="{{ $k == 0 ? 'active' : null }}">
				<a href="#{{$lang->code}}" aria-controls="{{$lang->code}}" role="tab" data-toggle="tab">
					<img src="{{asset('public/assets/images/flag/'. $lang->code .'.jpg')}}" />
				</a>
			</li>
			@endforeach
		</ul>
		<div class="tab-content">
			@foreach($param->languages as $k => $lang)
			<div role="tabpanel" class="tab-pane {{ $k == 0 ? 'active' : null }}" id="{{$lang->code}}">
				<div class="form-group">
					{!! Form::label('title'. strtoupper($lang->code), 'Title') !!}
					{!! Form::text('title'. strtoupper($lang->code), isset($post->data[$lang->code]->title) ? $post->data[$lang->code]->title : null, ['class' => 'form-control input-lg', 'placeholder' => 'Input title']) !!}
				</div>
				<div class="form-group">
					{!! Form::label('content'. strtoupper($lang->code), 'Content') !!}
					{!! Form::textarea('content'. strtoupper($lang->code), isset($post->data[$lang->code]->content) ? $post->data[$lang->code]->content : null, ['class' => 'form-control tinymce content']) !!}
				</div>
			</div>
			@endforeach
		</div>
	</div>
	<div class="col-xs-4">
		<div id="extraFormat" style="display: none"></div>
		
		<div class="form-group">
			{!! Form::label('status', 'Publish') !!}
			{!! Form::select('status', ['— Select status —' => ['active' => 'Publish', 'deactive' => 'Unpublish', 'trash' => 'Trash']], isset($post->status) ? $post->status : null, ['class' => 'form-control']) !!}
		</div>
		
		<div class="form-group">
			{!! Form::label('created_at', 'Created at') !!}
			<div class="input-group date" id="datetimepicker">
				{!! Form::text('created_at', isset($post->created_at) ? $post->created_at : date('Y-m-d H:i:s'), ['class' => 'form-control', 'placeholder' => date('Y-m-d')]) !!}
				<span class="input-group-addon">
					<i class="fa fa-fw fa-calendar"></i>
				</span>
			</div>
		</div>
		
		<div class="form-group categoryGroup">
			{!! Form::label('category', 'Category') !!}
			<div>
				<ul class="nav nav-tabs" role="tablist">
					@foreach ( $categories as $type => $c )
					<li role="presentation" class="{{$type == 'Post' ? 'active' : null}}"><a href="#{{$type}}Category" aria-controls="{{$type}}" role="tab" data-toggle="tab">{{ucfirst($type)}}</a></li>
					@endforeach
				</ul>
				<div class="tab-content">
					@foreach ( $categories as $type => $category )
					<div role="tabpanel" class="tab-pane {{$type == 'Post' ? 'active' : null}}" id="{{$type}}Category">
						@foreach( $category as $id => $c )
						<label>{!! Form::checkbox('category[]', $id, (isset($post->category) && in_array($id, explode(',', $post->category)) ? true : false)) !!} {{str_limit($c, 40)}}</label>
						@endforeach
					</div>
					@endforeach
				</div>
			</div>
		</div>
		
		<div class="form-group">
			{!! Form::label('tag', 'Tag') !!}
			<div class="input-group">
				{!! Form::text('tag', isset($post->tag) ? $post->tag : null, ['class' => 'form-control', 'placeholder' => 'Tag keyword. Separate by ,']) !!}
				<span class="input-group-addon">
					<i class="fa fa-fw fa-tag"></i>
				</span>
			</div>
		</div>
		
	</div>
</div>