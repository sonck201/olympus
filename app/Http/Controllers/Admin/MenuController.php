<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use View, DB, Response, Session, Request, Redirect;
use App\Models\Menu;
use App\Http\Requests\Menu\UpdateRequest;
use App\Http\Requests\Menu\UpdateStatusRequest;
use App\Http\Requests\Menu\UpdateAllRequest;
use App\Http\Requests\Menu\UpdatePriorityRequest;

class MenuController extends Controller
{

	static $appModel;

	static $appClass;

	static $appType;

	static $appPrefix;

	static $appPage;

	static $arrType;

	public function __construct()
	{
		parent::__construct();
		
		$r = Request::all();
		
		self::$appModel = isset( $r['appModel'] ) ? str_replace( '/', '\\', $r['appModel'] ) : null;
		self::$appClass = isset( $r['appClass'] ) ? $r['appClass'] : null;
		self::$appType = isset( $r['appType'] ) ? $r['appType'] : null;
		self::$appPrefix = isset( $r['appPrefix'] ) ? $r['appPrefix'] : null;
		self::$appPage = isset( $r['appPage'] ) ? $r['appPage'] : 1;
		
		// unless recognize menu-type ===> Let's choose menu-type first...
		$arrAct = [
			'add',
			'edit'
		];
		if ( in_array( self::$param->action, $arrAct ) ) {
			// Get all menu type
			self::$arrType = $this->getArrType();
		}
	}

	public function all()
	{
		// Get all menu
		$menu = Menu::getAll( [
			'lang' => self::$param->lang,
			'select' => [
				'menu.*',
				'content.title',
				DB::raw( 'IF(priority = 1, true, null) AS max' ),
				DB::raw( 'IF(priority = (SELECT COUNT(*) FROM ' . DB::getTablePrefix() . 'menu AS mm WHERE mm.parent = ' . DB::getTablePrefix() . 'menu.parent), true, null) AS min' )
			]
		] );
		
		// Load control button
		$btnControl = $this->loadBtnControl( 'adminMenu', [
			'add',
			'publish',
			'unpublish',
			'delete'
		] );
		
		// Render data to view
		$data = [
			'titlePage' => 'Menu manager (' . count( (array) $menu ) . ')',
			'btnControl' => $btnControl,
			'menus' => $menu
		];
		return View::make( 'admin.' . self::$param->controller . '.all', $data );
	}

	protected function getArrType()
	{
		// Get all menu type & push to array
		$menuType = resource_path( 'widgets/Admin/menu.type.php' );
		$arrType = [];
		foreach ( \File::getRequire( $menuType ) as $m )
			$arrType[] = json_decode( json_encode( $m, true ) );
		
		return $arrType;
	}

	public function add()
	{
		// Load choose-type page unless identify menu-type
		if ( empty( \Route::input( 'type' ) ) || !in_array( \Route::input( 'type' ), array_pluck( self::$arrType, 'alias' ) ) ) {
			return View::make( 'admin.' . self::$param->controller . '.type', [
				'titlePage' => 'Menu: ' . self::$param->action,
				'btnControl' => $this->loadBtnControl( 'adminMenu', [
					'cancel'
				] ),
				'types' => array_values( array_sort( self::$arrType, function ( $value ) {
					return $value->label;
				} ) )
			] );
		}
		
		// Get type detail
		$titleType = ucfirst( str_replace( '-', ' ', \Route::input( 'type' ) ) );
		foreach ( self::$arrType as $t ) {
			if ( $t->label == $titleType ) {
				$typeDetail = $t;
			}
		}
		
		// return if route is not declare
		if ( isset( $typeDetail->route ) && !\Route::has( $typeDetail->route ) ) {
			return Redirect::route( 'adminMenu' )->with( 'message-danger', 'Route name not declare in ' . self::$param->controller . ucwords( self::$param->action ) . '.' );
		}
		
		// Get all menu
		$menus = Menu::getParent( [
			'lang' => self::$param->lang
		] );
		
		// Load control button
		$btnControl = $this->loadBtnControl( 'adminMenu', [
			'save',
			'saveClose',
			'saveAdd',
			'cancel'
		] );
		
		// Render
		return View::make( 'admin.' . self::$param->controller . '.form', [
			'titlePage' => 'Menu: add — ' . $titleType,
			'btnControl' => $btnControl,
			'typeDetail' => $typeDetail,
			'menus' => $menus
		] );
	}

