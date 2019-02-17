<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class User extends Model
{

	protected static $tbl = 'user';

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
				$sql->whereRaw( '(' . $where . ')' );
		}
		
		// dont display current role user
		$sql->where( 'role', '<', $param['role'] );
		
		// Get user role title
		$sql->leftJoin( 'user_role', 'user_role.id', '=', 'user.role' );
		
		// Build order
		if ( isset( $param['order'] ) && count( $param['order'] ) > 0 ) {
			foreach ( $param['order'] as $order )
				$sql->orderByRaw( $order );
		} else {
			$sql->orderBy( 'user.created_at', 'DESC' )->orderBy( 'user.id', 'DESC' );
		}
		
		return isset( $param['limit'] ) && $param['limit'] > 0 ? $sql->paginate( $param['limit'] ) : $sql->get();
	}

	static function statistic( $param = [] )
	{
		return DB::table( self::$tbl )->first( [
			DB::raw( 'COUNT(*) AS total' ),
			DB::raw( '(SELECT COUNT(*) FROM ' . DB::getTablePrefix() . self::$tbl . ' WHERE status = "active" AND role < ' . $param['role'] . ') AS totalActive' ),
			DB::raw( '(SELECT COUNT(*) FROM ' . DB::getTablePrefix() . self::$tbl . ' WHERE status = "deactive" AND role < ' . $param['role'] . ') AS totalDeactive' ),
			DB::raw( '(SELECT COUNT(*) FROM ' . DB::getTablePrefix() . self::$tbl . ' WHERE status = "trash" AND role < ' . $param['role'] . ') AS totalTrash' )
		] );
	}

	static function getUserRole( $param )
	{
		$role = [];
		$roles = DB::table( 'user_role' )->get();
		foreach ( $roles as $r ) {
			if ( $r->id < $param['role'] )
				$role[$r->id] = $r->title;
		}
		
		return $role;
	}
}
