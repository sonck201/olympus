<!DOCTYPE html>
<html lang="vi">
<head>
<title>@section('pageTitle') {{$setting->siteName}} @show</title>
<meta name="robots" content="index, folow">
<meta charset="utf-8">
<link href="{{asset('public/templates/'. $setting->adminTemplate .'/favicon.ico')}}" rel="icon" type="image/x-icon" />
<link href="{{asset('public/assets/css/bootstrap.min.css')}}" media="screen" rel="stylesheet" type="text/css" />
<link href="{{asset('public/assets/css/font-awesome.min.css')}}" media="screen" rel="stylesheet" type="text/css" />
<link href="{{asset('public/assets/css/animate.min.css')}}" media="screen" rel="stylesheet" type="text/css" />
@yield('css')
<link href="{{asset('public/templates/'. $setting->adminTemplate .'/css/style.css')}}" media="screen" rel="stylesheet" type="text/css" />
</head>
<body>
	<nav id="navbarTop" class="navbar navbar-inverse navbar-fixed-top">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				@for($i=0; $i<3; $i++)
				<span class="icon-bar"></span>
				@endfor
				</button>
				<a class="navbar-brand"><img src="{{asset('public/templates/'. $setting->adminTemplate .'/images/logo.png')}}" alt="Wargon CMS" class="" /> Wargon CMS</a>
        	</div>
	        <div id="navbar" class="navbar-collapse collapse">
	        	@include('admin.layout.navbar')
	        </div>
		</div>
    </nav>
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-2 sidebar">
				@include('admin.layout.sidebar')
			</div>
			<div class="col-xs-10 col-xs-offset-2 main">
				<h1 class="page-header">{!! $titlePage !!}<small>{!! isset($titlePageExtra) ? " $titlePageExtra":null !!}</small></h1>
				<div id="message" class="animated fadeIn">
					@foreach ($alerts as $a)
						@if( Session::has('message-'. $a) )
						<div class="alert alert-{{$a}}" role="alert"><i class="fa fa-fw fa-lg fa-info-circle"></i> {{Session::get('message-'. $a)}}</div>
						@endif
					@endforeach
				</div>
				@yield('content')
			</div>
		</div>
	</div>

	<script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('public/assets/js/bootstrap.min.js')}}"></script>
	<script>var siteurl = '{{URL::to("/")}}/', lang = '{{$param->lang}}', siteuri = '{{URL::to("/") ."/admin". (count($param->languages) > 1 ? '/' . $param->lang : null)}}', controller = '{{$param->controller}}', action = '{{$param->action}}', type = '{{$param->type}}';</script>
	@yield('js')
	<script src="{{asset('public/templates/'. $setting->adminTemplate .'/js/core.js')}}"></script>
</body>
</html>