<?php
Route::group( [
	'prefix' => 'admin' . ( count( $language ) > 1 ? '/' . $language[0]->code : null ),
	'middleware' => 'isRoleAdmin',
	'as' => 'admin'
], function () {
	Route::get( '/menu', 'Admin\MenuController@all' )->name( 'Menu' );
	
	Route::get( '/menu/add/{type?}', 'Admin\MenuController@add' )->name( 'MenuAdd' );
	
	Route::get( '/menu/edit/{type?}/{id}', 'Admin\MenuController@edit' )->name( 'MenuEdit' );
	
	Route::get( '/menu/get-data', 'Admin\MenuController@getData' )->name( 'MenuGetData' );
	
	Route::get( '/menu/get-data-more', 'Admin\MenuController@getDataMore' )->name( 'MenuGetDataMore' );
	
	Route::post( '/menu/update', [
		'uses' => 'Admin\MenuController@update',
		'before' => 'csrf'
	] )->name( 'MenuUpdate' );
	
	Route::post( '/menu/update-status', [
		'uses' => 'Admin\MenuController@updateStatus',
		'before' => 'csrf'
	] )->name( 'MenuUpdateStatus' );
	
	Route::post( '/menu/update-all', [
		'uses' => 'Admin\MenuController@updateAll',
		'before' => 'csrf'
	] )->name( 'MenuUpdateAll' );
	
	Route::post( '/menu/update-priority', [
		'uses' => 'Admin\MenuController@updatePriority',
		'before' => 'csrf'
	] )->name( 'MenuUpdatePriority' );
	
	Route::get( '/menu/{all?}', 'Admin\MenuController@all' )->where( 'all', '(.*)' );
} );