<?php
Route::group( [
	'prefix' => 'admin' . ( count( $language ) > 1 ? '/' . $language[0]->code : null ),
	'middleware' => 'isRoleAdmin',
	'as' => 'admin'
], function () {
	Route::get( '/widget-position', 'Admin\WidgetController@position' )->name( 'WidgetPosition' );
	
	Route::get( '/widget', 'Admin\WidgetController@all' )->name( 'Widget' );
	
	Route::get( '/widget/add/{type?}', 'Admin\WidgetController@add' )->name( 'WidgetAdd' );
	
	Route::get( '/widget/edit/{id}', 'Admin\WidgetController@edit' )->name( 'WidgetEdit' );
	
	Route::post( '/widget/update', [
		'uses' => 'Admin\WidgetController@update',
		'before' => 'csrf'
	] )->name( 'WidgetUpdate' );
	
	Route::post( '/widget/update-status', [
		'uses' => 'Admin\WidgetController@updateStatus',
		'before' => 'csrf'
	] )->name( 'WidgetUpdateStatus' );
	
	Route::post( '/widget/update-all', [
		'uses' => 'Admin\WidgetController@updateAll',
		'before' => 'csrf'
	] )->name( 'WidgetUpdateAll' );
	
	Route::post( '/widget/update-priority', [
		'uses' => 'Admin\WidgetController@updatePriority',
		'before' => 'csrf'
	] )->name( 'WidgetUpdatePriority' );
	
	Route::get( '/widget/{all?}', 'Admin\WidgetController@all' )->where( 'all', '(.*)' );
} );