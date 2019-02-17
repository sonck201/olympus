<?php
return [
	'label' => 'Category',
	'description' => 'Show category with given ID.',
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
			'name' => 'parent_id',
			'type' => 'database',
			'label' => 'Category',
			'description' => 'Select from one of these categories.',
			'model' => 'App/Models/Category',
			'class' => 'getAllCategory',
			'categoryType' => ''
		],
		[
			'name' => 'expand_children',
			'type' => 'select',
			'label' => 'Expand children',
			'description' => 'Expand children of this menu.',
			'default' => 'all',
			'options' => [
				'all' => 'All',
				'no' => 'No'
			]
		]
	]
];