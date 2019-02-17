<?php
return [
	[
		'label' => 'Home',
		'controller' => 'web',
		'action' => 'homepage'
	],
	[
		'label' => 'Post',
		'controller' => 'post'
	],
	[
		'label' => 'Category',
		'controller' => 'category',
		'action' => '',
		'model' => 'App/Models/Category',
		'class' => 'getAllCategory'
	],
	[
		'label' => 'Contact',
		'controller' => 'web',
		'action' => 'contactGet'
	]
];