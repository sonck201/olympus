<?php
Route::group( [
	'prefix' => 'admin' . ( count( $language ) > 1 ? '/' . $language[0]->code : null ),
	'middleware' => 'isRoleAdmin'
], function () {
	Route::get( '/category/{type}', 'Admin\CategoryController@all' )->name( 'adminCategory' );
	
	Route::get( '/category/{type}/add', 'Admin\CategoryController@add' )->name( 'adminCategoryAdd' );
	
	Route::get( '/category/{type}/edit/{id}', 'Admin\CategoryController@edit' )->name( 'adminCategoryEdit' );
	
	Route::post( '/category/{type}/update', [
		'uses' => 'Admin\CategoryController@update',
		'before' => 'csrf'
	] )->name( 'adminCategoryUpdate' );
	
	Route::post( '/category/{type}/update-status', [
		'uses' => 'Admin\CategoryController@updateStatus',
		'before' => 'csrf'
	] )->name( 'adminCategoryUpdateStatus' );
	
	Route::post( '/category/{type}/update-all', [
		'uses' => 'Admin\CategoryController@updateAll',
		'before' => 'csrf'
	] )->name( 'adminCategoryUpdateAll' );
	
	Route::post( '/category/{type}/update-priority', [
		'uses' => 'Admin\CategoryController@updatePriority',
		'before' => 'csrf'
	] )->name( 'adminCategoryUpdatePriority' );
	
	Route::get( '/category/{all?}', 'Admin\CategoryController@all' )->where( 'all', '(.*)' );
} );