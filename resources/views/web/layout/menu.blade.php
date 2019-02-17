<div class="navbar-header">
	<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
		<span class="sr-only">Toggle navigation</span>
		@for($i=0; $i<3; $i++)
		<span class="icon-bar"></span>
		@endfor
	</button>
	<a class="navbar-brand" href="{{url('/')}}"><img src="{{asset('public/templates/'. $setting->webTemplate .'/images/logo.png')}}" alt="{{$setting->siteName}}" height="100"></a>
</div>
<div id="navbar" class="collapse navbar-collapse navbar-right">
	<ul class="nav navbar-nav">
		@if ( count($menu) > 0 )
		@foreach ($menu as $m)

		@if ($m->level == 0 )
		<li class="dropdown">
			<a href="{{$m->href}}" id="{{$m->nameId . $m->data}}" @if ( isset($m->children) && count($m->children) > 0 )class="dropdown-toggle" data-toggle="dropdown"@endif>{{$m->title}}</a>
			@if ( isset($m->children) && count($m->children) > 0 )
			<ul class="dropdown-menu animated animated2x fadeDown" style="width: {{$m->width_column}}px">
				@if ($m->max_column == 1 )
					@foreach ( $m->children as $f1 )
					<li><a href="{{$f1->href}}" id="{{$f1->nameId . $f1->data}}">{{$f1->title}}</a></li>
					@endforeach
				@else
				<li>
					<div class="yamm-content">
						<div class="row">
							@foreach($m->children as $f1)
							<ul class="list-group column-content col-xs-{{round(12 / $m->max_column)}}">
								@if( $f1->show_title == 'yes' )
								<li class="list-group-item list-group-item-heading"><a href="{{$f1->href}}" id="{{$f1->nameId . $f1->data}}">{{$f1->title}}</a></li>
								@endif
								
								@if ( isset($f1->children) && count($f1->children) > 0 )
								@foreach($f1->children as $f2)
								<li class="list-group-item"><a href="{{$f2->href}}" id="{{$f2->nameId . $f2->data}}">{{$f2->title}}</a></li>
								@endforeach
								@else
								<li class="list-group-item">No menu item</li>
								@endif
							</ul>
							@if (($loop->iteration % $m->max_column) == 0 && $loop->iteration != $loop->count) </div><div class="row"> @endif
							@endforeach
						</div>
					</div>
				</li>
				@endif
			</ul>
			@endif
		</li>
		@endif
		
		@endforeach
		@else
		<li>No data</li>
		@endif
	</ul>
</div>