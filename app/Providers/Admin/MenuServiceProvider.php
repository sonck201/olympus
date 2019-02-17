<?php

namespace App\Providers\Admin;

use Illuminate\Support\ServiceProvider;
use Request, DB, Validator;
use App\Http\Controllers\Controller;
use App\Models\Menu;

class MenuServiceProvider extends ServiceProvider
{

	/**
	 * Bootstrap the application services.
	 * 
	 * @return void
	 */
	public function boot()
	{
		// Custom rules MenuUpdate
		Validator::extend( 'parentExist', function ( $attribute, $value, $parameters, $validator ) {
			$menus = Menu::getParent( [
				'lang' => Controller::$param->lang,
				'where' => [
					'`wg_menu`.`id` != ' . Request::input( 'id' )
				]
			] );
			
			// Check parent is in right list
			if ( !array_key_exists( $value, $menus ) )
				return false;
			
			return true;
		} );
		
		// Custom rules MenuUpdateStatus
		Validator::extend( 'menuExist', function ( $attribute, $value, $parameters, $validator ) {
			// Check this category exist in databse or not
			$m = DB::table( 'menu' )->find( $value, [
				'id'
			] );
			
			// Check category exist or not
			if ( count( $m ) == 0 )
				return false;
			
			return true;
		} );
		
		// Custom rules MenuUpdateAll
		Validator::extend( 'menuUpdateAll', function ( $attribute, $value, $parameters, $validator ) {
			$input = Request::all();
			
			// Check posted id is valid or not
			if ( !is_array( $input['arrId'] ) || count( $input['arrId'] ) == 0 ) {
				// ID is not valid
				return false;
			}
			
			// Get all id from this kind of category
			$menus = DB::table( 'menu' )->whereIn( 'menu.id', $input['arrId'] )->get( [
				'id',
				DB::raw( '(SELECT COUNT(*) FROM ' . DB::getTablePrefix() . 'menu subCat WHERE subCat.parent = ' . DB::getTablePrefix() . 'menu.id) AS children' )
			] );
			
			foreach ( $menus as $m ) {
				if ( trim( $input['action'] ) == 'Delete' && ( $m->children > 0 ) ) {
					// This Menu has sub-menu
					return false;
				}
			}
			
			return true;
		} );
		
		// Custom rules MenuUpdatePriority
		Validator::extend( 'menuUpdatePriority', function ( $attribute, $value, $parameters, $validator ) {
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
			$m = DB::table( 'menu' )->find( $input['id'], [
				'parent',
				'priority'
			] );
			if ( count( $m ) == 0 ) {
				// Not found this category in database
				return false;
			}
			
			// Fail to move up at max priority
			if ( $m->priority == 1 && $input['direction'] == 'up' ) {
				// Can't move this category priority up. It gets the maximum priority
				return false;
			}
			
			// Fail to move down at min priority
			$min = DB::table( 'menu' )->where( 'parent', $m->parent )->count();
			if ( $m->priority == $min && $input['direction'] == 'down' ) {
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
