<?php
return [
	[
		'id' => 'adminDashboard',
		'href' => route( 'adminDashboard' ),
		'text' => 'Dashboard',
		'zone' => 'dashboard',
		'icon' => 'dashboard'
	],
	[
		'text' => 'User',
		'zone' => 'user',
		'icon' => 'user',
		'dropdown' => [
			[
				'id' => 'userAll',
				'href' => route( 'adminUser' ),
				'text' => 'Manager',
				'zone' => 'user'
			],
			[
				'id' => 'userRole',
				'href' => route( 'adminUserRole' ),
				'text' => 'Role',
				'zone' => 'user'
			]
		]
	],
	[
		'id' => 'menuAll',
		'text' => 'Menu',
		'href' => route( 'adminMenu' ),
		'zone' => 'menu',
		'icon' => 'bars'
	],
	[
		'text' => 'Content',
		'zone' => 'content',
		'icon' => 'file-text-o',
		'dropdown' => [
			'post' => [
				'id' => 'postAll',
				'href' => route( 'adminPost' ),
				'text' => 'Post',
				'zone' => 'post'
			],
			[
				'id' => 'categoryAll',
				'href' => route( 'adminCategory', [
					'type' => 'post'
				] ),
				'text' => 'Category',
				'zone' => 'category'
			],
			'product' => [
				'id' => '#',
				'href' => '#',
				'text' => 'Product',
				'zone' => 'product',
				'class' => 'hidden'
			],
			[
				'id' => '#',
				'href' => route( 'adminCategory', [
					'type' => 'product'
				] ),
				'text' => 'Product category',
				'zone' => 'category',
				'class' => 'hidden'
			]
		]
	],
	[
		'text' => 'Widget',
		'zone' => 'widget',
		'icon' => 'puzzle-piece',
		'dropdown' => [
			[
				'id' => 'widgetAll',
				'href' => route( 'adminWidget' ),
				'text' => 'Manager',
				'zone' => 'widget'
			],
			[
				'id' => 'widgetPosition',
				'href' => route( 'adminWidgetPosition' ),
				'text' => 'Position',
				'zone' => 'widget'
			]
		]
	],
	[
		'id' => 'adminSetting',
		'text' => 'Setting',
		'href' => route( 'adminSetting' ),
		'zone' => 'setting',
		'icon' => 'gear'
	]
];