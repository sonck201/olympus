<script src="{{asset('public/assets/js/bootstrap.min.js')}}"></script>
<script>var siteurl = '{{URL::to("/")}}/', lang = '{{$param->lang}}', siteuri = '{{URL::to("/")}}/{{count($param->languages) > 1 ? '/' . $param->lang : ''}}', controller = '{{$param->controller}}', action = '{{$param->action}}', id = '{{$param->id}}';</script>
@yield('js')
<script src="{{asset('public/templates/'. $setting->webTemplate .'/js/core.js')}}"></script>