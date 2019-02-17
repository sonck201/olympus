@extends('admin.layout.master')

@section('pageTitle')
{!!$titlePage!!} | @parent
@endsection

@section('content')
<section id="menu" class="page row">
	{!! Form::open( ['route' => ['adminMenuUpdate'], 'class' => 'validate col-xs-10 col-xs-offset-1 row'] ) !!}
		<div class="col-xs-6">
			<div class="page-header"><h2>Detail <small class="pull-right"><a href="{{$param->action == 'add' ? route('adminMenuAdd') : route('adminMenuEdit', ['id' => $menu->id, 'type' => 'choose-type'])}}" class="btn btn-danger">Change type</a></small></h2></div>
			@foreach($param->languages as $lang)
			<div class="form-group">
				{!!Form::label('title'. strtoupper($lang->code), 'Title '. strtoupper($lang->code))!!}
				<div class="input-group">
					{!!Form::text('title'. strtoupper($lang->code), isset($menu->content[$lang->code]->title) ? $menu->content[$lang->code]->title : null, ['class' => 'form-control input-lg', 'placeholder' => 'Input title'])!!}
					<span class="input-group-addon">
						<img src="{{asset('public/assets/images/flag/'. $lang->code .'.jpg')}}" />
					</span>
				</div>
			</div>
			@endforeach
			<div class="form-group">
				{!! Form::label('parent', 'Parent') !!}
				@if ( $param->action == 'edit' )
				{!! Form::select('parent', $menus, isset($menu->parent) ? $menu->parent : null, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
				@else
				{!! Form::select('parent', $menus, isset($menu->parent) ? $menu->parent : null, ['class' => 'form-control']) !!}
				@endif
			</div>
			<div class="form-group">
				{!! Form::label('status', 'Status') !!}
				{!! Form::select('status', ['active' => 'Active', 'deactive' => 'Deactive'], isset($menu->status) ? $menu->status : null, ['class' => 'form-control']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('open_in', 'Onclick - Open in') !!}
				{!! Form::select('open_in', ['_self' => 'In same window', '_blank' => 'In different window'], isset($menu->open_in) ? $menu->open_in : null, ['class' => 'form-control']) !!}
			</div>
		</div>
		<div class="col-xs-6">
			<div class="page-header"><h2>Parameter</h2></div>
			@if ( isset($typeDetail->showData) && $typeDetail->showData == true )
			<div class="form-group">
				{!! Form::label('data', 'Data') !!}
				<div class="{{ $typeDetail->alias != 'url' ? 'input-group' : null }}">
					@if ( $typeDetail->alias != 'url' )
					{!! Form::text('data', isset($menu->data) ? $menu->data : null, ['class' => 'form-control', 'placeholder' => 'Get info from database']) !!}
					<span class="input-group-btn">{!! Form::button('Get', ['class' => 'btn btn-primary btnGetData']) !!}</span>
					@else
					{!! Form::text('data', isset($menu->data) ? $menu->data : null, ['class' => 'form-control', 'placeholder' => 'Enter external url']) !!}
					@endif
				</div>
			</div>
			@endif
			<div class="form-group">
				{!! Form::label('class', 'Class') !!}
				{!! Form::text('class', isset($menu->class) ? $menu->class : null, ['class' => 'form-control', 'placeholder' => 'Add specific class to menu item']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('width_column', 'Width column') !!}
				{!! Form::text('width_column', isset($menu->width_column) ? $menu->width_column : 200, ['class' => 'form-control', 'placeholder' => 'Menu column width']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('max_column', 'Max column') !!}
				{!! Form::text('max_column', isset($menu->max_column) ? $menu->max_column : 1, ['class' => 'form-control', 'placeholder' => 'Max column in mega menu']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('show_title', 'Show title') !!}
				{!! Form::select('show_title', ['yes' => 'Yes', 'no' => 'No'], isset($menu->show_title) ? $menu->show_title : null, ['class' => 'form-control']) !!}
			</div>
		</div>
		<div class="col-xs-12">
			{!!Form::hidden('id', isset($menu->id) ? $menu->id : null, ['id' => 'id'])!!}
			{!!Form::hidden('urlUpdate', route('adminMenuUpdate'), ['id' => 'urlUpdate'])!!}
			{!!Form::hidden('urlAll', route('adminMenu'), ['id' => 'urlAll'])!!}
			{!!Form::hidden('urlNew', route('adminMenuAdd'), ['id' => 'urlAdd'])!!}
			
			{!!Form::hidden('appTitle', $typeDetail->label, ['id' => 'appTitle'])!!}
			{!!Form::hidden('urlGetData', route('adminMenuGetData'), ['id' => 'urlGetData'])!!}
			{!!Form::hidden('urlGetDataMore', route('adminMenuGetDataMore'), ['id' => 'urlGetDataMore'])!!}
			{!!Form::hidden('type', $typeDetail->alias, ['id' => 'type'])!!}
			
			@if ( isset($typeDetail->appModel) ) {!!Form::hidden('appModel', $typeDetail->appModel, ['id' => 'appModel'])!!} @endif
			@if ( isset($typeDetail->appClass) ) {!!Form::hidden('appClass', $typeDetail->appClass, ['id' => 'appClass'])!!} @endif
			@if ( isset($typeDetail->appType) ) {!!Form::hidden('appType', $typeDetail->appType, ['id' => 'appType'])!!} @endif
			@if ( isset($typeDetail->appPrefix) ) {!!Form::hidden('appPrefix', $typeDetail->appPrefix, ['id' => 'appPrefix'])!!} @endif
			
			@if ( isset($typeDetail->route) ) {!!Form::hidden('route', $typeDetail->route, ['id' => 'route'])!!} @endif
			@if ( $param->action == 'edit' ) {!!Form::hidden('urlEdit', route('adminMenuEdit', ['id' => $menu->id, 'type' => Route::input( 'type' )]), ['id' => 'urlEdit'])!!} @endif
		</div>
	{!!Form::close()!!}
</section>
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('public/plugins/fancybox/jquery.fancybox.min.css')}}" />
@endsection 

@section('js')
<script src="{{asset('public/plugins/fancybox/jquery.fancybox.min.js')}}"></script>
<script src="{{asset('public/templates/'. $setting->adminTemplate .'/js/menu.js')}}"></script>
@endsection