<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use View, DB, Response, Session, Redirect, Request;
use App\Models\Widget;
use App\Models\Filter;
use App\Http\Requests\Widget\UpdateRequest;
use App\Http\Requests\Widget\UpdateStatusRequest;
use App\Http\Requests\Widget\UpdateAllRequest;
use App\Http\Requests\Widget\UpdatePriorityRequest;

class WidgetController extends Controller
{

	static $arrPosition;

	public function __construct()
	{
		parent::__construct();
		
		// Get all widget position
		$widgetFile = resource_path( 'widgets/Admin/widget.position.php' );
		foreach ( \File::getRequire( $widgetFile ) as $i => $w ) {
			self::$arrPosition[camel_case( $w )] = $w;
		}
	}

	public function position()
	{
		return View::make( 'admin.' . self::$param->controller . '.position', [
			'titlePage' => 'Widget position',
			'position' => self::$arrPosition
		] );
	}

	public function all()
	{
		// Get all widget
		$widget = Widget::getAll( [
			'lang' => self::$param->lang,
			'limit' => self::$setting->itemPerPage,
			'select' => [
				'widget.*',
				'content.title',
				DB::raw( 'IF(priority = 1, true, null) AS max' ),
				DB::raw( 'IF(priority = (SELECT COUNT(*) FROM ' . DB::getTablePrefix() . 'widget AS w WHERE w.position = ' . DB::getTablePrefix() . 'widget.position), true, null) AS min' )
			],
			'where' => Filter::makeQuery( [
				'queryString' => Request::getQueryString(),
				'controller' => self::$param->controller,
				'type' => 'where'
			] ),
			'order' => Filter::makeQuery( [
				'queryString' => Request::getQueryString(),
				'controller' => self::$param->controller,
				'type' => 'order'
			] )
		] );
		
		// Set custom path for pagination
		$widget->setPath( route( 'adminWidget', [
			'keyword' => Request::input( 'keyword' ),
			'position' => Request::input( 'position' ),
			'type' => Request::input( 'type' ),
			'status' => Request::input( 'status' )
		] ) );
		
		// Load control button
		$btnControl = $this->loadBtnControl( 'adminWidget', [
			'add',
			'publish',
			'unpublish',
			'delete'
		] );
		
		// Get all article statistic
		$statistic = Widget::statistic();
		
		// Render
		return View::make( 'admin.' . self::$param->controller . '.all', [
			'titlePage' => 'Widget manager (' . $statistic->total . ')',
			'titlePageExtra' => $statistic->totalActive . ' active | ' . $statistic->totalDeactive . ' deactive',
			'btnControl' => $btnControl,
			'widgets' => $widget,
			'filter' => [
				'keywordVal' => Request::input( 'keyword' ),
				'status' => Filter::Status(),
				'statusVal' => Request::input( 'status' ),
				'position' => Filter::Position( self::$arrPosition ),
				'positionVal' => Request::input( 'position' ),
				'type' => Filter::WidgetType(),
				'typeVal' => Request::input( 'type' )
			]
		] );
	}

