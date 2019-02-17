<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use View, Auth, Response, Redirect, DB, Session;
use App\Http\Requests\Auth\LoginRequest;

class AuthController extends Controller
{
	/*
	 * |--------------------------------------------------------------------------
	 * | Login Controller
	 * |--------------------------------------------------------------------------
	 * |
	 * | This controller handles authenticating users for the application and
	 * | redirecting them to your home screen. The controller uses a trait
	 * | to conveniently provide its functionality to your applications.
	 * |
	 */
	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login / registration.
	 * 
	 * @var string
	 */
	protected $redirectTo = 'adminDashboard';

	protected $redirectAfterLogout = 'adminAuthGetLogin';

	public function __construct()
	{		
		parent::__construct();
	}

	public function getLogin()
	{
		return View::make( 'admin.' . self::$param->controller . '.login' );
	}

	public function postLogin( LoginRequest $r )
	{
		$userInfo = [
			'email' => $r->email,
			'password' => $r->password,
			'status' => 'active'
		];
		
		if ( Auth::attempt( $userInfo ) ) {
			// Update time on logged
			DB::table( 'user' )->where( 'id', Auth::user()->id )->update( [
				'logged_at' => DB::raw( 'NOW()' )
			] );
			
			// send flash message
			Session::flash( 'message-success', 'Login successful!!' );
			
			return Response::json( [
				'id' => Auth::user()->id,
				'url' => route( $this->redirectTo )
			] );
		} else {
			return Response::json( [
				'Not found in database. Please check your information carefully!!'
			], 422 );
		}
	}

	public function logout()
	{
		Auth::logout();
		return Redirect::route( $this->redirectAfterLogout );
	}
}