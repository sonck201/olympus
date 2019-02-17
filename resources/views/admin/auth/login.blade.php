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
<link href="{{asset('public/templates/'. $setting->adminTemplate .'/css/style.css')}}" media="screen" rel="stylesheet" type="text/css" />
</head>
<body class="authLogin">
	<section id="container">
		<div class="container">
			<div id="message" class="animated fadeIn"></div>
			<section class="page animated fadeIn">
				<div class="form-group">
					<a href="{{route('homepage')}}" class="center-block text-center" target="_blank"><img src="{{asset('public/templates/'. $setting->adminTemplate .'/images/logo.png')}}" height="100" /></a>
				</div>
				{!! Form::open() !!}
				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
					{!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
				</div>
				
				<div class="form-group input-group">
					<span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
					{!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
				</div>
				
				<div class="form-group">
					{!! Form::submit('Login', ['class' => 'btn btn-primary btn-block']) !!}
				</div>
				{!! Form::close() !!}
			</section>
		</div>
	</section>
	<script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
	<script src="{{asset('public/assets/js/bootstrap.min.js')}}"></script>
	<script>var siteurl = '{{URL::to("/")}}/', lang = '{{$param->lang}}', siteuri = '{{URL::to("/")}}/admin{{count($param->languages) > 1 ? '/' . $param->lang : ''}}', controller = '{{$param->controller}}', action = '{{$param->action}}', type = '{{$param->type}}';</script>
	<script src="{{asset('public/templates/'. $setting->adminTemplate .'/js/login.js')}}"></script>
	<script src="{{asset('public/templates/'. $setting->adminTemplate .'/js/core.js')}}"></script>
</body>
</html>