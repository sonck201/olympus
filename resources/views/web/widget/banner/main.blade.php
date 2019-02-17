@php
// Get all banner
$banner = \App\Models\Post::getAll( [
	'lang' => $param->lang,
	'select' => [
		'post.id',
		'post.image',
		'post.feature',
		'content.title',
		'content.alias',
		'content.content',
		'post_extra.*'
	],
	'where' => [
		'`'. DB::getTablePrefix() .'post`.`status` = "active"',
		'FIND_IN_SET('. $config->cat_id .', category)'
	]
] );
@endphp

@if ($config->banner_type == 'ccslider')
	@include('web.widget.banner.type.ccslider')
@elseif ($config->banner_type == 'revolution')
	@include('web.widget.banner.type.revolution')
@endif