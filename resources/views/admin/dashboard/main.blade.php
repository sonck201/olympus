@extends('admin.layout.master')

@section('content')
<section id="dashboard" class="page">
	<div class="row">
		<h2 class="col-xs-12 sub-header"><a href="{{route('adminUser', ['logged_at' => 'desc'])}}">Last logged</a></h2>
		@each('admin.dashboard.last-login', $recentUser, 'u', 'admin.common.no-data')
	</div>
	<div class="row">
		<div class="col-xs-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title text-uppercase"><a href="{{route('adminPost')}}">Lastest posts</a></h3>
				</div>
				<div class="list-group">
					@each('admin.dashboard.last-post', $latestPost, 'p', 'admin.common.no-data')
				</div>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title text-uppercase"><a href="{{route('adminPost', ['visit' => 'desc'])}}">Popular posts</a></h3>
				</div>
				<div class="list-group">
					@each('admin.dashboard.popular-post', $popularPost, 'p', 'admin.common.no-data')
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<h2 class="col-xs-12 sub-header">Statistic</h2>
		<div class="col-xs-3"><i class="fa fa-fw fa-code"></i> PHP <span class="badge pull-right">{{phpversion()}}</span></div>
		<div class="col-xs-3"><i class="fa fa-fw fa-database"></i> Mysql <span class="badge pull-right">{{$stat->mySqlVersion}}</span></div>
		<div class="col-xs-3"><i class="fa fa-fw fa-flash"></i> Cache time <span class="badge pull-right">{{$setting->cacheExpire}}m</span></div>
		<div class="col-xs-3"><i class="fa fa-fw fa-key"></i> Session time <span class="badge pull-right">{{$setting->sessionExpire}}m</span></div>
		<div class="col-xs-3"><i class="fa fa-fw fa-users"></i> Users <span class="badge pull-right">{{$stat->user}}</span></div>
		<div class="col-xs-3"><i class="fa fa-fw fa-files-o"></i> Post <span class="badge pull-right">{{$stat->post}}</span></div>
		<div class="col-xs-3"><i class="fa fa-fw fa-eye"></i> Visit / Pageview <span class="badge pull-right">{{$stat->postVisit}} / {{$stat->postPageview}}</span></div>
		<div class="col-xs-3"><i class="fa fa-fw fa-percent"></i> CTR <span class="badge pull-right">{{number_format($stat->postVisit/$stat->postPageview * 100, 1)}}%</span></div>
	</div>
</section>
@endsection

@section('css')
<style>
	h1.page-header {display: none}
</style>
@endsection