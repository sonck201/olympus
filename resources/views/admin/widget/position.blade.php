@extends('admin.layout.master')

@section('pageTitle')
{{$titlePage}} | @parent
@endsection

@section('content')
<section id="widget" class="page">
	<div class="widgetPosition row">
		<div class="col-xs-12">
			<div class="text-danger position clearfix">
				<div class="col-xs-3"><div class="text-danger position">User 1</div></div>
				<div class="col-xs-3"><div class="text-danger position">User 2</div></div>
				<div class="col-xs-3"><div class="text-danger position">User 3</div></div>
				<div class="col-xs-3"><div class="text-danger position">User 4</div></div>
			</div>
		</div>
		<div class="col-xs-10"><div class="text-danger position">Main menu</div></div>
		<div class="col-xs-2"><div class="text-danger position">Search</div></div>
		<div class="col-xs-12"><div class="text-danger position">Banner</div></div>
		<div class="col-xs-12"><div class="text-danger position">Container top</div></div>
		<div class="col-xs-3"><div class="text-danger position">Sidebar left</div></div>
		<div class="col-xs-6">
			<div class="text-danger position clearfix">
				<div class="col-xs-12"><div class="text-danger position">Content top</div></div>
				<div class="col-xs-12"><div class="text-danger position">Main content</div></div>
				<div class="col-xs-12"><div class="text-danger position">Content bottom</div></div>
			</div>
		</div>
		<div class="col-xs-3"><div class="text-danger position">Sidebar right</div></div>
		<div class="col-xs-12"><div class="text-danger position">Container bottom</div></div>
		
		<div class="col-xs-12"><div class="text-danger position">Footer top</div></div>
		<div class="col-xs-12">
			<div class="text-danger position clearfix">
				<div class="col-xs-3"><div class="text-danger position">User 5</div></div>
				<div class="col-xs-3"><div class="text-danger position">User 6</div></div>
				<div class="col-xs-3"><div class="text-danger position">User 7</div></div>
				<div class="col-xs-3"><div class="text-danger position">User 8</div></div>
			</div>
		</div>
		<div class="col-xs-12"><div class="text-danger position">Footer bottom</div></div>
		<div class="col-xs-12"><div class="text-danger position">Copyright</div></div>
	 </div>
</section>
@endsection