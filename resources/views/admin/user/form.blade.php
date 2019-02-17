@extends('admin.layout.master') 

@section('pageTitle') 
{!! $titlePage !!} | @parent 
@endsection 

@section('content')
<section id="user" class="page">
	{!! Form::open( ['route' => ['adminUserUpdate'], 'class' => 'validate'] ) !!}
	<div class="row">
		<div class="col-xs-6">
			<div class="form-group">{!! Form::label('email', 'Email') !!} {!! Form::email('email', (isset($user->email) ? $user->email : null), ['class' => 'form-control input-lg', 'placeholder' => 'Input user email', ( $param->action == 'edit' ? 'disabled' : null )]) !!}</div>
			<div class="form-group">{!! Form::label('password', 'New password') !!} {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Input a new password here!!']) !!}</div>
			<div class="form-group">{!! Form::label('status', 'Status') !!} {!! Form::select('status', ['— Select user status —' => ['active' => 'Active', 'deactive' => 'Deactive', 'trash' => 'Trash']], (isset($user->status) ? $user->status : null), ['class' => 'form-control']) !!}</div>
			<div class="form-group">{!! Form::label('role', 'Role') !!} {!! Form::select('role', ['— Select user role —' => $roles], (isset($user->role) ? $user->role : null), ['class' => 'form-control']) !!}</div>
			<div class="form-group">{!! Form::label('subscribe', 'Subscribe') !!} {!! Form::select('subscribe', ['— User want to receive information from us —' => ['yes' => 'Yes', 'no' => 'No']], (isset($user->subscribe) ? $user->subscribe : null), ['class' => 'form-control']) !!}</div>
		</div>
		
		<div class="col-xs-6">
				<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#info" aria-controls="info" role="tab" data-toggle="tab">User info</a></li>
					@if( $param->action == 'edit' )<li role="presentation"><a href="#timingIp" aria-controls="timingIp" role="tab" data-toggle="tab">IP & Timing</a></li>@endif
				</ul>
				<div class="tab-content">
					<div role="tabpanel" class="tab-pane active" id="info">
						<div class="form-group">{!! Form::label('name', 'Name') !!} {!! Form::text('name', (isset($user->name) ? $user->name : null), ['class' => 'form-control input-lg', 'placeholder' => 'Input user name']) !!}</div>
						<div class="form-group row">
							<div class="col-xs-12">{!! Form::label('birthday', 'Birthday') !!}</div>
							<div class="col-xs-4">{!! Form::selectRange('bdDate', 1, 31, ( isset($user->birthday) ? date( 'd', strtotime( $user->birthday ) ) : null ), ['class' => 'form-control', 'placeholder' => 'Date of birth']) !!}</div>
							<div class="col-xs-4">{!! Form::selectMonth('bdMonth', ( isset($user->birthday) ? date( 'm', strtotime( $user->birthday ) ) : null ), ['class' => 'form-control', 'placeholder' => 'Month of birth'], '%m') !!}</div>
							<div class="col-xs-4">{!! Form::selectRange('bdYear', date('Y'), date('Y', mktime(0, 0, 0, 0, 0, date('Y') - 50)), ( isset($user->birthday) ? date( 'Y', strtotime( $user->birthday ) ) : null ), ['class' => 'form-control', 'placeholder' => 'Year of birth']) !!}</div>
						</div>
						<div class="form-group">{!! Form::label('phone', 'Phone') !!} {!! Form::number('phone', (isset($user->phone) ? $user->phone : null), ['class' => 'form-control', 'placeholder' => 'Input user phone']) !!}</div>
						<div class="form-group">{!! Form::label('address', 'Address') !!} {!! Form::textarea('address', (isset($user->address) ? $user->address : null), ['class' => 'form-control', 'placeholder' => 'Input user address', 'rows' => 6]) !!}</div>
						
					</div>
					@if( $param->action == 'edit' )
					<div role="tabpanel" class="tab-pane" id="timingIp">
						<div><b>Register IP</b> {{ $user->register_ip }}</div>
						<div><b>Active IP</b> {{ $user->active_ip }}</div>
						<div><b>Logged at</b> {{ $user->logged_at }}</div>
						<div><b>Created at</b> {{ $user->created_at }}</div>
						<div><b>Updated at</b> {{ $user->updated_at }}</div>
					</div>
					@endif
				</div>
		</div>
	</div>
	<div class="form-group">
		{!! Form::hidden('id', isset($user->id) ? $user->id : null, ['id' => 'id']) !!} 
		{!! Form::hidden('urlUpdate', route('adminUserUpdate'), ['id' => 'urlUpdate']) !!} 
		{!! Form::hidden('urlAll', route('adminUser'), ['id' => 'urlAll']) !!} 
		{!! Form::hidden('urlNew', route('adminUserAdd'), ['id' => 'urlAdd']) !!} 
		@if( $param->action == 'edit' ) 
		{!! Form::hidden('urlEdit', route('adminUserEdit', ['id' => $user->id]), ['id' => 'urlEdit']) !!} 
		@endif
	</div>
	{!! Form::close() !!}
</section>
@endsection 

@section('css')
<link rel="stylesheet" href="{{asset('plugins/datetimepicker/css/bootstrap-datetimepicker.min.css')}}" />
@endsection

@section('js')
<script src="{{asset('assets/js/moment.min.js')}}"></script>
<script src="{{asset('plugins/datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
@endsection
