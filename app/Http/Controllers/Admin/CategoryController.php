<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use View, Redirect, DB, Response, Session;
use App\Models\Category;
use App\Http\Requests\Category\UpdateRequest;
use App\Http\Requests\Category\UpdateStatusRequest;
use App\Http\Requests\Category\UpdateAllRequest;
use App\Http\Requests\Category\UpdatePriorityRequest;

class CategoryController extends Controller
{

	static $arrType = [
		'post',
		'banner'
	];

	public function __construct()
	{
		parent::__construct();
		
		if ( !in_array( \Route::input( 'type' ), self::$arrType ) )
			return Redirect::route( 'adminDashboard' )->with( 'message-danger', 'This item doesn\'t exist.' )->send();
	}

	public function all()
	{
		// Get all this type of category
		$categories = Category::getAll( [
			'lang' => self::$param->lang,
			'type' => \Route::input( 'type' ),
			'select' => [
				'category.*',
				'content.title',
				DB::raw( 'IF(priority = 1, true, null) AS max' ),
				DB::raw( 'IF(priority = (SELECT COUNT(*) FROM ' . DB::getTablePrefix() . 'category AS c WHERE c.parent = ' . DB::getTablePrefix() . 'category.parent AND c.type = "' . \Route::input( 'type' ) . '"), true, null) AS min' )
			]
		] );
		
		// Load control button
		$btnControl = $this->loadBtnControl( 'adminCategory', [
			'add',
			'publish',
			'unpublish',
			'delete'
		], [
			'type' => \Route::input( 'type' )
		] );
		
		// Render
		return View::make( 'admin.' . self::$param->controller . '.all', [
			'titlePage' => ucfirst( \Route::input( 'type' ) ) . ' category (' . count( (array) $categories ) . ')',
			'btnControl' => $btnControl,
			'categories' => $categories,
			'types' => self::$arrType,
			'type' => \Route::input( 'type' )
		] );
	}

	public function add()
	{
		// Get all this type of category
		$categories = Category::getParent( [
			'lang' => self::$param->lang,
			'type' => \Route::input( 'type' ),
			'top' => true
		] );
		
		// Load control button
		$btnControl = $this->loadBtnControl( 'adminCategory', [
			'save',
			'saveClose',
			'saveAdd',
			'cancel'
		], [
			'type' => \Route::input( 'type' )
		] );
		
		// Render
		return View::make( 'admin.category.form', [
			'titlePage' => ucfirst( \Route::input( 'type' ) ) . ' category: add',
			'btnControl' => $btnControl,
			'categories' => $categories
		] );
	}

	public function edit()
	{
		// Check this ID exist in database or not
		if ( Category::find( \Route::input( 'id' ) ) === null ) {
			return Redirect::route( 'adminCategory', [
				'type' => \Route::input( 'type' )
			] )->with( 'message-danger', 'Not found this ID in database' );
		}
		
		// Get this category information
		$category = Category::getOne( [
			'lang' => self::$param->lang,
			'id' => \Route::input( 'id' ),
			'type' => \Route::input( 'type' )
		] );
		
		// this category is null => kill
		if ( count( (array) $category ) === 0 ) {
			return Redirect::route( 'adminCategory', [
				'type' => \Route::input( 'type' )
			] )->with( 'message-danger', 'Not found in database.' );
		}
		
		// Get all this type of category
		$categories = Category::getParent( [
			'lang' => self::$param->lang,
			'type' => \Route::input( 'type' ),
			'top' => true,
			'where' => [
				'`wg_category`.`id` != ' . \Route::input( 'id' )
			]
		] );
		
		// Update pageview
		DB::table( 'category' )->where( 'id', '=', \Route::input( 'id' ) )->update( [
			'pageview' => DB::raw( 'pageview + 1' )
		] );
		
		// Load control button
		$btnControl = $this->loadBtnControl( 'adminCategory', [
			'save',
			'saveClose',
			'saveAdd',
			'cancel'
		], [
			'type' => \Route::input( 'type' )
		] );
		
		// Render
		return View::make( 'admin.category.form', [
			'titlePage' => ucfirst( \Route::input( 'type' ) ) . ' category: edit',
			'btnControl' => $btnControl,
			'categories' => $categories,
			'category' => $category,
			'paramCategory' => json_decode( $category->param )
		] );
	}

