<?php
// Setup order by
$orderBy = [];
if ( $config->ordering == 'added' )
	$orderBy[] = \DB::getTablePrefix() . 'post.created_at DESC, ' . \DB::getTablePrefix() . 'post.id DESC';
elseif ( $config->ordering == 'modified' )
	$orderBy[] = 'modified_at DESC';
elseif ( $config->mostread )
	$orderBy[] = 'visit DESC, pageview DESC';
	
	// Setup load post format
$postFormat = $config->post_format != 'all' ? '`format` = "' . $config->post_format . '"' : null;

$post = \App\Models\Post::getAll( [
	'lang' => $param->lang,
	'select' => [
		'post.id',
		'post.image',
		'post.category',
		'content.title',
		'content.alias',
		'content.content'
	],
	'where' => [
		'`' . \DB::getTablePrefix() . 'post`.`status` = "active"',
		'`' . \DB::getTablePrefix() . 'post`.`created_at` <= NOW()',
		'CONCAT(",", `category`, ",") REGEXP ",(' . implode( '|', $config->cat_id ) . '),"',
		$postFormat
	],
	'order' => $orderBy,
	'limit' => $config->limit
] );
?>

<div class="list-group">
@foreach ( $post as $p )
	@if ( $config->leadArticle == 'no' )
	@php $opt = count($param->languages) > 1 ? ['id' => $p->id, 'title' => $p->alias, 'lang' => $param->lang] : ['id' => $p->id, 'title' => $p->alias] @endphp
	<a href="{{route('post', $opt)}}" class="list-group-item">
		<b>{{$p->title}}</b>
		@if($config->showBrief == true)<p class="list-group-item-text">{!!str_limit(strip_tags(explode('<p><!-- pagebreak --></p>', $p->content)[0], '<p>'), 200)!!}</p>@endif
	</a>
	@else
	@endif
@endforeach
</div>