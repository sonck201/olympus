<div class="col-xs-3">
	<div class="thumbnail{{ basename($filename) == basename($active) ? ' has-primary':null }}">
		<img src="{{url($filename)}}" class="img-responsive" />
		<div class="btn-group btn-group-xs">
			<a class="btn btn-success doPrimary" href="{{route('adminPostPrimaryImageBoxHolder')}}"><i class="fa fa-fw fa-check"></i></a>
			<a class="btn btn-info fancybox" href="{{url($filename)}}" data-fancybox="group" rel="galery"><i class="fa fa-fw fa-search"></i></a>
			<a class="btn btn-danger doDelete" href="{{route('adminPostDeleteImageBoxHolder')}}"><i class="fa fa-fw fa-trash"></i></a>
		</div>
	</div>
</div>