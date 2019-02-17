<?php

namespace App\Providers\Admin;

use Illuminate\Support\ServiceProvider;
use DB, Validator;

class UserServiceProvider extends ServiceProvider
{

	/**
	 * Bootstrap the application services.
	 * 
	 * @return void
	 */
	public function boot()
	{
		// Custom rules UserUpdateStatus
		Validator::extend( 'userExist', function ( $attribute, $value, $parameters, $validator ) {
			// Check this user exist in databse or not
			$a = DB::table( 'user' )->find( $value, [
				'id'
			] );
			
			if ( count( $a ) == 0 )
				return false;
			
			return true;
		} );
		
		// Custom rules UserUpdateAll
		Validator::extend( 'userUpdateAll', function ( $attribute, $value, $parameters, $validator ) {
			$input = \Request::all();
			
			// Check posted id is valid or not
			if ( !is_array( $input['arrId'] ) || count( $input['arrId'] ) == 0 ) {
				// ID is not valid
				return false;
			}
			
			return true;
		} );
		
		// check role UserUpdate
		Validator::extend( 'checkRole', function ( $attribute, $value, $parameters, $validator ) {
			// wanna get a higher role ???
			if ( $value > \Auth::user()->role ) {
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
