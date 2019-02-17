@extends('web.layout.master')

@section('content')
<div id="work" class="work-main-block">
	<div class="container">
		<div class="row">
			@foreach($banner as $b)
			<div class="col-md-4 col-sm-6 design">
				<div class="work-block">
					<div class="work-img">
						<img src="{{asset($b->image)}}" class="img-responsive" alt="{{$b->title}}">
						<div class="gradient-overlay"></div>
					</div>
					<div class="work-dtl text-center">
						<a href="#"><h3>{{$b->title}}</h3></a>
					</div>
				</div>
			</div>
			@endforeach
		</div>
	</div>
</div>
@endsection