	public function edit()
	{
		// Check this ID exist in database or not
		if ( Menu::find( \Route::input( 'id' ) ) === null || \Route::input( 'id' ) == 100 ) {
			return Redirect::route( 'adminMenu' )->with( 'message-danger', 'Not found this ID in database' );
		}
		
		// Load choose-type page unless identify menu-type
		if ( empty( \Route::input( 'type' ) ) || !in_array( \Route::input( 'type' ), array_pluck( self::$arrType, 'alias' ) ) ) {
			return View::make( 'admin.' . self::$param->controller . '.type', [
				'titlePage' => 'Menu: ' . self::$param->action,
				'btnControl' => $this->loadBtnControl( 'adminMenu', [
					'cancel'
				] ),
				'types' => array_values( array_sort( self::$arrType, function ( $value ) {
					return $value->label;
				} ) ),
				'id' => \Route::input( 'id' )
			] );
		}
		
		// Get this menu information
		$menu = Menu::getOne( [
			'lang' => self::$param->lang,
			'id' => \Route::input( 'id' )
		] );
		
		// Get type detail
		$titleType = ucfirst( str_replace( '-', ' ', \Route::input( 'type' ) ) );
		foreach ( self::$arrType as $t ) {
			if ( $t->label == $titleType ) {
				$typeDetail = $t;
			}
		}
		
		// Get all menu
		$menus = Menu::getParent( [
			'lang' => self::$param->lang,
			'where' => [
				'`wg_menu`.`id` != ' . \Route::input( 'id' )
			]
		] );
		
		// Load control button
		$btnControl = $this->loadBtnControl( 'adminMenu', [
			'save',
			'saveClose',
			'saveAdd',
			'cancel'
		] );
		
		// Render data to view
		$data = [
			'titlePage' => 'Menu: edit — ' . $titleType,
			'btnControl' => $btnControl,
			'menus' => $menus,
			'menu' => $menu,
			'typeDetail' => $typeDetail
		];
		
		return View::make( 'admin.menu.form', $data );
	}

	public function getData()
	{
		return View::make( 'admin.menu.get-data', [
			'title' => Request::get( 'appTitle' ),
			'appPage' => self::$appPage,
			'showMore' => ( strpos( self::$appModel, 'Category' ) !== false ? false : true ),
			'data' => $this->getDataModel( self::$appModel, self::$appClass, self::$appPrefix, self::$appType, self::$appPage )
		] );
	}

	public function getDataMore()
	{
		return View::make( 'admin.menu.get-data-row', [
			'title' => \Request::get( 'appTitle' ),
			'data' => $this->getDataModel( self::$appModel, self::$appClass, self::$appPrefix, self::$appType, self::$appPage )
		] );
	}

	public function getDataModel( $appModel, $appClass, $appPrefix, $appType = null, $appPage )
	{
		$arrSelect = [
			$appPrefix . 'id',
			$appPrefix . 'title'
		];
		
		if ( strpos( $appModel, 'Category' ) !== false ) {
			array_push( $arrSelect, 'parent' );
			$arrWhere = [
				'`status` = "active"'
			];
		} else {
			array_push( $arrSelect, 'format' );
			
			// Get type
			preg_match( '/[^\\\\]+$/', $appModel, $match );
			
			$arrWhere = [
				'`' . DB::getTablePrefix() . strtolower( $match[0] ) . '`.`status` = "active"'
			];
		}
		
		$data = $appModel::$appClass( [
			'lang' => self::$param->lang,
			'type' => $appType,
			'select' => $arrSelect,
			'where' => $arrWhere,
			'limit' => ( $appPage * self::$setting->itemPerPage )
		] );
		
		return $data;
	}

