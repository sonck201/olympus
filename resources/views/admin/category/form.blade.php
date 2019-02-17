@extends('admin.layout.master')

@section('pageTitle')
{!!$titlePage!!} | @parent
@endsection

@section('content')
<section id="category" class="page">
	{!!Form::open( ['route' => ['adminCategoryUpdate', Route::input( 'type' )], 'class' => 'row'] )!!}
		<div class="col-xs-7">
			@foreach($param->languages as $lang)
			<div class="form-group">
				{!!Form::label('title'. strtoupper($lang->code), 'Title '. strtoupper($lang->code))!!}
				<div class="input-group">
					{!!Form::text('title'. strtoupper($lang->code), isset($category->data[$lang->code]->title) ? $category->data[$lang->code]->title : null, ['class' => 'form-control input-lg', 'placeholder' => 'Title'])!!}
					<span class="input-group-addon">
						<img src="{{asset('public/assets/images/flag/'. $lang->code .'.jpg')}}" />
					</span>
				</div>
			</div>
			@endforeach
			<div class="form-group">
				{!!Form::label('parent', 'Parent')!!}
				{!!Form::select('parent', $categories, isset($category->parent) ? $category->parent : null, ['class' => 'form-control', 'required'])!!}
				{!!Form::hidden('parentOriginal', isset($category->parent) ? $category->parent : null)!!}
			</div>
			<div class="form-group">
				{!!Form::hidden('id', isset($category->id) ? $category->id : null, ['id' => 'id'])!!}
				{!!Form::hidden('urlUpdate', route('adminCategoryUpdate', ['type' => Route::input( 'type' )]), ['id' => 'urlUpdate'])!!}
				{!!Form::hidden('urlAll', route('adminCategory', ['type' => Route::input( 'type' )]), ['id' => 'urlAll'])!!}
				{!!Form::hidden('urlNew', route('adminCategoryAdd', ['type' => Route::input( 'type' )]), ['id' => 'urlAdd'])!!}
				@if( $param->action == 'edit' )
				{!!Form::hidden('urlEdit', route('adminCategoryEdit', ['type' => Route::input( 'type' ), 'id' => $category->id]), ['id' => 'urlEdit'])!!}
				@endif
			</div>
		</div>
		<div class="col-xs-4 col-xs-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading"><h3 class="panel-title">Parameter</h3></div>
				<ul class="list-group">
					<li class="list-group-item"><label>{!! Form::checkbox('param_show_category', null, (isset($paramCategory->show_category) ? $paramCategory->show_category : false)) !!} Show category</label></li>
					<li class="list-group-item"><label>{!! Form::checkbox('param_show_post', null, (isset($paramCategory->show_post) ? $paramCategory->show_post : true)) !!} Show post</label></li>
				</ul>
			</div>
		</div>
	{!!Form::close()!!}
</section>
@endsection