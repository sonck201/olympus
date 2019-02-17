<link href="{{asset('public/templates/'. $setting->webTemplate .'/favicon.ico')}}" rel="icon" type="image/x-icon" />
<link rel="canonical" href="{{url('/')}}"/>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<meta name="description" content="@section('pageDescription') {{$setting->siteDescription}} @show" />
<meta name="keywords" content="@section('pageKeyword') {{$setting->siteKeyword}} @show"/>
<meta name="revisit-after" content="1 day" />
<meta name="robots" content="index, folow">

<meta itemprop="name" content="@section('pageTitle') {{$setting->siteName}} @show">
<meta itemprop="description" content="@section('pageDescription') {{$setting->siteDescription}} @show">
<meta itemprop="image" content="@section('pageImage') {{asset('public/templates/'. $setting->webTemplate .'/images/logo.png')}} @show">

<meta property="og:title" content="@section('pageTitle') {{$setting->siteName}} @show" /> 
<meta property="og:locale" content="vi_VN" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{{url('/')}}" /> 
<meta property="og:image" content="@section('pageImage') {{asset('public/templates/'. $setting->webTemplate .'/images/logo.png')}} @show" />
<meta property="og:description" content="{{$setting->siteDescription}}" /> 
<meta property="og:site_name" content="{{$setting->siteName}}" />