<div class="bannerItem col-xs-12 col-sm-6 col-md-4">
	<div class="thumbnail">
		@php $img = asset(file_exists($p->image) ? $p->image : 'images/dummy.jpg') @endphp
		<a href="{{$img}}" data-fancybox="images" data-caption="{{$p->title}}"><img src="{{$img}}" class="img-responsive" title="{{$p->title}}" alt="{{$p->title}}" /></a>
		<div class="bannerTitle">{{$p->title}}</div>
	</div>
</div>