	public function add()
	{
		// Get all widget plugins
		$arrWg = $arrWgType = [];
		$extPath = app_path( 'Http/Widgets/Admin' );
		foreach ( glob( $extPath . '/*' ) as $i => $file ) {
			$arrWg[$i] = \File::getRequire( $file );
			$arrWgType[str_slug( $arrWg[$i]['label'] )] = $arrWg[$i]['label'];
		}
		
		// If not recognize widget-type ===> Let's choose widget-type first...
		if ( empty( \Route::input( 'type' ) ) || !key_exists( \Route::input( 'type' ), $arrWgType ) ) {
			$data = [
				'titlePage' => 'Widget: add',
				'btnControl' => $this->loadBtnControl( 'adminWidget', [
					'cancel'
				] ),
				'types' => $arrWg
			];
			
			return View::make( 'admin.' . self::$param->controller . '.type', $data );
		} else {
			// Get type detail
			$titleType = ucfirst( str_replace( '-', ' ', \Route::input( 'type' ) ) );
			foreach ( $arrWg as $w ) {
				if ( $w['label'] == $titleType )
					$typeDetail = $w;
			}
			
			// return if route is not declare
			if ( isset( $typeDetail ) && count( $typeDetail ) == 0 ) {
				return Redirect::route( 'adminWidget' )->with( 'message-danger', 'Not found this widget.' );
			}
			
			// Load control button
			$btnControl = $this->loadBtnControl( 'adminWidget', [
				'save',
				'saveClose',
				'saveAdd',
				'cancel'
			] );
			
			// Render
			return View::make( 'admin.' . self::$param->controller . '.form', [
				'titlePage' => 'Widget: add — ' . $titleType,
				'btnControl' => $btnControl,
				'typeDetail' => $typeDetail,
				'positions' => self::$arrPosition,
				'assignments' => $this->assignment()
			] );
		}
	}

	public function edit()
	{
		// Check this ID exist in database or not
		if ( Widget::find( \Route::input( 'id' ) ) === null ) {
			return Redirect::route( 'adminWidget' )->with( 'message-danger', 'Not found this ID in database' );
		}
		
		// Get this widget information
		$widget = Widget::getOne( [
			'lang' => self::$param->lang,
			'id' => \Route::input( 'id' )
		] );
		
		// Set visible zone for responsive
		$visibleZone = (array) json_decode( $widget->visible_zone );
		
		// Get type detail
		$typeDetail = \File::getRequire( app_path( 'Http/Widgets/Admin/' . $widget->type . '.php' ) );
		
		// Load control button
		$btnControl = $this->loadBtnControl( 'adminWidget', [
			'save',
			'saveClose',
			'saveAdd',
			'cancel'
		] );
		
		// Render
		return View::make( 'admin.' . self::$param->controller . '.form', [
			'titlePage' => 'Widget: edit — ' . $widget->type,
			'btnControl' => $btnControl,
			'typeDetail' => $typeDetail,
			'positions' => self::$arrPosition,
			'assignments' => $this->assignment( $widget->assignment ),
			'widget' => $widget,
			'arrVisibleZone' => $visibleZone
		] );
	}

	public function assignment( $value = null )
	{
		// Do with default value
		if ( $value != 'all' ) {
			$final['value'] = !empty( $value ) ? explode( ',', $value ) : [];
		} else {
			$final['all'] = $value;
		}
		
		// Get assignment
		$assignmentPath = resource_path( 'widgets/Admin/widget.assignment.php' );
		$assignment = \File::getRequire( $assignmentPath );
		foreach ( $assignment as $a ) {
			$valueOption = $a['controller'] . ( isset( $a['action'] ) && !empty( $a['action'] ) ? '_' . $a['action'] : null );
			
			$final['options'][$valueOption] = (string) $a['label'];
			
			// Expand children in category here
			if ( isset( $a['model'] ) && isset( $a['class'] ) ) {
				$model = str_replace( '/', '\\', $a['model'] );
				$class = $a['class'];
				
				$categories = $model::$class( [
					'lang' => self::$param->lang,
					'parent' => 0,
					'separate' => '|—'
				] );
				
				$childrenData = [];
				if ( count( $categories ) > 0 ) {
					foreach ( $categories as $category ) {
						foreach ( $category as $id => $c ) {
							if ( $id > 0 ) // Prevent first element of category array
								$childrenData[$a['controller'] . '_' . $id] = $c;
						}
					}
				}
				
				$final['options'][ucfirst( $a['controller'] )] = $childrenData;
			}
		}
		
		// Set assignment set menu item
		$arrRoute = $menuArray = [];
		$routes = \Route::getRoutes();
		foreach ( $routes as $r ) {
			if ( !empty( $r->getName() ) && strpos( $r->getName(), 'admin' ) === false ) {
				$arrRoute[] = $r->getName();
			}
		}
		
		// Remove all empty value & Create search in database
		$arrMenuWhere = implode( '","', $arrRoute );
		
		$menuData = \App\Models\Menu::getAll( [
			'lang' => self::$param->lang,
			'where' => [
				'`route` IN ("' . $arrMenuWhere . '")'
			]
		] );
		
		if ( count( $menuData ) > 0 ) {
			foreach ( $menuData as $menu ) {
				if ( $menu->id != 100 ) // For homepage
					$menuArray[snake_case( $menu->route . '_' . $menu->data )] = $menu->title;
			}
			
			$final['options']['Menu assignment'] = $menuArray;
		}
		// End set assignment set menu item
		
		return $final;
	}

