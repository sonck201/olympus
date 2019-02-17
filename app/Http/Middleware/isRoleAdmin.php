<?php

namespace App\Http\Middleware;

use Illuminate\Contracts\Auth\Guard;
use Closure, Request, Route;

class isRoleAdmin
{

	/**
	 * The Guard implementation.
	 * 
	 * @var Guard
	 */
	protected $auth;

	/**
	 * Create a new filter instance.
	 * 
	 * @param Guard $auth        
	 * @return void
	 */
	public function __construct( Guard $auth )
	{
		$this->auth = $auth;
	}

	/**
	 * Handle an incoming request.
	 * 
	 * @param \Illuminate\Http\Request $request        
	 * @param \Closure $next        
	 * @return mixed
	 */
	public function handle( $request, Closure $next )
	{
		// Get all router param
		preg_match( '#^App\\\\Http\\\\Controllers\\\\([a-z]+)\\\\([a-z]+)Controller@([a-z]+)$#i', Route::currentRouteAction(), $match );
		
		if ( $request->ajax() ) {
			return $next( $request );
		}
		
		$arrModule = [
			'Admin'
		];
		$arrController = [
			'Auth'
		];
		$arrAction = [
			'getLogin',
			'postLogin'
		];
		
		if ( ( !$this->auth->check() || $request->user()->role < 2 ) && !( in_array( $match[1], $arrModule ) && in_array( $match[2], $arrController ) && in_array( $match[3], $arrAction ) ) ) {
			return \Redirect::route( 'adminAuthGetLogin' )->with( 'message-danger', 'Your session has been expired.' );
		}
		
		return $next( $request );
	}
}
