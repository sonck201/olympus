<?php
Route::group( [
	'prefix' => ( count( $language ) > 1 ? '/' . '{lang?}' : null )
], function () {
	Route::get( '/', 'Web\WebController@Homepage' )->name( 'homepage' );
	
	Route::get( '/contact', 'Web\WebController@contactGet' )->name( 'contactGet' );
	
	Route::post( '/contact', 'Web\WebController@contactPost' )->name( 'contactPost' );
	
	Route::get( '/{title}_{id}', 'Web\ContentController@Post' )->name( 'post' );
	
	Route::get( '/category/{title}_{id}', 'Web\ContentController@Category' )->name( 'category' );
	
	Route::post( '/generate-captcha', 'Web\WebController@generateCaptcha' )->name( 'generateCaptcha' );
} );
// Remake dashboard when trying to make something bull shit
// Route::get( '{all?}', 'Web\WebController@homepage' )->where( 'all', '(.*)' );