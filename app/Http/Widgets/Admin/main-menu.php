<?php
return [
	'label' => 'Main menu',
	'description' => 'Show main menu on front-end.',
	'params' => [
		[
			'name' => 'class_sfx',
			'type' => 'text',
			'label' => 'Class suffix',
			'description' => 'Add a class suffix to a extension.'
		],
		[
			'type' => 'spacer'
		],
		[
			'name' => 'timeDelay',
			'type' => 'text',
			'label' => 'Time delay',
			'description' => 'Time delay to show menu (default: 150).',
			'default' => 150
		],
		[
			'name' => 'timeToShowMenu',
			'type' => 'text',
			'label' => 'Time to show menu',
			'description' => 'Time to show menu (default: 250).',
			'default' => 250
		],
		[
			'name' => 'deviation',
			'type' => 'text',
			'label' => 'Deviation',
			'description' => 'Deviation of sub-menu when its content overflow its parent width. Make sure that you know what you\'re doing when changing this option.',
			'default' => 30
		]
	]
];