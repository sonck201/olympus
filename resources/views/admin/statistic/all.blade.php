@extends('admin.layout.master')

@section('pageTitle')
{{$titlePage}} | @parent
@endsection

@section('content')
<section id="statistic" class="page">
	<div class="row">
		<div class="col-xs-3">
			<b class="pull-right">Post visit/pageview</b>
		</div>
		<div class="col-xs-3">
			{{$stat->postVisit}}/{{$stat->postPageview}} = <span class="badge">{{round($stat->postVisit/$stat->postPageview*100)}}%</span>
		</div>
		<div class="col-xs-3">
			<b class="pull-right">Category visit/pageview</b>
		</div>
		<div class="col-xs-3">
			{{$stat->categoryVisit}}/{{$stat->categoryPageview}} = <span class="badge">{{round($stat->categoryVisit/$stat->categoryPageview*100)}}%</span>
		</div>
	</div>
	<div class="row">	
		<div class="col-xs-6">
			<div class="groupHidden">
				@foreach ( $stat->visitPage as $vP )
				{!! Form::hidden('visitPageTitle', str_limit($vP->path, 20)) !!}
				{!! Form::hidden('visitPageCount', $vP->count) !!}
				@endforeach
			</div>
			<canvas id="visitPage" width="400" height="400"></canvas>
		</div>
		<div class="col-xs-6">
			<div class="groupHidden">
				@foreach ( $stat->visitIp as $vI )
				{!! Form::hidden('visitIpTitle', str_limit($vI->ip, 20)) !!}
				{!! Form::hidden('visitIpCount', $vI->count) !!}
				@endforeach
			</div>
			<canvas id="visitIp" width="400" height="400"></canvas>
		</div>
	</div>
</section>
@endsection

@section('js')
<script src="{{asset('public/plugins/chartjs/Chart.bundle.min.js')}}"></script>
<script type="text/javascript">
var colorSet = ['#3366CC','#DC3912','#FF9900','#109618','#990099','#3B3EAC','#0099C6','#DD4477','#66AA00','#B82E2E','#316395','#994499','#22AA99','#AAAA11','#6633CC','#E67300','#8B0707','#329262','#5574A6','#3B3EAC'];
var data = {};
$('.page#statistic :input').each(function () {
	inputId = $( this ).prop( 'name' );

	data[inputId] = ( typeof data[inputId] != 'undefined' && data[inputId] instanceof Array ) ? data[inputId] : []
	data[inputId].push( $( this ).val() );
});

new Chart($('#visitPage'), {
    type: 'pie',
    data: {
    	labels: data.visitPageTitle,
    	datasets: [{data: data.visitPageCount, backgroundColor: colorSet}]
    }
});
new Chart($('#visitIp'), {
    type: 'pie',
    data: {
    	labels: data.visitIpTitle,
    	datasets: [{data: data.visitIpCount, backgroundColor: colorSet}]
    }
});
</script>
@endsection