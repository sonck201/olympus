<?php
Route::group( [
	'prefix' => 'admin' . ( count( $language ) > 1 ? '/' . $language[0]->code : null ),
	'middleware' => 'isRoleAdmin',
	'as' => 'admin'
], function () {
	Route::get( '/post', 'Admin\PostController@all' )->name( 'Post' );
	
	Route::get( '/post/add', 'Admin\PostController@add' )->name( 'PostAdd' );
	
	Route::get( '/post/edit/{id}', 'Admin\PostController@edit' )->name( 'PostEdit' );
	
	Route::post( '/post/update', [
		'uses' => 'Admin\PostController@update',
		'before' => 'csrf'
	] )->name( 'PostUpdate' );
	
	Route::post( '/post/update-status', [
		'uses' => 'Admin\PostController@updateStatus',
		'before' => 'csrf'
	] )->name( 'PostUpdateStatus' );
	
	Route::post( '/post/update-all', [
		'uses' => 'Admin\PostController@updateAll',
		'before' => 'csrf'
	] )->name( 'PostUpdateAll' );
	
	Route::post( '/post/extra-format', 'Admin\PostController@extraFormat' )->name( 'PostExtraFormat' );
	
	Route::post( '/post/image-box-holder', 'Admin\PostController@imageBoxHolder' )->name( 'PostImageBoxHolder' );
	Route::post( '/post/primary-image-box-holder', 'Admin\PostController@primaryImageBoxHolder' )->name( 'PostPrimaryImageBoxHolder' );
	Route::post( '/post/delete-image-box-holder', 'Admin\PostController@deleteImageBoxHolder' )->name( 'PostDeleteImageBoxHolder' );
	
	Route::post( '/post/load-feature-list', 'Admin\PostController@loadFeatureList' )->name( 'PostLoadFeatureList' );
	Route::post( '/post/add-feature', 'Admin\PostController@addFeature' )->name( 'PostAddFeature' );
	Route::post( '/post/delete-feature', 'Admin\PostController@deleteFeature' )->name( 'PostDeleteFeature' );
	Route::post( '/post/create-feature', 'Admin\PostController@createFeature' )->name( 'PostCreateFeature' );
	Route::post( '/post/add-option', 'Admin\PostController@addOption' )->name( 'PostAddOption' );
	Route::post( '/post/remove-feature', 'Admin\PostController@removeFeature' )->name( 'PostRemoveFeature' );
	Route::post( '/post/generate-feature', 'Admin\PostController@generateFeature' )->name( 'PostGenerateFeature' );
	
	Route::get( '/post/{all?}', 'Admin\PostController@all' )->where( 'all', '(.*)' );
} );
