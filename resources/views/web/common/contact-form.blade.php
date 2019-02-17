{!! Form::open( ['route' => ['adminMenuUpdate'], 'class' => 'row'] ) !!}
<div class="col-xs-4 form-group">
	{!! Form::label('name', __('Web/global.contact.name')) !!}
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-fw fa-user"></i></span>
		{!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Web/global.contact.nameHolder')]) !!}
	</div>
</div>
<div class="col-xs-4 form-group">
	{!! Form::label('email', __('Web/global.contact.email')) !!}
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-fw fa-envelope"></i></span>
		{!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('Web/global.contact.emailHolder')]) !!}
	</div>
</div>
<div class="col-xs-4 form-group">
	{!! Form::label('subject', __('Web/global.contact.subject')) !!}
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-fw fa-pencil"></i></span>
		{!! Form::text('subject', null, ['class' => 'form-control', 'placeholder' => __('Web/global.contact.subjectHolder')]) !!}
	</div>
</div>
<div class="col-xs-12 form-group">
	{!! Form::label('message', __('Web/global.contact.message')) !!}
	{!! Form::textarea('message', null, ['class' => 'form-control', 'placeholder' => __('Web/global.contact.messageHolder')])  !!}
</div>
<div class="col-xs-12 form-group form-group-lg">
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-fw fa-2x fa-lock"></i></span>
		{!! Form::text('captcha', null, ['class' => 'form-control', 'placeholder' => __('Web/global.contact.captchaHolder')]) !!}
		<span class="input-group-btn"><img src="{{$captcha}}" id="imgCaptcha" height="46" /></span>
		<span class="input-group-btn"><button class="btn btn-danger btn-lg generateCaptcha" type="button"><i class="fa fa-refresh"></i></button></span>
	</div>
	{!! Form::hidden('urlCaptcha', route('generateCaptcha')) !!}
</div>
<div class="col-xs-12 form-group">
	<button class="btn btn-primary btn-block btnContactSend" type="button">{{__('Web/global.contact.btnSubmit')}}</button>
	{!! Form::hidden('urlContactPost', route('contactPost')) !!}
</div>
{!!Form::close()!!}