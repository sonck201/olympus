<?php
Route::group( [
	'prefix' => 'admin' . ( count( $language ) > 1 ? '/' . $language[0]->code : null ),
	'middleware' => 'isRoleAdmin',
	'as' => 'admin'
], function () {
	Route::get( '/user', 'Admin\UserController@all' )->name( 'User' );
	
	Route::get( '/user/add', 'Admin\UserController@add' )->name( 'UserAdd' );
	
	Route::get( '/user/edit/{id}', 'Admin\UserController@edit' )->name( 'UserEdit' );
	
	Route::get( '/user/profile', 'Admin\UserController@profile' )->name( 'UserProfile' );
	
	Route::post( '/user/update', [
		'uses' => 'Admin\UserController@update',
		'before' => 'csrf'
	] )->name( 'UserUpdate' );
	
	Route::post( '/user/update-status', [
		'uses' => 'Admin\UserController@updateStatus',
		'before' => 'csrf'
	] )->name( 'UserUpdateStatus' );
	
	Route::post( '/user/update-all', [
		'uses' => 'Admin\UserController@updateAll',
		'before' => 'csrf'
	] )->name( 'UserUpdateAll' );
	
	Route::get( '/user/role', 'Admin\UserController@role' )->name( 'UserRole' );
	
	Route::get( '/user/{all?}', 'Admin\UserController@all' )->where( 'all', '(.*)' );
} );
