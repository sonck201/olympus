<?php
return [
	'label' => 'Google map',
	'description' => 'Create Google map.',
	'showEditor' => true,
	'params' => [
		[
			'name' => 'class_sfx',
			'type' => 'text',
			'label' => 'Class suffix',
			'description' => 'Add a class suffix to a extension'
		],
		[
			'type' => 'spacer'
		],
		[
			'name' => 'lat',
			'type' => 'text',
			'label' => 'Latitude',
			'description' => 'Latitude coordinate. Default: 10.79685',
			'default' => 10.79685
		],
		[
			'name' => 'long',
			'type' => 'text',
			'label' => 'Longitude',
			'description' => 'Longitude coordinate. Default: 106.64272',
			'default' => 106.64272
		],
		[
			'name' => 'zoom',
			'type' => 'text',
			'label' => 'Zoom',
			'description' => 'Map zoom. Default: 15',
			'default' => 15
		],
		[
			'name' => 'width',
			'type' => 'text',
			'label' => 'Width',
			'description' => 'Width of map. Put 0 for 100%',
			'default' => '100%'
		],
		[
			'name' => 'height',
			'type' => 'text',
			'label' => 'Height',
			'description' => 'Height of map (px)',
			'default' => 300
		],
		[
			'name' => 'backgroundColor',
			'type' => 'text',
			'label' => 'Background color',
			'description' => 'Background color',
			'default' => 'grey'
		],
		[
			'name' => 'apiKey',
			'type' => 'text',
			'label' => 'API key',
			'description' => 'API key',
			'default' => 'AIzaSyApf9yEbuxg536hxcKhYVhEGIte6aWy1Es'
		]
	]
];