<?php
return [
	'web' => [
		'homepage' => 'Homepage',
		'contact' => 'Contact'
	],
	'contact' => [
		'name' => 'Full name *',
		'nameHolder' => 'Enter your full name',
		'email' => 'Email *',
		'emailHolder' => 'Enter your email',
		'subject' => 'Subject *',
		'subjectHolder' => 'Enter your subject',
		'message' => 'Message *',
		'messageHolder' => 'Enter your message without any HTML tags',
		'captchaHolder' => 'Enter security code beside *',
		'btnSubmit' => 'Send',
		'mailSent' => 'Email has been sent',
		'error' => [
			'required' => 'Input :field, please!',
			'alpha_dash' => 'Input valid character in :Field field, please!',
			'email' => 'The email must be a valid email address',
			'min' => 'The :field must be at least 50 characters',
			'captcha_not_correct' => 'Security code not correct'
		]
	],
	'content' => [
		'post' => []
	],
	'error' => [
		'invalid_id' => 'Invalid ID',
		'empty_data' => 'Nothing to display',
		'empty_breadcrumb' => 'BREADCRUMB::=> Nothing to show'
	]
];
