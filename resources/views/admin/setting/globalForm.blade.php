<div class="row">
	<div class="col-xs-6">
		<div class="form-group">
			{!!Form::label('siteName', 'Site name')!!}
			{!!Form::text('siteName', $setting->siteName, ['class' => 'form-control', 'placeholder' => 'Default site name. Suffix for all other page except home.'])!!}
		</div>
		<div class="form-group">
			{!!Form::label('siteDescription', 'Site description')!!}
			{!!Form::textarea('siteDescription', $setting->siteDescription, ['class' => 'form-control', 'placeholder' => 'Enter default description for website.'])!!}
		</div>
		<div class="form-group">
			{!!Form::label('siteKeyword', 'Site keyword')!!}
			{!!Form::textarea('siteKeyword', $setting->siteKeyword, ['class' => 'form-control', 'placeholder' => 'Enter some default keywords for website.'])!!}
		</div>
		<div class="form-group">
			{!!Form::label('siteContactEmail', 'Site contact email')!!}
			{!!Form::text('siteContactEmail', $setting->siteContactEmail, ['class' => 'form-control', 'placeholder' => 'Default contact email. eg: name@domain.com'])!!}
		</div>
		<div class="form-group">
			{!!Form::label('siteOnline', 'Site online')!!}
			{!!Form::select('siteOnline', ['1' => 'Online', '0' => 'Offline'], $setting->siteOnline, ['class' => 'form-control'])!!}
		</div>
		<div class="form-group">
			{!!Form::label('siteMessage', 'Site message')!!}
			{!!Form::textarea('siteMessage', $setting->siteMessage, ['class' => 'form-control', 'placeholder' => 'Enter message when system down.'])!!}
		</div>
	</div>
	<div class="col-xs-6">
		<div class="row">
			<div class="col-xs-6">
				<div class="form-group">
					{!!Form::label('adminTemplate', 'Admin template')!!}
					{!!Form::select('adminTemplate', $settingData->adminTemplate, $setting->language, ['class' => 'form-control'])!!}
				</div>
			</div>
			<div class="col-xs-6">
				<div class="form-group">
					{!!Form::label('webTemplate', 'Web template')!!}
					{!!Form::select('webTemplate', $settingData->webTemplate, $setting->language, ['class' => 'form-control'])!!}
				</div>
			</div>
		</div>
		<div class="form-group">
			{!!Form::label('language', 'Language')!!}
			{!!Form::select('language', ['vi' => 'Vietnamese', 'en' => 'English'], $setting->language, ['class' => 'form-control'])!!}
		</div>
		<div class="row">
			<div class="col-xs-6">
				<div class="form-group">
					{!!Form::label('itemPerPage', 'Item per page (Admin)')!!}
					{!!Form::text('itemPerPage', $setting->itemPerPage, ['class' => 'form-control', 'placeholder' => '30'])!!}
				</div>
			</div>
			<div class="col-xs-6">
				<div class="form-group">
					{!!Form::label('postPerPage', 'Post per page (Site)')!!}
					{!!Form::text('postPerPage', $setting->postPerPage, ['class' => 'form-control', 'placeholder' => '5'])!!}
				</div>
			</div>
		</div>
		<div class="form-group">
			{!!Form::label('userActive', 'User active?')!!}
			{!!Form::select('userActive', ['0' => 'Yes', '1' => 'No'], $setting->userActive, ['class' => 'form-control'])!!}
		</div>
		<div class="form-group">
			{!!Form::label('analyticId', 'Analytic ID')!!}
			{!!Form::text('analyticId', $setting->analyticId, ['class' => 'form-control hasTooltip', 'placeholder' => 'Insert Google Analytic ID here. Separate each ID by |', 'title' => 'Separate each ID by |'])!!}
		</div>
		<div class="row">
			<div class="col-xs-6">
				<div class="form-group">
					{!!Form::label('sessionExpire', 'Session expire')!!}
					{!!Form::text('sessionExpire', $setting->sessionExpire, ['class' => 'form-control hasTooltip', 'placeholder' => '60', 'title' => 'Minutes'])!!}
				</div>
			</div>
			<div class="col-xs-6">
				<div class="form-group">
					{!!Form::label('cacheExpire', 'Cache expire')!!}
					{!!Form::text('cacheExpire', $setting->cacheExpire, ['class' => 'form-control hasTooltip', 'placeholder' => '60', 'title' => 'Minutes'])!!}
				</div>
			</div>
		</div>
	</div>
</div>