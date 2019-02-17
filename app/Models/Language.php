<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Language extends Model
{

	protected static $name = 'language';

	static function getAll()
	{
		$sql = DB::table( self::$name );
		$sql->where( 'status', 'active' );
		$sql->orderBy( 'priority', 'ASC' );
		
		return $sql->get();
	}
}
