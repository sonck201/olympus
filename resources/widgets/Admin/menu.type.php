<?php
return [
	[
		'disabled' => true,
		'label' => 'Homepage',
		'alias' => 'homepage',
		'description' => 'Create homepage',
		'route' => 'homepage',
		'showData' => ''
	],
	[
		'label' => 'Contact',
		'alias' => 'contact',
		'description' => 'Contact',
		'route' => 'contactGet'
	],
	[
		'disabled' => true,
		'label' => 'Portfolio',
		'alias' => 'portfolio',
		'description' => 'Portfolio'
	],
	[
		'label' => 'Separator',
		'alias' => 'separator',
		'description' => 'Separator',
		'showData' => ''
	],
	[
		'label' => 'Url',
		'alias' => 'url',
		'description' => 'External link',
		'showData' => 'yes'
	],
	[
		'label' => 'Post',
		'alias' => 'post',
		'description' => 'Show the post content',
		'route' => 'post',
		'showData' => 'yes',
		'appModel' => 'App/Models/Post',
		'appClass' => 'getAll',
		'appPrefix' => 'content.'
	],
	[
		'label' => 'Category',
		'alias' => 'category',
		'description' => 'Show all the posts in given category ID',
		'route' => 'category',
		'showData' => 'yes',
		'appModel' => 'App/Models/Category',
		'appClass' => 'getAllCategory',
		'appPrefix' => 'content.'
	],
	[
		'disabled' => true,
		'label' => 'Product detail',
		'alias' => 'product-detail',
		'description' => 'Show the product content',
		'showData' => 'yes',
		'appModel' => 'App/Models/Product',
		'appClass' => 'getAll'
	],
	[
		'disabled' => true,
		'label' => 'Product category',
		'alias' => 'product-category',
		'description' => 'Show all the products in given category ID',
		'showData' => 'yes',
		'appModel' => 'App/Models/Category',
		'appClass' => 'getAll',
		'appType' => 'product'
	],
	[
		'disabled' => true,
		'label' => 'Product showcart',
		'alias' => 'product-showcart',
		'description' => 'Show cart information',
		'route' => 'productShowCart'
	]
];