<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Classes\Helper;
use App\Models\User;
use App\Models\Filter;
use View, DB, Response, Session, Request, Redirect, Hash, Auth;
use App\Http\Requests\User\UpdateRequest;
use App\Http\Requests\User\UpdateStatusRequest;
use App\Http\Requests\User\UpdateAllRequest;

class UserController extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function all()
	{
		// Load all users
		$users = User::getAll( [
			'select' => [
				'user.*',
				'user_role.title'
			],
			'limit' => self::$setting->itemPerPage,
			'where' => Filter::makeQuery( [
				'queryString' => Request::getQueryString(),
				'controller' => self::$param->controller,
				'type' => 'where'
			] ),
			'order' => Filter::makeQuery( [
				'queryString' => Request::getQueryString(),
				'controller' => self::$param->controller,
				'type' => 'order'
			] ),
			'role' => Auth::user()->role
		] );
		
		// Set custom path for pagination
		$users->setPath( route( 'adminUser', [
			'keyword' => Request::input( 'keyword' ),
			'role' => Request::input( 'role' ),
			'status' => Request::input( 'status' ),
			'created_at' => Request::input( 'created_at' ),
			'updated_at' => Request::input( 'updated_at' ),
			'logged_at' => Request::input( 'logged_at' )
		] ) );
		
		// Get all article statistic
		$statistic = User::statistic( [
			'role' => Auth::user()->role
		] );
		
		// Load control button
		$btnControl = $this->loadBtnControl( 'adminUser', [
			'add',
			'publish',
			'unpublish',
			'trash',
			'delete'
		] );
		
		// Render data to view
		$data = [
			'titlePage' => ucwords( self::$param->controller ) . ' manager (' . ( $statistic->totalActive + $statistic->totalDeactive + $statistic->totalTrash ) . ')',
			'titlePageExtra' => $statistic->totalActive . ' Active | ' . $statistic->totalDeactive . ' Deactive | ' . $statistic->totalTrash . ' Trash',
			'btnControl' => $btnControl,
			'users' => $users,
			'filter' => [
				'keywordVal' => Request::input( 'keyword' ),
				'status' => Filter::Status( [
					'trash' => true
				] ),
				'role' => Filter::Role( [
					'role' => Auth::user()->role
				] ),
				'roleVal' => Request::input( 'role' ),
				'statusVal' => Request::input( 'status' ),
				'date' => Filter::CreatedAt(),
				'dateVal' => Request::input( 'created_at' ),
				'updated' => Filter::UpdatedAt(),
				'updatedVal' => Request::input( 'updated_at' ),
				'logged' => Filter::LoggedAt(),
				'loggedVal' => Request::input( 'logged_at' )
			]
		];
		return View::make( 'admin.' . self::$param->controller . '.all', $data );
	}

	public function add()
	{
		// Get all user role
		$roles = User::getUserRole( [
			'role' => Auth::user()->role
		] );
		
		// Load control button
		$btnControl = $this->loadBtnControl( 'adminUser', [
			'save',
			'saveClose',
			'saveAdd',
			'cancel'
		] );
		
		// Render data to view
		$data = [
			'titlePage' => 'User: add — IP: ' . Helper::getIP(),
			'btnControl' => $btnControl,
			'roles' => $roles
		];
		
		return View::make( 'admin.' . self::$param->controller . '.form', $data );
	}

	public function edit()
	{
		// Get all user role
		$roles = User::getUserRole( [
			'role' => Auth::user()->role
		] );
		
		// Load control button
		$btnControl = $this->loadBtnControl( 'adminUser', [
			'save',
			'saveClose',
			'saveAdd',
			'cancel'
		] );
		
		// Get user info
		$user = DB::table( 'user' )->find( \Route::input( 'id' ) );
		if ( count( (array) $user ) == 0 ) {
			return Redirect::route( 'adminUser' )->with( 'message-danger', 'Not found in database.' );
		}
		
		// Return if wanna control higher role
		if ( $user->role >= Auth::user()->role ) {
			return Redirect::route( 'adminUser' )->with( 'message-danger', 'No permission.' );
		}
		
		// Render data to view
		$data = [
			'titlePage' => 'User: edit',
			'btnControl' => $btnControl,
			'roles' => $roles,
			'user' => $user
		];
		
		return View::make( 'admin.' . self::$param->controller . '.form', $data );
	}

	public function profile()
	{
		// Get all user role
		$roles = User::getUserRole( [
			'role' => ( Auth::user()->role + 1 )
		] );
		
		// Load control button
		$btnControl = $this->loadBtnControl( 'adminUser', [
			'save',
			'saveClose',
			'saveAdd',
			'cancel'
		] );
		
		// Render data to view
		$data = [
			'titlePage' => 'User: edit',
			'btnControl' => $btnControl,
			'roles' => $roles,
			'user' => Auth::user()
		];
		
		return View::make( 'admin.' . self::$param->controller . '.form', $data );
	}

	public function updateStatus( UpdateStatusRequest $r )
	{
		$input = $r->all();
		$response['id'] = $input['id'];
		$response['action'] = ( $input['action'] == 'active' ? 'deactive' : 'active' );
		
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
		
		if ( $input['action'] != 'Delete' ) {
			if ( $input['action'] == 'Publish' ) {
				$response['action'] = 'active';
				$response['actionStatus'] = 'deactive';
			} elseif ( $input['action'] == 'Unpublish' ) {
				$response['action'] = 'deactive';
				$response['actionStatus'] = 'active';
			} else {
				$response['action'] = 'trash';
			}
			
			$u = DB::table( 'user' );
			if ( isset( $response['actionStatus'] ) )
				$u->where( 'status', '!=', $response['action'] );
			
			$u->where( 'status', '!=', $response['action'] )->whereIn( 'id', $input['arrId'] )->update( [
				'status' => $response['action']
			] );
			
			$response['view'] = (string) View::make( 'admin.common.status', [
				'status' => $response['action']
			] );
		} else {
			DB::transaction( function () use ($input ) {
				// delete data in all tables
				DB::table( 'user' )->whereIn( 'id', $input['arrId'] )->delete();
			} );
			
			Session::flash( 'message-warning', $response['action'] . ' ' . $controller . ' successful!!' );
		}
		
		$response['message'] = [
			ucwords( $response['action'] ) . ' ' . $controller . ' successful!!'
		];
		
		return Response::json( $response );
	}

	public function update( UpdateRequest $r )
	{
		$input = $r->all();
		
		$data = [
			'status' => $input['status'],
			'role' => $input['role'],
			'subscribe' => $input['subscribe'],
			'name' => !empty( $input['name'] ) ? $input['name'] : null,
			'birthday' => !empty( $input['bdYear'] ) && !empty( $input['bdMonth'] ) && !empty( $input['bdDate'] ) ? $input['bdYear'] . '-' . $input['bdMonth'] . '-' . $input['bdDate'] : null,
			'phone' => !empty( $input['phone'] ) ? $input['phone'] : null,
			'address' => !empty( $input['address'] ) ? $input['address'] : null
		];
		
		// Insert or Update
		if ( $input['action'] == 'add' ) {
			$response['id'] = DB::table( 'user' )->insertGetId( array_merge( $data, [
				'email' => $input['email'],
				'password' => Hash::make( $input['password'] ),
				'register_ip' => Helper::getIP(),
				'active_ip' => Helper::getIP(),
				'created_at' => DB::raw( 'NOW()' )
			] ) );
		} else {
			$response['id'] = $input['id'];
			DB::table( 'user' )->where( 'id', $input['id'] )->update( $data );
			
			// Update password when changing
			if ( !empty( $input['password'] ) ) {
				DB::table( 'user' )->where( 'id', $input['id'] )->update( [
					'password' => Hash::make( $input['password'] )
				] );
			}
		}
		
		$response['message'] = [
			'Update ' . strtolower( self::$param->controller ) . ' completed!!'
		];
		Session::flash( 'message-success', implode( "\n", $response['message'] ) );
		
		return Response::json( $response );
	}

	public function role()
	{
		// Get all roles
		$roles = DB::table( 'user_role' )->orderBy( 'id' )->get();
		
		// Render data to view
		$data = [
			'titlePage' => ucwords( self::$param->controller ) . ' roles info',
			'roles' => $roles
		];
		return View::make( 'admin.' . self::$param->controller . '.role', $data );
	}
}
