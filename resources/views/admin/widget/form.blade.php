@extends('admin.layout.master')

@section('pageTitle')
{!!$titlePage!!} | @parent
@endsection

@section('content')
<section id="widget" class="page">
	{!! Form::open( ['route' => ['adminWidgetUpdate'], 'class' => ''] ) !!}
		<ul class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#detailTab" aria-controls="detailTab" role="tab" data-toggle="tab">Detail & Parameter</a></li>
			<li role="presentation"><a href="#assignmentTab" aria-controls="assignmentTab" role="tab" data-toggle="tab">Assignment</a></li>
			@if ( isset($typeDetail['showEditor']) == true )
			<li role="presentation"><a href="#editorTab" aria-controls="editorTab" role="tab" data-toggle="tab">Editor</a></li>
			@endif
		</ul>
		
		<div class="tab-content">
			<div role="tabpanel" class="tab-pane active" id="detailTab">
				<div class="col-xs-6">
					<div class="page-header"><h2>Detail @if( $param->action == 'add' )<small class="pull-right"><a href="{{ route('adminWidgetAdd') }}" class="btn btn-danger">Change type</a></small>@endif</h2></div>
					@foreach($param->languages as $lang)
					<div class="form-group">
						{!!Form::label('title'. strtoupper($lang->code), 'Title '. strtoupper($lang->code))!!}
						<div class="input-group">
							{!!Form::text('title'. strtoupper($lang->code), isset($widget->content[$lang->code]->title) ? $widget->content[$lang->code]->title : null, ['class' => 'form-control input-lg', 'placeholder' => 'Input title'])!!}
							<span class="input-group-addon">
								<img src="{{asset('public/assets/images/flag/'. $lang->code .'.jpg')}}" />
							</span>
						</div>
					</div>
					@endforeach
					
					<div class="form-group">
						{!! Form::label('status', 'Status') !!}
						{!! Form::select('status', ['active' => 'Active', 'deactive' => 'Deactive'], isset($widget->status) ? $widget->status : null, ['class' => 'form-control']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('position', 'Position') !!}
						{!! Form::select('position', $positions, isset($widget->position) ? $widget->position : null, ['class' => 'form-control', 'placeholder' => '— Select position —']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('show_title', 'Show title') !!}
						{!! Form::select('show_title', ['yes' => 'Yes', 'no' => 'No'], isset($widget->show_title) ? $widget->show_title : 'no', ['class' => 'form-control']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('show_content', 'Show content') !!}
						{!! Form::select('show_content', ['yes' => 'Yes', 'no' => 'No'], isset($widget->show_content) ? $widget->show_content : 'yes', ['class' => 'form-control']) !!}
					</div>
					<div class="form-group">
						<h3 class="sub-header">Visible zone</h3>
						@php 
							$visibleZone = ['visible-xs', 'visible-sm', 'visible-md', 'visible-lg'];
							$visibleText = ['XS - Auto', 'SM - 750px', 'MD - 970px', 'LG - 1170px'];
						@endphp
						<div class="row">
							@foreach ($visibleZone as $z)
							<div class="col-xs-6">
								<label>
									{!! Form::checkbox($z, null, (isset($arrVisibleZone[$z]) ? $arrVisibleZone[$z] : true)) !!} {{ $visibleText[$loop->index] }}
								</label>
							</div>
							@endforeach
							{!!Form::hidden('visibleZoneField', implode(',', $visibleZone))!!}
						</div>
					</div>
				</div>
				
				<div class="col-xs-6 parameterGroup">
					<div class="page-header"><h2>Parameters</h2></div>
					{!! Form::hidden('parameterField', null, ['id' => 'parameterField']) !!}
					@if ( $param->action == 'edit' )
					@include('admin.widget.parameter', ['params' => $typeDetail['params'], 'value' => json_decode($widget->param)])
					@else
					@include('admin.widget.parameter', ['params' => $typeDetail['params']])
					@endif
				</div>
			</div>
			<div role="tabpanel" class="tab-pane" id="assignmentTab">
				<div class="page-header"><h2>Assignment</h2></div>
				<div class="form-group btn-group btn-group-justified" role="group">
					<a href="#" id="btnSelectAll" class="btn btn-primary">Select all</a>
					<a href="#" id="btnSelectPage" class="btn btn-warning">Select page</a>
					<a href="#" id="btnClearSelection" class="btn btn-danger">Clear selection</a>
				</div>
				<div class="form-group">
					{!! Form::hidden('selectAssignment', isset($assignments['all']) ? $assignments['all'] : null) !!}
					{!! Form::select('assignment[]', $assignments['options'], isset($assignments['value']) ? $assignments['value'] : null, ['id' => 'assignment', 'class' => 'form-control', 'multiple' => true]) !!}
				</div>
			</div>
			@if ( isset($typeDetail['showEditor']) == true )
			<div role="tabpanel" class="tab-pane" id="editorTab">
				<div class="page-header"><h2>Editor</h2></div>
				<ul class="nav nav-tabs" role="tablist">
					@foreach($param->languages as $k => $lang)
						<li role="presentation" class="{{ $k == 0 ? 'active' : null }}">
							<a href="#{{$lang->code}}" aria-controls="{{$lang->code}}" role="tab" data-toggle="tab">
								<img src="{{asset('public/assets/images/flag/'. $lang->code .'.jpg')}}" />
							</a>
						</li>
					@endforeach
				</ul>
				
				<div class="tab-content">
					@foreach($param->languages as $k => $lang)
					<div role="tabpanel" class="tab-pane {{ $k == 0 ? 'active' : null }}" id="{{$lang->code}}">
						<div class="form-group">{!! Form::textarea('content'. strtoupper($lang->code), isset($widget->content[$lang->code]->content) ? $widget->content[$lang->code]->content : null, ['class' => 'form-control tinymce brief']) !!}</div>
					</div>
					@endforeach
				</div>
			</div>
			@endif
		</div>
		
		<div class="col-xs-12">
			{!!Form::hidden('id', isset($widget->id) ? $widget->id : null, ['id' => 'id'])!!}
			{!!Form::hidden('urlUpdate', route('adminWidgetUpdate'), ['id' => 'urlUpdate'])!!}
			{!!Form::hidden('urlAll', route('adminWidget'), ['id' => 'urlAll'])!!}
			{!!Form::hidden('urlNew', route('adminWidgetAdd'), ['id' => 'urlAdd'])!!}
			{!!Form::hidden('type', str_slug($typeDetail['label']))!!}
			
			@if ( $param->action == 'edit' ) {!!Form::hidden('urlEdit', route('adminWidgetEdit', ['id' => $widget->id]), ['id' => 'urlEdit'])!!} @endif
		</div>
	{!!Form::close()!!}
</section>
@endsection

@section('css')
<link rel="stylesheet" href="{{asset('public/plugins/fancybox/jquery.fancybox.min.css')}}" />
@endsection @section('js')
<script src="{{asset('public/plugins/fancybox/jquery.fancybox.min.js')}}"></script>
<script src="{{asset('public/plugins/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('public/templates/'. $setting->adminTemplate .'/js/widget.js')}}"></script>
@endsection