	public function update( UpdateRequest $r )
	{
		$input = $r->all();
		
		// Count all children from this parent
		$children = DB::table( 'category' )->where( 'parent', $input['parent'] )->where( 'type', \Route::input( 'type' ) )->count();
		
		// Create param JSON
		$strParamSearch = 'param_';
		$arrParam = null;
		foreach ( $r->all() as $k => $v ) {
			if ( preg_match( "/^$strParamSearch/i", $k, $match ) )
				$arrParam[str_replace( $strParamSearch, '', $k )] = $v == true ? true : false;
		}
		$objParam = count( $arrParam ) > 0 ? json_encode( $arrParam ) : null;
		
		if ( $input['action'] == 'add' ) {
			$response['id'] = DB::table( 'category' )->insertGetId( [
				'parent' => (int) $input['parent'],
				'priority' => (int) $children + 1,
				'type' => (string) \Route::input( 'type' ),
				'param' => $objParam,
				'created_at' => DB::raw( 'NOW()' )
			] );
		} else {
			$response['id'] = $input['id'];
			
			// IF change parent => update more data in db
			if ( $input['parent'] != $input['parentOriginal'] ) {
				// Get this category info
				$c = DB::table( 'category' )->find( $response['id'], [
					'parent',
					'priority'
				] );
				
				// update for all > priority for sibling of this category
				DB::table( 'category' )->where( 'parent', $c->parent )->where( 'priority', '>', $c->priority )->update( [
					'priority' => DB::raw( 'priority - 1' )
				] );
				
				// Create some data for update
				$data = [
					'parent' => (int) $input['parent'],
					'priority' => (int) $children + 1
				];
			}
			
			// Add more data for upgrading
			$data = [
				'param' => $objParam,
				'visit' => DB::raw( 'visit + 1' ),
				'pageview' => DB::raw( 'pageview + 1' )
			];
			
			// Update parent => move node wait...
			DB::table( 'category' )->where( 'id', $response['id'] )->update( $data );
		}
		
		// Delete current content in db
		DB::table( 'content' )->where( 'id', $response['id'] )->where( 'tbl', 'category' )->delete();
		
		// Update content in db
		foreach ( self::$param->languages as $lang ) {
			DB::table( 'content' )->insert( [
				'id' => $response['id'],
				'lang' => $lang->code,
				'tbl' => 'category',
				'title' => ucfirst( strip_tags( $input['title' . strtoupper( $lang->code )] ) ),
				'alias' => str_slug( $input['title' . strtoupper( $lang->code )] )
			] );
		}
		
		$response['message'] = [
			'Update ' . strtolower( self::$param->controller ) . ' completed!!'
		];
		Session::flash( 'message-success', implode( "\n", $response['message'] ) );
		
		return Response::json( $response );
	}

	public function updateStatus( UpdateStatusRequest $r )
	{
		$input = $r->all();
		$response['id'] = $input['id'];
		$response['action'] = $input['action'] == 'active' ? 'deactive' : 'active';
		
		DB::table( strtolower( self::$param->controller ) )->where( 'status', $input['action'] )->where( 'id', $input['id'] )->update( [
			'status' => $response['action']
		] );
		$response['view'] = (string) View::make( 'admin.common.status', [
			'status' => $response['action']
		] );
		
		return Response::json( $response );
	}

