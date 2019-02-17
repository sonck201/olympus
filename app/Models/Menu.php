<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Menu extends Model
{

	protected $table = 'menu';

	protected static $tbl = 'menu';

	static $menus = [];

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
			$j->on( 'content.id', '=', 'menu.id' );
			$j->on( 'content.tbl', '=', DB::raw( '"menu"' ) );
			$j->on( 'content.lang', '=', DB::raw( '"' . $param['lang'] . '"' ) );
		} );
		
		// Build order
		if ( isset( $param['order'] ) ) {
			foreach ( $param['order'] as $order )
				$sql->orderByRaw( $order );
		} else {
			$sql->orderBy( 'priority', 'ASC' );
		}
		
		return self::recursion( $sql->get() );
	}

	static function recursion( $menus, $parent = 0, $level = 0, $separate = '' )
	{
		// Refuse if not valid
		if ( !isset( $menus ) || count( $menus ) == 0 )
			return 'Categories are not set.';
			
			// Start pushing data
		foreach ( $menus as $k => $m ) {
			if ( (int) $m->parent === $parent ) {
				self::$menus[$k] = $m;
				self::$menus[$k]->level = $level;
				self::$menus[$k]->separate = $separate;
				
				unset( $menus[$k] );
				
				self::recursion( $menus, (int) $m->id, $level + 1, $separate . '—|—' );
			}
		}
		
		return self::$menus;
	}

	static function getParent( $param = [] )
	{
		$arrWhere = isset( $param['where'] ) && count( $param['where'] ) > 0 ? $param['where'] : [];
		$arrWhere[] = 'status = "active"';
		
		self::$menus = [];
		$data = self::getAll( [
			'lang' => $param['lang'],
			'where' => $arrWhere
		] );
		
		$parents[0] = isset( $param['uncategory'] ) == true ? '— Select menu —' : 'Top';
		
		if ( count( $data ) > 0 ) {
			foreach ( $data as $p ) {
				$separate = null;
				for ( $i = 0; $i <= $p->level; $i++ )
					$separate .= '—|—';
				
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
		
		// Get all menu data
		$data = $sql->where( 'menu.id', '=', $param['id'] )->first();
		
		// Get all menu content
		$content = DB::table( 'content' )->select( 'title', 'alias', 'lang' )->where( 'id', $param['id'] )->where( 'tbl', 'menu' )->orderBy( 'lang' )->get();
		
		foreach ( $content as $m )
			$customData['content'][$m->lang] = $m;
		
		return (object) array_merge( (array) $data, (array) $customData );
	}

	static function buildMenu( $param = [] )
	{
		$menu = [];
		$menus = self::getAll( [
			'lang' => $param['lang'],
			'where' => [
				'status = "active"'
			]
		] );
		
		foreach ( $menus as $m ) {
			$opt = [
				'type' => $m->type,
				'data' => $m->data,
				'title' => $m->alias,
				'lang' => $param['lang']
			];
			if ( $m->parent == 0 && $m->level == 0 ) {
				$menu[$m->id] = $m;
				$menu[$m->id]->href = self::buildMenuHref( $opt );
				$menu[$m->id]->nameId = self::buildMenuType( $opt );
			} elseif ( $m->parent != 0 && $m->level == 1 ) {
				$menu[$m->parent]->children[$m->id] = $m;
				$menu[$m->parent]->children[$m->id]->href = self::buildMenuHref( $opt );
				$menu[$m->parent]->children[$m->id]->nameId = self::buildMenuType( $opt );
			} elseif ( $m->parent != 0 && $m->level == 2 ) {
				$rootId = self::findRootId( $m->parent );
				$menu[$rootId]->children[$m->parent]->children[$m->id] = $m;
				$menu[$rootId]->children[$m->parent]->children[$m->id]->href = self::buildMenuHref( $opt );
				$menu[$rootId]->children[$m->parent]->children[$m->id]->nameId = self::buildMenuType( $opt );
			}
		}
		
		return $menu;
	}

	static function findRootId( $id )
	{
		return DB::table( self::$tbl )->where( 'id', $id )->pluck( 'parent' )[0];
	}

	static function buildMenuHref( $param = [] )
	{
		$language = DB::table( 'language' )->where( 'status', 'active' )->count();
		
		switch ( $param['type'] ) {
			case 'homepage' :
				$href = route( 'homepage' );
				break;
			case 'url' :
				$href = $param['data'];
				break;
			case 'separator' :
				$href = '#';
				break;
			case 'post' :
				$arrParam = [
					'id' => $param['data'],
					'title' => $param['title']
				];
				if ( $language > 1 )
					$arrParam['lang'] = $param['lang'];
				
				$href = route( 'post', $arrParam );
				break;
			case 'category' :
				$arrParam = [
					'id' => $param['data'],
					'title' => $param['title']
				];
				if ( $language > 1 )
					$arrParam['lang'] = $param['lang'];
				
				$href = route( 'category', $arrParam );
				break;
			case 'contact' :
				$href = route( 'contactGet' );
				break;
			default :
				$href = '#';
		}
		
		return $href;
	}

	static function buildMenuType( $param = [] )
	{
		switch ( $param['type'] ) {
			case 'homepage' :
				$type = 'webHomepage';
				break;
			case 'url' :
				$type = 'url';
				break;
			case 'separator' :
				$type = 'separator';
				break;
			case 'post' :
				$type = 'contentPost';
				break;
			case 'category' :
				$type = 'contentCategory';
				break;
			case 'contact' :
				$type = 'webContactGet';
				break;
			default :
				$type = null;
		}
		
		return $type;
	}
}