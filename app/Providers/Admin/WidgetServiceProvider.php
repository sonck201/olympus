<?php

namespace App\Providers\Admin;

use Illuminate\Support\ServiceProvider;
use Request, DB, Validator;

class WidgetServiceProvider extends ServiceProvider
{

	/**
	 * Bootstrap the application services.
	 * 
	 * @return void
	 */
	public function boot()
	{
		// Custom rules ExtensionUpdateStatus
		Validator::extend( 'widgetExist', function ( $attribute, $value, $parameters, $validator ) {
			// Check this category exist in databse or not
			$e = DB::table( 'widget' )->find( $value, [
				'id'
			] );
			
			// Check category exist or not
			if ( count( $e ) == 0 )
				return false;
			
			return true;
		} );
		
		// Custom rules ExtensionUpdateAll
		Validator::extend( 'widgetUpdateAll', function ( $attribute, $value, $parameters, $validator ) {
			$input = Request::all();
			
			// Check posted id is valid or not
			if ( !is_array( $input['arrId'] ) || count( $input['arrId'] ) == 0 ) {
				// ID is not valid
				return false;
			}
			
			return true;
		} );
		
		// Custom rules ExtensionUpdatePriority
		Validator::extend( 'widgetUpdatePriority', function ( $attribute, $value, $parameters, $validator ) {
			$input = Request::all();
			
			// Identify the direction
			$arrDirection = [
				'up',
				'down'
			];
			if ( !in_array( $input['direction'], $arrDirection ) ) {
				// Invalid direction
				return false;
			}
			
			// Check this category exist in databse or not
			$e = DB::table( 'widget' )->find( $input['id'], [
				'position',
				'priority'
			] );
			if ( count( $e ) == 0 ) {
				// Not found this widget in database
				return false;
			}
			
			// Fail to move up at max priority
			if ( $e->priority == 1 && $input['direction'] == 'up' ) {
				// Can't move this category priority up. It gets the maximum priority
				return false;
			}
			
			// Fail to move down at min priority
			$min = DB::table( 'widget' )->where( 'position', $e->position )->count();
			if ( $e->priority == $min && $input['direction'] == 'down' ) {
				// Can't move this category priority down. It gets the minimum priority
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
