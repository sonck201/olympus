<div class="row">
	<div class="col-xs-6 col-xs-offset-3">
		<div class="form-group">
			{!!Form::label('mailSmtpServer', 'SMTP server')!!}
			{!!Form::text('mailSmtpServer', $setting->mailSmtpServer, ['class' => 'form-control', 'placeholder' => 'smtp.google.com'])!!}
		</div>
		<div class="form-group">
			{!!Form::label('mailSmtpSeverPort', 'SMTP server port')!!}
			{!!Form::text('mailSmtpSeverPort', $setting->mailSmtpSeverPort, ['class' => 'form-control', 'placeholder' => '465'])!!}
		</div>
		<div class="form-group">
			{!!Form::label('mailUsername', 'Username')!!}
			{!!Form::text('mailUsername', $setting->mailUsername, ['class' => 'form-control', 'placeholder' => 'eg: email@domain.com'])!!}
		</div>
		<div class="form-group">
			{!!Form::label('mailPassword', 'Password')!!}
			{!!Form::text('mailPassword', $setting->mailPassword, ['class' => 'form-control', 'placeholder' => 'Password'])!!}
		</div>
		<div class="form-group">
			{!!Form::label('mailName', 'Display name')!!}
			{!!Form::text('mailName', $setting->mailName, ['class' => 'form-control', 'placeholder' => 'Display name'])!!}
		</div>
	</div>
</div>