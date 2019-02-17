<?php

namespace App\Providers\Admin;

use Illuminate\Support\ServiceProvider;
use Request, DB, Validator;
use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryServiceProvider extends ServiceProvider
{

	/**
	 * Bootstrap the application services.
	 * 
	 * @return void
	 */
	public function boot()
	{
		// Custom rules CategoryUpdate
		Validator::extend( 'categoryUpdateParent', function ( $attribute, $value, $parameters, $validator ) {
			$categories = Category::getParent( [
				'lang' => Controller::$param->lang,
				'type' => Request::route( 'type' ),
				'where' => [
					'`wg_category`.`id` != ' . Request::input( 'id' )
				]
			] );
			
			// Check parent is in right list && not on top
			return ( $value === 0 && !array_key_exists( $value, $categories ) ) ? false : true;
		} );
		
		// Custom rules CategoryUpdateStatus
		Validator::extend( 'categoryExist', function ( $attribute, $value, $parameters, $validator ) {
			// Check this category exist in databse or not
			$c = DB::table( 'category' )->find( $value, [
				'id'
			] );
			
			// Check category exist or not
			if ( count( $c ) == 0 )
				return false;
			
			return true;
		} );
		
		// Custom rules CategoryUpdateAll
		Validator::extend( 'categoryUpdateAll', function ( $attribute, $value, $parameters, $validator ) {
			$input = Request::all();
			
			// Check posted id is valid or not
			if ( !is_array( $input['arrId'] ) || count( $input['arrId'] ) == 0 ) {
				// ID is not valid
				return false;
			}
			
			// Get all id from this kind of category
			$categories = DB::table( 'category' )->where( 'category.type', Request::route( 'type' ) )->whereIn( 'category.id', $input['arrId'] )->get( [
				'id',
				DB::raw( '(SELECT COUNT(*) FROM ' . DB::getTablePrefix() . 'category subCat WHERE subCat.parent = ' . DB::getTablePrefix() . 'category.id) AS children' ),
				DB::raw( '(SELECT COUNT(*) FROM ' . DB::getTablePrefix() . 'post p WHERE p.category = ' . DB::getTablePrefix() . 'category.id) AS posts' )
			] );
			
			foreach ( $categories as $c ) {
				if ( trim( $input['action'] ) == 'Delete' && ( $c->children > 0 || $c->posts > 0 ) ) {
					// This Category has sub-category
					// This category has posts inside
					return false;
				}
			}
			
			return true;
		} );
		
		// Custom rules CategoryUpdatePriority
		Validator::extend( 'categoryUpdatePriority', function ( $attribute, $value, $parameters, $validator ) {
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
			$c = DB::table( 'category' )->find( $input['id'], [
				'parent',
				'priority'
			] );
			if ( count( $c ) == 0 ) {
				// Not found this category in database
				return false;
			}
			
			// Fail to move up at max priority
			if ( $c->priority == 1 && $input['direction'] == 'up' ) {
				// Can't move this category priority up. It gets the maximum priority
				return false;
			}
			
			// Fail to move down at min priority
			$min = DB::table( 'category' )->where( 'parent', $c->parent )->count();
			if ( $c->priority == $min && $input['direction'] == 'down' ) {
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
