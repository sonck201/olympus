<!DOCTYPE html>
<html lang="{{$param->lang}}">
<head>
<title>@section('pageTitle') {{$setting->siteName}} @show</title>
@include('web.layout.meta')
@include('web.layout.css')
</head>
<body>
	<header id="header" class="navbar navbar-inverse yamm">
		<div class="container">
			@include('web.layout.menu')
		</div>
	</header>
	<div id="message" class="animated fadeIn">
		@foreach ($alerts as $a)
			@if( Session::has('message-'. $a) )
			<div class="alert alert-{{$a}}" role="alert"><i class="fa fa-fw fa-lg fa-info-circle"></i> {{Session::get('message-'. $a)}}</div>
			@endif
		@endforeach
	</div>
	<section id="banner">{!! $widget['banner'] or null !!}</section>
	<div id="breadcrumbContainer">@yield('breadcrumb')</div>
	<section id="mainContainer">
		<div class="container">
			<div id="containerTop">{!! $widget['containerTop'] or null !!}</div>
			<div id="mainContent" class="row">
				@if ( isset($widget['sidebarLeft']) )
				<aside id="sidebarLeft" class="{{ isset($widget['sidebarRight']) ? 'col-xs-3' : 'col-xs-4' }}">{!!$widget['sidebarLeft']!!}</aside>
				@endif
				
				<aside id="content" class="{{ isset($widget['sidebarLeft']) && isset($widget['sidebarRight']) ? 'col-xs-6' : null }} {{ !isset($widget['sidebarLeft']) && !isset($widget['sidebarRight']) ? 'col-xs-12' : null }} {{ (isset($widget['sidebarLeft']) && !isset($widget['sidebarRight'])) || (!isset($widget['sidebarLeft']) && isset($widget['sidebarRight'])) ? 'col-xs-8' : null }}">
					@if ( isset($widget['contentTop']) )<div id="contentTop">{!!$widget['contentTop']!!}</div>@endif
					<div id="contentFluid">@yield('content')</div>
					@if ( isset($widget['contentTop']) )<div id="contentBottom">{!!$widget['contentBottom']!!}</div>@endif
				</aside>
				
				@if ( isset($widget['sidebarRight']) )
				<aside id="sidebarRight" class="{{ isset($widget['sidebarLeft']) ? 'col-xs-3' : 'col-xs-4' }}">{!!$widget['sidebarRight']!!}</aside>
				@endif
			</div>
			<div id="containerBottom">{!! $widget['containerBottom'] or null !!}</div>
		</div>
	</section>
	<footer id="footer">
		<div class="container">
			<div id="footerTop">{!! $widget['footerTop'] or null !!}</div>
			<div id="footerContent"><p><i class="fa fa-copyright fa-fw"></i> {{date('Y')}} Company, Inc.</p></div>
			<div id="footerBottom">{!! $widget['footerBottom'] or null !!}</div>
		</div>
	</footer>
	@include('web.layout.js')
</body>
</html>