	public function update( UpdateRequest $r )
	{
		$input = $r->all();
		
		// Count all children from this parent
		$children = DB::table( 'menu' )->where( 'parent', $input['parent'] )->count();
		if ( $input['action'] == 'add' ) {
			$response['id'] = DB::table( 'menu' )->insertGetId( [
				'parent' => $input['parent'],
				'priority' => $children + 1,
				'type' => $input['type'],
				'status' => $input['status'],
				'open_in' => $input['open_in'],
				'class' => !empty( $input['class'] ) ? $input['class'] : null,
				'width_column' => $input['width_column'],
				'max_column' => $input['max_column'],
				'show_title' => $input['show_title'],
				'route' => ( isset( $input['route'] ) && \Route::has( $input['route'] ) ? $input['route'] : null ),
				'data' => ( isset( $input['data'] ) && !empty( $input['data'] ) ? $input['data'] : null ),
				'created_at' => DB::raw( 'NOW()' )
			] );
		} else {
			$response['id'] = $input['id'];
			
			// Update parent => move node wait...
			DB::table( 'menu' )->where( 'id', $response['id'] )->update( [
				'status' => $input['status'],
				'type' => $input['type'],
				'open_in' => $input['open_in'],
				'class' => !empty( $input['class'] ) ? $input['class'] : null,
				'width_column' => $input['width_column'],
				'max_column' => $input['max_column'],
				'show_title' => $input['show_title'],
				'data' => ( isset( $input['data'] ) && !empty( $input['data'] ) ? $input['data'] : null )
			] );
		}
		
		// Delete current content in db
		DB::table( 'content' )->where( 'id', $response['id'] )->where( 'tbl', 'menu' )->delete();
		
		// Update content in db
		foreach ( self::$param->languages as $lang ) {
			DB::table( 'content' )->insert( [
				'id' => $response['id'],
				'lang' => $lang->code,
				'tbl' => 'menu',
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
			
			DB::table( 'menu' )->where( 'status', $response['actionStatus'] )->whereIn( 'id', $input['arrId'] )->update( [
				'status' => $response['action']
			] );
			$response['view'] = (string) View::make( 'admin.common.status', [
				'status' => $response['action']
			] );
		} else {
			// Get this menu parent for update priority
			$m = DB::table( 'menu' )->whereIn( 'id', $input['arrId'] )->orderBy( 'priority' )->get( [
				'parent',
				'priority'
			] );
			
			DB::transaction( function () use ($m, $input ) {
				// update priority > this menu
				DB::table( 'menu' )->where( 'parent', $m[0]->parent )->where( 'priority', '>=', $m[0]->priority )->orderBy( 'priority' )->update( [
					'priority' => DB::raw( '`priority` - ' . count( $m ) )
				] );
				
				// delete data in both menu & content db
				DB::table( 'menu' )->where( 'id', '!=', 100 )->whereIn( 'id', $input['arrId'] )->delete();
				DB::table( 'content' )->where( 'id', '!=', 100 )->whereIn( 'id', $input['arrId'] )->where( 'tbl', 'menu' )->delete();
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
		$tbl = 'menu';
		$input = $r->all();
		
		$m = DB::table( $tbl )->find( $input['id'], [
			'id',
			'parent',
			'priority'
		] );
		
		// Save to database
		switch ( $input['direction'] ) {
			case 'up' :
				$p = DB::transaction( function () use ($m, $tbl ) {
					// update for current priority
					$p = $m->priority - 1;
					DB::table( $tbl )->where( 'parent', $m->parent )->where( 'priority', $p )->update( [
						'priority' => $m->priority
					] );
					
					// Update for this menu priority
					DB::table( $tbl )->where( 'id', $m->id )->update( [
						'priority' => $p
					] );
					
					return $p;
				} );
				
				break;
			case 'down' :
				$p = DB::transaction( function () use ($m, $tbl ) {
					// update for current priority
					$p = $m->priority + 1;
					DB::table( $tbl )->where( 'parent', $m->parent )->where( 'priority', $p )->update( [
						'priority' => $m->priority
					] );
					
					// Update for this menu priority
					DB::table( $tbl )->where( 'id', $m->id )->update( [
						'priority' => $p
					] );
					
					return $p;
				} );
				
				break;
		}
		
		// Check related menu have children or not => RELOAD the page
		$data['relatedId'] = DB::table( $tbl )->where( 'parent', $m->parent )->where( 'priority', $m->priority )->pluck( 'id' )[0];
		$data[$tbl . 'Children'] = DB::table( $tbl )->where( 'parent', $data['relatedId'] )->orWhere( 'parent', $input['id'] )->count();
		$response['reloaded'] = $data[$tbl . 'Children'] > 0 ? true : false;
		
		// Update view for related menu
		$response['viewRelated'] = (string) View::make( 'admin.common.priority', [
			'priority' => $m->priority,
			'min' => $m->priority == DB::table( $tbl )->where( 'parent', $m->parent )->count() ? true : false,
			'max' => $m->priority == 1 ? true : false
		] );
		
		// Update view for current menu
		$response['view'] = (string) View::make( 'admin.common.priority', [
			'priority' => $p,
			'min' => $p == DB::table( $tbl )->where( 'parent', $m->parent )->count() ? true : false,
			'max' => $p == 1 ? true : false
		] );
		
		if ( $response['reloaded'] == true )
			Session::flash( 'message-success', 'Update ' . $tbl . ' priority!!' );
		
		return Response::json( $response );
	}
}