	public function update( UpdateRequest $r )
	{
		$input = $r->all();
		
		// Setup visible zone
		$arrVisibleZone = [];
		$arrVisibleZoneField = explode( ',', $input['visibleZoneField'] );
		foreach ( $arrVisibleZoneField as $z ) {
			$arrVisibleZone[$z] = $input[$z] == true ? true : false;
		}
		
		// Setup parameter
		$parameter = [];
		foreach ( explode( ',', $input['parameterField'] ) as $p ) {
			$p = str_replace( '[]', '', $p );
			
			$parameter[$p] = isset( $input[$p] ) ? $input[$p] : null;
		}
		$parameter = json_encode( $parameter );
		
		// Setup assignment
		if ( $input['selectAssignment'] == 'all' ) {
			$assignment = 'all';
		} else {
			$assignment = [];
			foreach ( $input['assignment'] as $a ) {
				$parttern = '_([0-9])';
				preg_match( '#^([a-z])_([a-z])_' . $parttern . '$#i', $a, $match );
				$assignment[] = $a;
			}
			$assignment = implode( ',', $input['assignment'] );
		}
		
		// Count all children from this parent
		$children = DB::table( 'widget' )->where( 'position', $input['position'] )->count();
		if ( $input['action'] == 'add' ) {
			$response['id'] = DB::table( 'widget' )->insertGetId( [
				'priority' => ( $children + 1 ),
				'position' => $input['position'],
				'status' => $input['status'],
				'type' => $input['type'],
				'show_title' => $input['show_title'],
				'show_content' => $input['show_content'],
				'visible_zone' => json_encode( $arrVisibleZone ),
				'assignment' => $assignment,
				'param' => $parameter,
				'created_at' => DB::raw( 'NOW()' )
			] );
		} else {
			$response['id'] = $input['id'];
			
			// Update parent => move node wait...
			DB::table( 'widget' )->where( 'id', $response['id'] )->update( [
				'status' => $input['status'],
				'show_title' => $input['show_title'],
				'show_content' => $input['show_content'],
				'visible_zone' => json_encode( $arrVisibleZone ),
				'assignment' => $assignment,
				'param' => $parameter
			] );
			
			// Update position & priority when changing
			$e = DB::table( 'widget' )->find( $input['id'] );
			if ( $e->position != $input['position'] ) {
				DB::transaction( function () use ($e, $input ) {
					// update priority > this extesion
					DB::table( self::$param->controller )->where( 'position', $e->position )->where( 'priority', '>', $e->priority )->orderBy( 'priority' )->update( [
						'priority' => DB::raw( '`priority` - 1' )
					] );
					
					DB::table( self::$param->controller )->where( 'id', $input['id'] )->update( [
						'position' => $input['position'],
						'priority' => ( DB::table( self::$param->controller )->where( 'position', $input['position'] )->count() + 1 )
					] );
				} );
			}
		}
		
		// Delete current content in db
		DB::table( 'content' )->where( 'id', $response['id'] )->where( 'tbl', 'widget' )->delete();
		
		// Update content in db
		foreach ( self::$param->languages as $lang ) {
			DB::table( 'content' )->insert( [
				'id' => $response['id'],
				'lang' => $lang->code,
				'tbl' => 'widget',
				'title' => ucfirst( strip_tags( $input['title' . strtoupper( $lang->code )] ) ),
				'alias' => str_slug( $input['title' . strtoupper( $lang->code )] ),
				'content' => isset( $input['content' . strtoupper( $lang->code )] ) ? $input['content' . strtoupper( $lang->code )] : null
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
			
			DB::table( self::$param->controller )->where( 'status', $response['actionStatus'] )->whereIn( 'id', $input['arrId'] )->update( [
				'status' => $response['action']
			] );
			$response['view'] = (string) View::make( 'admin.common.status', [
				'status' => $response['action']
			] );
		} else {
			// Get this widget position for update priority
			$e = DB::table( self::$param->controller )->whereIn( 'id', $input['arrId'] )->orderBy( 'priority' )->get( [
				'position',
				'priority'
			] );
			
			DB::transaction( function () use ($e, $input ) {
				// update priority > this extesion
				DB::table( self::$param->controller )->where( 'position', $e[0]->position )->where( 'priority', '>=', $e[0]->priority )->orderBy( 'priority' )->update( [
					'priority' => DB::raw( '`priority` - ' . count( $e ) )
				] );
				
				// delete data in both menu & content db
				DB::table( 'widget' )->whereIn( 'id', $input['arrId'] )->delete();
				DB::table( 'content' )->whereIn( 'id', $input['arrId'] )->where( 'tbl', 'widget' )->delete();
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
		$tbl = 'widget';
		$input = $r->all();
		
		$e = DB::table( $tbl )->find( $input['id'], [
			'id',
			'position',
			'priority'
		] );
		
		// Save to database
		switch ( $input['direction'] ) {
			case 'up' :
				$p = DB::transaction( function () use ($e, $tbl ) {
					// update for current priority
					$p = $e->priority - 1;
					DB::table( $tbl )->where( 'position', $e->position )->where( 'priority', $p )->update( [
						'priority' => $e->priority
					] );
					
					// Update for this menu priority
					DB::table( $tbl )->where( 'id', $e->id )->update( [
						'priority' => $p
					] );
					
					return $p;
				} );
				
				break;
			case 'down' :
				$p = DB::transaction( function () use ($e, $tbl ) {
					// update for current priority
					$p = $e->priority + 1;
					DB::table( $tbl )->where( 'position', $e->position )->where( 'priority', $p )->update( [
						'priority' => $e->priority
					] );
					
					// Update for this menu priority
					DB::table( $tbl )->where( 'id', $e->id )->update( [
						'priority' => $p
					] );
					
					return $p;
				} );
				
				break;
		}
		
		// Check related widget have children or not => RELOAD the page
		$data['relatedId'] = DB::table( $tbl )->where( 'position', $e->position )->where( 'priority', $e->priority )->pluck( 'id' )[0];
		$data[$tbl . 'Children'] = DB::table( $tbl )->where( 'position', $data['relatedId'] )->orWhere( 'position', $input['id'] )->count();
		$response['reloaded'] = $data[$tbl . 'Children'] > 0 ? true : false;
		
		// Update view for related menu
		$response['viewRelated'] = (string) View::make( 'admin.common.priority', [
			'priority' => $e->priority,
			'min' => $e->priority == DB::table( $tbl )->where( 'position', $e->position )->count() ? true : false,
			'max' => $e->priority == 1 ? true : false
		] );
		
		// Update view for current menu
		$response['view'] = (string) View::make( 'admin.common.priority', [
			'priority' => $p,
			'min' => $p == DB::table( $tbl )->where( 'position', $e->position )->count() ? true : false,
			'max' => $p == 1 ? true : false
		] );
		
		if ( $response['reloaded'] == true )
			Session::flash( 'message-success', 'Update ' . $tbl . ' priority!!' );
		
		return Response::json( $response );
	}
}