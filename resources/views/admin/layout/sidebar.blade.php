<ul class="nav nav-pills nav-stacked">
	@if ( count($mainMenu) > 0 )
	@foreach ( $mainMenu as $m )
	<li class="dropdown {{ $m->zone }} {{ isset($m->class) ? $m->class : null }}">
		@if ( !isset($m->dropdown) )
			@if ( isset($accessiblePlace) && in_array($m->zone, $accessiblePlace) )
			<a href="{{ $m->href }}" id="{{ $m->id }}" class="">{!! isset($m->icon) ? "<i class='fa fa-fw fa-$m->icon'></i>":null !!} {{ $m->text }}</a>
			@endif
		@else
			@if ( isset($accessiblePlace) && in_array($m->zone, $accessiblePlace) )
			<a>{!! isset($m->icon) ? "<i class='fa fa-fw fa-$m->icon'></i>":null !!} {{ $m->text }}</a>
			@if ( count($m->dropdown) > 0 )
			<ul class="" role="menu">
				@foreach ( $m->dropdown as $sm )
				
				@if ( isset($sm->showDividerBefore) && $sm->showDividerBefore == true )
				<li class="divider {{ isset($sm->class) ? $sm->class : null }}"></li>
				@endif
				
				@if ( isset($accessiblePlace) && in_array($sm->zone, $accessiblePlace) )
				<li class="{{ isset($sm->class) ? $sm->class : null }}"><a href="{{ $sm->href != '#' ? $sm->href : '#' }}" id="{{ $sm->id }}">{{ $sm->text }}</a></li>
				@endif
				
				@if ( isset($sm->showDividerAfter) && $sm->showDividerAfter == true )
				<li class="divider {{ isset($sm->class) ? $sm->class : null }}"></li>
				@endif
				
				@endforeach
			</ul>
			@endif
			@endif
		@endif
	</li>
	@endforeach
	@endif
</ul>