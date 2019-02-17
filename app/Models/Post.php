<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB, Auth;

class Post extends Model
{

	protected static $tbl = 'post';

	static function getAll( $param = [] )
	{
		$sql = DB::table( self::$tbl );
		
		// Build select
		$arrSelect = [];
		if ( isset( $param['select'] ) ) {
			foreach ( $param['select'] as $select )
				$arrSelect[] = $select;
		}
		$sql->select( count( $arrSelect ) > 0 ? $arrSelect : '*' );
		
		// Build where
		if ( isset( $param['where'] ) && count( $param['where'] ) > 0 ) {
			foreach ( $param['where'] as $where )
				if ( !is_null( $where ) && !empty( $where ) )
					$sql->whereRaw( '(' . $where . ')' );
		}
		
		// Join extra field
		$sql->leftJoin( 'post_extra', 'post_extra.id', '=', 'post.id' );
		
		// Build left join content
		$sql->leftJoin( 'content', function ( $j ) use ($param ) {
			$j->on( 'content.id', '=', 'post.id' );
			$j->on( 'content.tbl', '=', DB::raw( '"post"' ) );
			$j->on( 'content.lang', '=', DB::raw( '"' . $param['lang'] . '"' ) );
		} );
		
		// Build left join user
		$sql->leftJoin( 'user', 'user.id', '=', 'post.user' );
		
		// Build left join category
		$sql->leftJoin( 'content AS category', function ( $j ) use ($param ) {
			$j->on( 'category.id', '=', 'post.category' );
			$j->on( 'category.tbl', '=', DB::raw( '"category"' ) );
			$j->on( 'category.lang', '=', DB::raw( '"' . $param['lang'] . '"' ) );
		} );
		
		// Get posts from this user if not moderator and above
		if ( Auth::check() && Auth::user()->role < 6 )
			$sql->where( 'user', Auth::user()->id );
			
			// Build order
		if ( isset( $param['order'] ) && count( $param['order'] ) > 0 ) {
			foreach ( $param['order'] as $order )
				$sql->orderByRaw( $order );
		} else {
			$sql->orderBy( 'post.created_at', 'DESC' )->orderBy( 'post.id', 'DESC' );
		}
		
		return isset( $param['limit'] ) && $param['limit'] > 0 ? $sql->paginate( $param['limit'] ) : $sql->get();
	}

	static function getOne( $param = [] )
	{
		$sql = DB::table( self::$tbl );
		
		// Build select
		$arrSelect = [];
		if ( isset( $param['select'] ) ) {
			foreach ( $param['select'] as $select )
				$arrSelect[] = $select;
		}
		
		// Build where
		if ( isset( $param['where'] ) ) {
			foreach ( $param['where'] as $where )
				$sql->whereRaw( $where );
		}
		
		// Get post info
		$post = $sql->where( 'id', $param['id'] )->first( count( $arrSelect ) > 0 ? $arrSelect : null );
		
		// Get content info
		$content = DB::table( 'content' )->where( 'id', $param['id'] )->where( 'tbl', self::$tbl )->get();
		$customData = [];
		foreach ( $content as $c )
			$customData['data'][$c->lang] = $c;
		
		return (object) array_merge( (array) $post, (array) $customData );
	}

	static function statistic()
	{
		return DB::table( self::$tbl )->first( [
			DB::raw( 'COUNT(*) AS total' ),
			DB::raw( '(SELECT COUNT(*) FROM ' . DB::getTablePrefix() . self::$tbl . ' WHERE status = "active") AS totalActive' ),
			DB::raw( '(SELECT COUNT(*) FROM ' . DB::getTablePrefix() . self::$tbl . ' WHERE status = "deactive") AS totalDeactive' ),
			DB::raw( '(SELECT COUNT(*) FROM ' . DB::getTablePrefix() . self::$tbl . ' WHERE status = "trash") AS totalTrash' )
		] );
	}
}
