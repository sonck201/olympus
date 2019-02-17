<?php
return [
	'label' => 'Post sort',
	'description' => 'Get the posts by category.',
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
			'name' => 'cat_id',
			'type' => 'database',
			'multiple' => true,
			'label' => 'Category',
			'description' => 'Select from one of these categories.',
			'model' => 'App/Models/Category',
			'class' => 'getAllCategory'
		],
		[
			'name' => 'post_format',
			'type' => 'select',
			'label' => 'Choose post format',
			'description' => 'Choose post format.',
			'default' => 'standard',
			'options' => [
				'all' => 'All',
				'standard' => 'Standard',
				'image' => 'Image'
			]
		],
		[
			'name' => 'showBrief',
			'type' => 'select',
			'label' => 'Show brief',
			'description' => 'Show brief on each post',
			'default' => 'no',
			'options' => [
				'yes',
				'no'
			]
		],
		[
			'name' => 'ordering',
			'type' => 'select',
			'label' => 'Ordering',
			'description' => 'Ordering the article.',
			'default' => 'added',
			'options' => [
				'added' => 'Recent Added First',
				'modified' => 'Recent Modified First',
				'mostread' => 'Most read'
			]
		],
		[
			'name' => 'limit',
			'type' => 'text',
			'label' => 'Limit',
			'description' => 'The number of Article to display (the default is 5)',
			'default' => 5
		],
		[
			'name' => 'leadArticle',
			'type' => 'select',
			'label' => 'Display image at first article',
			'description' => 'Display image at first article',
			'default' => 'no',
			'options' => [
				'yes' => 'Yes',
				'no' => 'No'
			]
		]
	]
];