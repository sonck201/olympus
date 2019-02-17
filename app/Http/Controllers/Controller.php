<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Language;
use Route, DB, View, Request;
use App\Classes\Helper;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	static $param;

	static $setting;

	static $user;

	static $zone;
	
	// Preload some data
	public function __construct()
	{
		// Setup & publish setting to all controller & view
		self::$setting = json_decode( DB::table( 'misc' )->pluck( 'setting' )[0] );
		View::share( 'setting', self::$setting );
		
		// Setup session lifetime
		\Config::set( 'session.lifetime', self::$setting->sessionExpire );
		
		// Setup param object
		$this->setParam();
		
		// Setup userOnline
		View::share( 'userOnline', $this->userOnline( self::$param->module === 'Admin' ? true : false ) );
		
		// Set default title
		View::share( 'titlePage', self::$setting->siteName );
		
		// Publish alerts
		View::share( 'alerts', [
			'success',
			'info',
			'warning',
			'danger'
		] );
		
		// Process in admin Module
		if ( self::$param->module == 'Admin' ) {
			// Return when this action is not a real AJAX request
			$arrActlist = [
				'update',
				'updateStatus',
				'updateAll'
			];
			
			if ( in_array( self::$param->action, $arrActlist ) ) {
				if ( !Request::ajax() )
					return View::make( 'admin.error.ajax-direct-access' );
			}
			
			// Get version info
			View::share( 'cmsVersion', file_get_contents( base_path( 'version.log' ) ) . date( '.yW' ) );
			
			// Get menu
			View::share( 'mainMenu', $this->getMenu() );
		} else {
			// Get menu
			$menu = \App\Models\Menu::buildMenu( [
				'lang' => self::$param->lang
			] );
			View::share( 'menu', $menu );
			
			// Detect how many blocks exists in current route???
			$arrWidgetWhere = [
				'FIND_IN_SET("' . self::$param->controller . '", assignment)',
				'FIND_IN_SET("' . self::$param->action . '", assignment)',
				'FIND_IN_SET("' . self::$param->controller . '_' . self::$param->action . '", assignment)'
			];
			$widgetWhere = '(' . implode( ' OR ', $arrWidgetWhere ) . ' OR assignment = "all")';
			
			// Get all widget
			$widgetAll = \App\Models\Widget::getAll( [
				'lang' => self::$param->lang,
				'where' => [
					'status = "active"',
					$widgetWhere
				]
			] );
			
			$widget = [];
			if ( count( $widgetAll ) > 0 ) {
				foreach ( $widgetAll as $w ) {
					// Return view not return object
					$arrWidget[$w->position][] = View::make( 'web.widget.box', [
						'widget' => $w
					] )->render();
				}
				
				foreach ( $arrWidget as $k => $w ) {
					$widget[$k] = implode( '', $w );
				}
			}
			View::share( 'widget', $widget );
		}
	}

	protected function setParam()
	{
		self::$param = new \stdClass();
		
		// Get current Module & Controller & Action name
		preg_match( '#^App\\\\Http\\\\Controllers\\\\([a-z]+)\\\\([a-z]+)Controller@([a-z]+)$#i', Route::currentRouteAction(), $match );
		if ( isset( $match ) && count( $match ) > 0 ) {
			self::$param->module = $match[1];
			self::$param->controller = strtolower( $match[2] );
			self::$param->action = $match[3];
			self::$param->id = Route::input( 'id' );
		}
		self::$param->type = Request::input( 'type' );
		
		// Setup languages
		self::$param->languages = Language::getAll();
		$arrLangCode = array_pluck( self::$param->languages, 'code' );
		
		// Setup default language
		self::$param->lang = !is_null( Route::input( 'lang' ) ) && in_array( Route::input( 'lang' ), $arrLangCode ) ? Route::input( 'lang' ) : self::$setting->language;
		\App::setLocale( self::$param->lang );
		
		// Publish param to all view
		View::share( 'param', self::$param );
	}

	/**
	 *
	 * @param
	 *        route name $routeName
	 * @param
	 *        button array $arrBtn
	 * @param
	 *        extra param $arrParam
	 * @return string
	 */
	protected function loadBtnControl( $routeName, $arrBtn = [], $arrParam = [] )
	{
		return View::make( 'admin.common.btn-control', [
			'routeName' => $routeName,
			'arrBtn' => $arrBtn,
			'arrParam' => $arrParam
		] )->render();
	}

	protected function getMenu()
	{
		$extMenu = resource_path( 'widgets/Admin/layout.menu.php' );
		$menu = [];
		
		foreach ( \File::getRequire( $extMenu ) as $id => $m ) {
			$menu[$id] = json_decode( json_encode( $m, true ) );
		}
		
		// Setup list zone
		self::$zone = \App\Classes\Helper::getZone( $menu );
		View::share( 'zone', self::$zone );
		
		$this->middleware( function ( $request, $next ) {
			// Get user accessible places
			if ( \Auth::check() ) {
				$userAccessiblePlaces = DB::table( 'user_role' )->where( 'id', \Auth::user()->role )->pluck( 'accessible_place' )[0];
				$accessiblePlaces = json_decode( $userAccessiblePlaces );
				
				// Forbidden for un-accessible places
				if ( !in_array( self::$param->controller, $accessiblePlaces ) && !in_array( self::$param->action, $accessiblePlaces ) ) {
					$message = ( env( 'APP_ENV' ) == 'local' ? '[' . self::$param->controller . ']Controller & [' . self::$param->action . ']Action. ' : null ) . 'Un-accessible place. Permission deny!!';
					return \Redirect::route( 'adminDashboard' )->with( 'message-danger', $message )->send();
				}
				
				View::share( 'accessiblePlace', $accessiblePlaces );
			}
			
			return $next( $request );
		} );
		
		return $menu;
	}

	protected function userOnline( $view = false )
	{
		$timeOut = 1800;
		$timeNew = time() - $timeOut;
		
		DB::table( 'user_online' )->insert( [
			'time' => time(),
			'ip' => \App\Classes\Helper::getIP(),
			'path' => $_SERVER['REQUEST_URI']
		] );
		
		DB::table( 'user_online' )->where( 'time', '<', $timeNew )->delete();
		
		return $view == true ? count( DB::table( 'user_online' )->select( 'ip' )->distinct()->where( 'path', '<>', $_SERVER['REQUEST_URI'] )->get() ) : null;
	}

	protected function breadcrumb( $data )
	{
		if ( !is_array( $data ) || count( $data ) == 0 )
			return __( 'Web/global.error.empty_breadcrumb' );
		
		return View::make( 'web.common.breadcrumb', [
			'data' => $data
		] )->render();
	}
}
