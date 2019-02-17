<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB, View;

class StatisticController extends Controller
{

	public function all()
	{
		// DB::enableQueryLog();
		$stat = new \stdClass();
		
		// Statistic for post
		$stat->postVisit = DB::table( 'post' )->sum( 'visit' );
		$stat->postPageview = DB::table( 'post' )->sum( 'pageview' );
		
		// Statistic for category
		$stat->categoryVisit = DB::table( 'category' )->sum( 'visit' );
		$stat->categoryPageview = DB::table( 'category' )->sum( 'pageview' );
		
		// Statistic for user_online
		$stat->visitPage = DB::table( 'user_online' )->where( 'path', '!=', $_SERVER['REQUEST_URI'] )->groupBy( 'path' )->orderBy( 'count', 'DESC' )->limit( 10 )->get( [
			'path',
			DB::raw( 'COUNT(path) AS count' )
		] );
		
		$stat->visitIp = DB::table( 'user_online' )->where( 'path', '!=', $_SERVER['REQUEST_URI'] )->groupBy( 'ip' )->orderBy( 'count', 'DESC' )->limit( 10 )->get( [
			'ip',
			DB::raw( 'COUNT(ip) AS count' )
		] );
		
		// dd( $stat, DB::getQueryLog() );
		
		// Render view
		return View::make( 'admin.statistic.all', [
			'titlePage' => 'Statistic',
			'stat' => $stat
		] );
	}
}