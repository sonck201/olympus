<link href="{{asset('public/assets/css/bootstrap.min.css')}}" media="screen" rel="stylesheet" type="text/css" />
<link href="{{asset('public/assets/css/font-awesome.min.css')}}" media="screen" rel="stylesheet" type="text/css" />
<link href="{{asset('public/assets/css/animate.min.css')}}" media="screen" rel="stylesheet" type="text/css" />

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<link href="{{asset('public/templates/'. $setting->webTemplate .'/css/ie10-viewport-bug-workaround.css')}}" rel="stylesheet">
<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

@yield('css')
<link href="{{asset('public/templates/'. $setting->webTemplate .'/css/style.css')}}" media="screen" rel="stylesheet" type="text/css" />

<script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('public/assets/js/jquery-migrate.min.js')}}"></script>