<div class="hidden navbar-text titlePage {{ isset($titlePageExtra) ? 'titlePageExtra':null }}">
	<div>{!! $titlePage !!}</div>
	{!! isset($titlePageExtra) ? "<span>$titlePageExtra</span>":null !!}
</div>
<div class="navbar-text btnControl btn-group">{!!isset($btnControl) ? $btnControl:null!!}</div>
<ul class="nav navbar-nav navbar-right">
	<li><a><i class="fa fa-fw fa-users"></i> <span class="badge">{{$userOnline}}</span></a></li>
    <li><a><i class="fa fa-fw fa-code"></i> <span class="badge">{{$cmsVersion}}</span></a></li>
	<li><a href="{{route('adminUserProfile')}}" id="userProfile"><i class="fa fa-fw fa-user"></i> {{auth()->user()->name}}</a></li>
    <li class="dropdown">
    	<a href="#"><i class="fa fa-cog"></i><span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
        	<li><a href="{{URL::to('/')}}" target="_blank"><i class="fa fa-fw fa-external-link"></i> View site</a></li>
        	<li><a href="{{route('adminClearCache')}}"><i class="fa fa-fw fa-refresh"></i> Clear cache</a></li>
        	<li><a href="{{route('adminAuthLogout')}}"><i class="fa fa-fw fa-sign-out"></i> Logout</a></li>
		</ul>
	</li>
</ul>