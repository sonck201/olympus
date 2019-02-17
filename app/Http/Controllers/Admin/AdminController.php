<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB, Session, View, Response, Auth;
use App\Models\Post;
use App\Models\User;
use App\Models\Image;
use App\Http\Requests\Setting\UpdateRequest;

class AdminController extends Controller
{

	public function dashboard()
	{
		// Set data null
		$latestPost = $popularPost = $recentUser = null;
		
		// Get some latest posts
		$latestPost = Post::getAll( [
			'lang' => self::$param->lang,
			'select' => [
				'post.id',
				'content.title',
				DB::raw( 'DATE_FORMAT(' . DB::getTablePrefix() . 'post.created_at, "%y-%m-%d") AS createdAt' ),
				'user.name AS userName',
				'visit',
				'pageview'
			],
			'limit' => 6
		] );
		
		// Get some popular posts
		$popularPost = Post::getAll( [
			'lang' => self::$param->lang,
			'select' => [
				'post.id',
				'content.title',
				DB::raw( 'DATE_FORMAT(' . DB::getTablePrefix() . 'post.created_at, "%y-%m-%d") AS createdAt' ),
				'user.name AS userName',
				'visit'
			],
			'order' => [
				'visit DESC',
				'pageview DESC'
			],
			'limit' => 6
		] );
		
		// Get some users recent login
		$recentUser = User::getAll( [
			'role' => Auth::user()->role,
			'select' => [
				'user.id',
				'email',
				'name',
				DB::raw( 'DATE_FORMAT(logged_at, "%y-%m-%d %H:%i") AS loginedAt' ),
				'user_role.title AS roleTitle'
			],
			'order' => [
				'logged_at DESC'
			],
			'limit' => 6
		] );
		
		if ( !Session::has( 'systemStat' ) || ( Session::get( 'systemStatTime' ) + ( self::$setting->cacheExpire * 60 ) ) < time() ) {
			// Get system stat if no cache
			$stat = new \stdClass();
			$stat->user = DB::table( 'user' )->count();
			$stat->post = DB::table( 'post' )->count();
			$stat->postVisit = (int) DB::table( 'post' )->sum( 'visit' );
			$stat->postPageview = (int) DB::table( 'post' )->sum( 'pageview' );
			
			// Get MysqlVersion
			$pdo = DB::connection()->getPdo();
			$stat->mySqlVersion = $pdo->query( 'SELECT version()' )->fetchColumn();
			
			// Update stat
			DB::table( 'misc' )->update( [
				'stat' => json_encode( $stat )
			] );
			
			// Store in session & systemStatTime
			Session::put( 'systemStat', $stat );
			Session::put( 'systemStatTime', time() );
		} else {
			$stat = Session::get( 'systemStat' );
		}
		
		// Render view
		return View::make( 'admin.dashboard.main', [
			'titlePage' => 'Dashboard',
			'latestPost' => $latestPost,
			'popularPost' => $popularPost,
			'recentUser' => $recentUser,
			'stat' => $stat
		] );
	}

	public function setting()
	{
		// Load control button
		$btnControl = $this->loadBtnControl( 'adminSetting', [
			'save'
		] );
		
		$settingData = new \stdClass();
		
		// Load template
		$arrTemplate = glob( public_path( 'templates/*' ) );
		foreach ( $arrTemplate as $t ) {
			if ( is_dir( $t ) && preg_match( '/(admin|web)/i', basename( $t ), $match ) ) {
				if ( $match[0] == 'admin' )
					$settingData->adminTemplate[strtolower( basename( $t ) )] = basename( $t );
				elseif ( $match[0] == 'web' )
					$settingData->webTemplate[strtolower( basename( $t ) )] = basename( $t );
			}
		}
		
		// Render view
		return View::make( 'admin.setting.main', [
			'titlePage' => 'Setting',
			'btnControl' => $btnControl,
			'settingData' => $settingData
		] );
	}

	public function settingUpdate( UpdateRequest $r )
	{
		$arrReject = [
			'_token',
			'siteUrl',
			'urlUpdate',
			'action'
		];
		
		foreach ( $r->all() as $k => $v ) {
			if ( !in_array( $k, $arrReject ) ) {
				$data['setting'][$k] = $v;
				
				DB::table( 'misc' )->update( [
					'setting' => json_encode( $data['setting'] )
				] );
			}
		}
		
		$response['message'] = 'Updated settings.';
		
		return Response::json( $response );
	}

	public function clearCache()
	{
		// Delete all images in tmp folder
		$publicPath = $_SERVER['DOCUMENT_ROOT'] . '/public/';
		Image::deleteImage( $publicPath . 'images/tmp' );
		Image::deleteImage( $publicPath . 'thumbs/tmp' );
		
		// Clear statistic
		Session::forget( 'systemStat' );
		
		return \Redirect::back()->with( 'message-success', 'Cleared cache!!' )->send();
	}
}
