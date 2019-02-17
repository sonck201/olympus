<?php
Route::group( [
	'prefix' => 'admin' . ( count( $language ) > 1 ? '/' . $language[0]->code : null ),
	'middleware' => 'isRoleAdmin',
	'as' => 'admin'
], function () {
	Route::get( '/', 'Admin\AdminController@dashboard' )->name( 'Dashboard' );
	
	Route::get( '/auth/login', 'Admin\AuthController@getLogin' )->name( 'AuthGetLogin' );
	
	Route::post( '/auth/login', [
		'uses' => 'Admin\AuthController@postLogin',
		'before' => 'csrf'
	] )->name( 'AuthPostLogin' );
	
	Route::get( '/auth/logout', 'Admin\AuthController@logout' )->name( 'AuthLogout' );
	
	// Start setting
	Route::get( '/setting', 'Admin\AdminController@setting' )->name( 'Setting' );
	
	Route::post( '/setting-update', [
		'uses' => 'Admin\AdminController@settingUpdate',
		'before' => 'csrf'
	] )->name( 'SettingUpdate' );
	
	// Image
	Route::post( '/file/upload', 'Admin\FileController@upload' )->name( 'FileUpload' );
	
	// Clear cache
	Route::get( '/clear-cache', 'Admin\AdminController@clearCache' )->name( 'ClearCache' );
} );