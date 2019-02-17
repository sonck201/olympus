@extends('admin.layout.master')

@section('pageTitle')
{{$titlePage}} | @parent
@endsection

@section('content')
<section id="setting" class="page">
	{!!Form::open()!!}
		<div role="tabpanel">
			<ul class="nav nav-tabs" role="tablist">
				<li role="presentation" class="active"><a href="#global" aria-controls="global" role="tab" data-toggle="tab">Global</a></li>
				<li role="presentation"><a href="#image" aria-controls="image" role="tab" data-toggle="tab">Image</a></li>
				<li role="presentation" class="hidden"><a href="#product" aria-controls="product" role="tab" data-toggle="tab">Product</a></li>
				<li role="presentation"><a href="#mail" aria-controls="mail" role="tab" data-toggle="tab">Mail</a></li>
			</ul>
			<div class="tab-content">
				<div role="tabpanel" class="tab-pane fade in active" id="global">
					@include('admin.setting.globalForm')
				</div>
				<div role="tabpanel" class="tab-pane fade" id="image">
					@include('admin.setting.imageForm')
				</div>
				<div role="tabpanel" class="tab-pane fade" id="product">Updating...</div>
				<div role="tabpanel" class="tab-pane fade" id="mail">
					@include('admin.setting.mailForm')
				</div>
			</div>
		</div>
		{!!Form::hidden('urlUpdate', route('adminSettingUpdate'), array('id' => 'urlUpdate'))!!}
	{!!Form::close()!!}
</section>
@endsection