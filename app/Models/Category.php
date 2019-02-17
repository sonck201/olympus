<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Category extends Model
{

	protected $table = 'category';

	protected static $tbl = 'category';

	static $categories = [];

	static $arrType = [
		'post',
		'banner'
	];

	static $arrRoot = [];

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
		$sql->leftJoin( 'content', function ( $j ) use ($param ) {
			$j->on( 'content.id', '=', 'category.id' );
			$j->on( 'content.tbl', '=', DB::raw( '"category"' ) );
			$j->on( 'content.lang', '=', DB::raw( '"' . $param['lang'] . '"' ) );
		} );
		
		$sql->where( 'category.type', '=', $param['type'] );
		
		// Build order
		if ( isset( $param['order'] ) ) {
			foreach ( $param['order'] as $order )
				$sql->orderByRaw( $order );
		} else {
			$sql->orderBy( 'priority', 'ASC' );
		}
		
		return self::recursion( $sql->get() );
	}

	static function recursion( $categories, $parent = 0, $level = 0, $separate = '' )
	{
		// Refuse if not valid
		if ( !isset( $categories ) || count( $categories ) == 0 )
			return 'Categories are not set.';
			
			// Start pushing data
		foreach ( $categories as $k => $c ) {
			if ( (int) $c->parent === $parent ) {
				self::$categories[$k] = $c;
				self::$categories[$k]->level = $level;
				self::$categories[$k]->separate = $separate;
				
				unset( $categories[$k] );
				
				self::recursion( $categories, (int) $c->id, $level + 1, $separate . '—|—' );
			}
		}
		
		return self::$categories;
	}

	static function getParent( $param = [] )
	{
		$arrWhere = isset( $param['where'] ) && count( $param['where'] ) > 0 ? $param['where'] : [];
		$arrWhere[] = 'status = "active"';
		
		self::$categories = [];
		$data = self::getAll( [
			'lang' => $param['lang'],
			'type' => $param['type'],
			'where' => $arrWhere
		] );
		
		$parents = [];
		
		if ( isset( $param['uncategory'] ) == true )
			$parents[0] = '— Select category —';
		
		if ( isset( $param['top'] ) == true )
			$parents[0] = 'Top';
		
		if ( !isset( $param['separate'] ) || empty( $param['separate'] ) )
			$param['separate'] = '—|—';
		
		if ( count( $data ) > 0 ) {
			foreach ( $data as $p ) {
				$separate = null;
				for ( $i = 0; $i <= $p->level; $i++ )
					$separate .= $param['separate'];
				
				$parents[$p->id] = $separate . ' ' . $p->title;
			}
		}
		
		return $parents;
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
		
		// Get all category data
		$data = $sql->where( 'category.id', '=', $param['id'] )->first();
		
		// Get all category content
		$content = DB::table( 'content' )->select( 'title', 'alias', 'lang' )->where( 'id', $param['id'] )->where( 'tbl', 'category' )->orderBy( 'lang' )->get();
		
		foreach ( $content as $c )
			$customData['data'][$c->lang] = $c;
		
		return (object) array_merge( (array) $data, (array) $customData );
	}

	static function getAllCategory( $param = [] )
	{
		$category = [];
		
		if ( isset( $param['uncategory'] ) && $param['uncategory'] == true )
			$category[0] = 'Uncategorized';
		
		foreach ( self::$arrType as $t ) {
			$category[ucfirst( $t )] = self::getParent( [
				'lang' => $param['lang'],
				'type' => $t,
				'separate' => isset( $param['separate'] ) && !empty( $param['separate'] ) ? $param['separate'] : '|—'
			] );
		}
		
		return $category;
	}

	static function rootCategory( $param )
	{
		$rootCategory = array_reverse( self::rootCategoryRecursion( $param ) );
		$category = [];
		
		foreach ( $rootCategory as $c ) {
			$category[] = (object) array_merge( (array) $c, [
				'route' => 'category'
			] );
		}
		
		return $category;
	}

	static function rootCategoryRecursion( $param )
	{
		if ( $param['id'] == 0 )
			return self::$arrRoot;
		
		$categoryInfo = self::$arrRoot[] = DB::table( self::$tbl )->where( 'category.id', '=', $param['id'] )->leftJoin( 'content', function ( $j ) use ($param ) {
			$j->on( 'content.id', '=', 'category.id' );
			$j->on( 'content.tbl', '=', DB::raw( '"category"' ) );
			$j->on( 'content.lang', '=', DB::raw( '"' . $param['lang'] . '"' ) );
		} )->first( [
			'category.id',
			'category.parent',
			'content.title',
			'content.alias'
		] );
		
		if ( $categoryInfo->parent != 0 ) {
			self::rootCategory( [
				'id' => $categoryInfo->parent,
				'lang' => $param['lang']
			] );
		}
		
		return self::$arrRoot;
	}
}
