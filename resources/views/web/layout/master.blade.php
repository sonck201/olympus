<!DOCTYPE html>
<html lang="{{$param->lang}}">
<head>
<title>@section('pageTitle') {{$setting->siteName}} @show</title>
@include('web.layout.meta')
@include('web.layout.css')
</head>
<body data-spy="scroll" data-target=".navbar-default">
	
	<div class="preloader">
		<div class="status">
			<div class="status-message">
				<h1>Thái Sơn Olympus</h1>
			</div>
		</div>
	</div>
	
	<nav class="navbar navbar-default navbar-fixed-top yamm">
		<div class="container">
			@include('web.layout.menu')
		</div>
	</nav>
	
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
		<div id="containerTop">{!! $widget['containerTop'] or null !!}</div>
		<div id="mainContent">
			<div class="container">
				<div class="row">
					@if ( isset($widget['sidebarLeft']) )
					<aside id="sidebarLeft" class="{{ isset($widget['sidebarRight']) ? 'col-xs-12 col-sm-3' : 'col-xs-12 col-sm-4' }}">{!!$widget['sidebarLeft']!!}</aside>
					@endif
					
					<aside id="content" class="{{ isset($widget['sidebarLeft']) && isset($widget['sidebarRight']) ? 'col-xs-12 col-sm-6' : null }} {{ !isset($widget['sidebarLeft']) && !isset($widget['sidebarRight']) ? 'col-xs-12' : null }} {{ (isset($widget['sidebarLeft']) && !isset($widget['sidebarRight'])) || (!isset($widget['sidebarLeft']) && isset($widget['sidebarRight'])) ? 'col-xs-12 col-sm-8' : null }}">
						@if ( isset($widget['contentTop']) )<div id="contentTop">{!!$widget['contentTop']!!}</div>@endif
						<div id="contentFluid">@yield('content')</div>
						@if ( isset($widget['contentTop']) )<div id="contentBottom">{!!$widget['contentBottom']!!}</div>@endif
					</aside>
					
					@if ( isset($widget['sidebarRight']) )
					<aside id="sidebarRight" class="{{ isset($widget['sidebarLeft']) ? 'col-xs-12 col-sm-3' : 'col-xs-12 col-sm-4' }}">{!!$widget['sidebarRight']!!}</aside>
					@endif
				</div>
			</div>
		</div>
		<div id="containerBottom">{!! $widget['containerBottom'] or null !!}</div>
	</section>
	
	<div id="footer-section" class="footer-main-block">
		<div class="container">
			<div class="row copyright-block">
				<div class="col-xs-12 col-sm-6">
					<div class="copyright">
						<div class="footer-logo">
							<img src="{{asset('public/templates/'. $setting->webTemplate .'/images/logo-footer.png')}}" class="img-responsive" alt="logo">
						</div>
						<p>
							&copy; Công ty TNHH Thái Sơn Olympus 2017<br />
						</p>
					</div>
				</div>
				<div class="hidden-xs col-sm-6">
					<div class="embed-responsive embed-responsive-4by3">
						<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fdiadieminan%2F&tabs=messages&width=585&height=300&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" class="embed-responsive-item" width="585" height="300" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
					</div>
				</div>
				<div class="visible-xs col-xs-12">
					<iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2Fdiadieminan%2F&tabs=messages&width=380&height=300&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=true&appId" class="embed-responsive-item" width="380" height="300" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true"></iframe>
				</div>
			</div>
		</div>
	</div>
	@include('web.layout.js')
</body>
</html>