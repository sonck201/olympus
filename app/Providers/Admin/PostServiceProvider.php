<?php

namespace App\Providers\Admin;

use Illuminate\Support\ServiceProvider;
use Request, DB, Validator;

class PostServiceProvider extends ServiceProvider
{

	/**
	 * Bootstrap the application services.
	 * 
	 * @return void
	 */
	public function boot()
	{
		// Custom rules PostUpdateStatus
		Validator::extend( 'postExist', function ( $attribute, $value, $parameters, $validator ) {
			// Check this post exist in databse or not
			$p = DB::table( 'post' )->find( $value, [
				'id'
			] );
			
			if ( count( $p ) == 0 )
				return false;
			
			return true;
		} );
		
		// Custom rules PostUpdateAll
		Validator::extend( 'postUpdateAll', function ( $attribute, $value, $parameters, $validator ) {
			$input = Request::all();
			
			// Check posted id is valid or not
			if ( !is_array( $input['arrId'] ) || count( $input['arrId'] ) == 0 ) {
				// ID is not valid
				return false;
			}
			
			return true;
		} );
	}

	/**
	 * Register any application services.
	 * 
	 * @return void
	 */
	public function register()
	{
		//
	}
}