	public function updateAll( UpdateAllRequest $r )
	{
		$input = $r->all();
		$response = [
			'action' => $input['action'],
			'arrId' => $input['arrId']
		];
		
		// Make plural
		$controller = str_plural( self::$param->controller, count( $response['arrId'] ) );
		
		// No error => Process
		
		if ( $input['action'] != 'Delete' ) {
			$response['action'] = $input['action'] == 'Publish' ? 'active' : 'deactive';
			$response['actionStatus'] = $input['action'] == 'Publish' ? 'deactive' : 'active';
			
			DB::table( 'category' )->where( 'status', $response['actionStatus'] )->whereIn( 'id', $input['arrId'] )->update( [
				'status' => $response['action']
			] );
			$response['view'] = (string) View::make( 'admin.common.status', [
				'status' => $response['action']
			] );
		} else {
			// Get this category parent for update priority
			$c = DB::table( 'category' )->whereIn( 'id', $input['arrId'] )->orderBy( 'priority' )->get( [
				'parent',
				'priority'
			] );
			// dd( $c, $response );
			DB::transaction( function () use ($c, $input ) {
				// update priority > this category
				DB::table( 'category' )->where( 'type', \Route::input( 'type' ) )->where( 'parent', $c[0]->parent )->where( 'priority', '>=', $c[0]->priority )->orderBy( 'priority' )->update( [
					'priority' => DB::raw( '`priority` - ' . count( $c ) )
				] );
				
				// delete data in both category & content db
				DB::table( 'category' )->whereIn( 'id', $input['arrId'] )->delete();
				DB::table( 'content' )->whereIn( 'id', $input['arrId'] )->where( 'tbl', 'category' )->delete();
			} );
			
			Session::flash( 'message-warning', $response['action'] . ' ' . $controller . ' successful!!' );
		}
		
		$response['message'] = [
			ucwords( $response['action'] ) . ' ' . $controller . ' successful!!'
		];
		
		return Response::json( $response );
	}

	public function updatePriority( UpdatePriorityRequest $r )
	{
		$input = $r->all();
		
		$c = DB::table( 'category' )->find( $input['id'], [
			'id',
			'parent',
			'priority'
		] );
		
		// Save to database
		switch ( $input['direction'] ) {
			case 'up' :
				$p = DB::transaction( function () use ($c ) {
					// update for current priority
					$p = $c->priority - 1;
					DB::table( 'category' )->where( 'parent', $c->parent )->where( 'priority', $p )->update( [
						'priority' => $c->priority
					] );
					
					// Update for this category priority
					DB::table( 'category' )->where( 'id', $c->id )->update( [
						'priority' => $p
					] );
					
					return $p;
				} );
				
				break;
			case 'down' :
				$p = DB::transaction( function () use ($c ) {
					// update for current priority
					$p = $c->priority + 1;
					DB::table( 'category' )->where( 'parent', $c->parent )->where( 'priority', $p )->update( [
						'priority' => $c->priority
					] );
					
					// Update for this category priority
					DB::table( 'category' )->where( 'id', $c->id )->update( [
						'priority' => $p
					] );
					
					return $p;
				} );
				
				break;
		}
		
		// Check related category have children or not => RELOAD the page
		$data['relatedCategoryId'] = DB::table( 'category' )->where( 'parent', $c->parent )->where( 'priority', $c->priority )->pluck( 'id' )[0];
		$data['categoryChildren'] = DB::table( 'category' )->where( 'parent', $data['relatedCategoryId'] )->orWhere( 'parent', $input['id'] )->count();
		$response['reloaded'] = $data['categoryChildren'] > 0 ? true : false;
		
		// Update view for related category
		$response['viewRelated'] = (string) View::make( 'admin.common.priority', [
			'priority' => $c->priority,
			'min' => $c->priority == DB::table( 'category' )->where( 'parent', $c->parent )->count() ? true : false,
			'max' => $c->priority == 1 ? true : false
		] );
		
		// Update view for current category
		$response['view'] = (string) View::make( 'admin.common.priority', [
			'priority' => $p,
			'min' => $p == DB::table( 'category' )->where( 'parent', $c->parent )->count() ? true : false,
			'max' => $p == 1 ? true : false
		] );
		
		if ( $response['reloaded'] == true )
			Session::flash( 'message-success', 'Update category priority!!' );
		
		return Response::json( $response );
	}
}
