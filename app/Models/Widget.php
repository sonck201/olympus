<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Widget extends Model
{

	protected $table = 'widget';

	protected static $tbl = 'widget';

	static function getAll( $param = [] )
	{
		$sql = DB::table( self::$tbl );
		
		// Build select
		if ( isset( $param['select'] ) ) {
			$arrSelect = [];
			foreach ( $param['select'] as $select )
				$arrSelect[] = $select;
		}
		$sql->select( isset( $arrSelect ) && count( $arrSelect ) > 0 ? $arrSelect : '*' );
		
		// Build where
		if ( isset( $param['where'] ) ) {
			foreach ( $param['where'] as $where )
				$sql->whereRaw( '(' . $where . ')' );
		}
		
		// Build left content
		$sql->leftJoin( 'content', function ( $j ) use ($param )
		{
			$j->on( 'content.id', '=', 'widget.id' );
			$j->on( 'content.tbl', '=', DB::raw( '"widget"' ) );
			$j->on( 'content.lang', '=', DB::raw( '"' . $param['lang'] . '"' ) );
		} );
		
		// Build order
		if ( isset( $param['order'] ) && !empty( $param['order'] ) ) {
			foreach ( $param['order'] as $order )
				$sql->orderByRaw( $order );
		} else {
			$sql->orderBy( 'position' )->orderBy( 'priority' );
		}
		
		return isset( $param['limit'] ) && $param['limit'] > 0 ? $sql->paginate( $param['limit'] ) : $sql->get();
	}

	static function getOne( $param = [] )
	{
		$sql = DB::table( self::$tbl );
		
		// Build select
		if ( isset( $param['select'] ) ) {
			$arrSelect = [];
			foreach ( $param['select'] as $select )
				$arrSelect[] = $select;
			
			$arrSelect = count( $arrSelect ) > 0 ? $arrSelect : '*';
			$sql->select( $arrSelect );
		}
		
		if ( isset( $param['where'] ) ) {
			foreach ( $param['where'] as $where )
				$sql->whereRaw( $where );
		}
		
		// Get all widget data
		$data = $sql->where( 'widget.id', '=', $param['id'] )->first();
		
		// Get all widget content
		$content = DB::table( 'content' )->select( 'title', 'alias', 'lang', 'content' )->where( 'id', $param['id'] )->where( 'tbl', 'widget' )->orderBy( 'lang' )->get();
		foreach ( $content as $e )
			$customData['content'][$e->lang] = $e;
		
		return (object) array_merge( (array) $data, (array) $customData );
	}

	static function statistic()
	{
		return DB::table( self::$tbl )->first( [
			DB::raw( 'COUNT(*) AS total' ),
			DB::raw( '(SELECT COUNT(*) FROM ' . DB::getTablePrefix() . self::$tbl . ' WHERE status = "active") AS totalActive' ),
			DB::raw( '(SELECT COUNT(*) FROM ' . DB::getTablePrefix() . self::$tbl . ' WHERE status = "deactive") AS totalDeactive' )
		] );
	}
}
