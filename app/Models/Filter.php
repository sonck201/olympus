<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * App\Models\Filter
 * @mixin \Eloquent
 */
class Filter extends Model
{

	static function showListLike()
	{
		return [
			'keyword'
		];
	}

	static function showListEqual()
	{
		return [
			'category',
			'status',
			'role',
			'position',
			'type',
			'format'
		];
	}

	static function showListSorting()
	{
		return [
			'created_at',
			'visit',
			'pageview',
			'updated_at',
			'logged_at'
		];
	}

	static function hasTitleList()
	{
		return [
			'post',
			'widget'
		];
	}

	static function orderList()
	{
		return [
			'asc',
			'desc'
		];
	}

	static function makeQuery( $param )
	{
		$arrFilter['where'] = $arrFilter['order'] = [];
		$arrQuery = explode( '&', $param['queryString'] );
		
		foreach ( $arrQuery as $q ) {
			$arrF = explode( '=', $q );
			if ( !empty( $arrF[1] ) && in_array( $arrF[0], self::showListLike() ) && in_array( $param['controller'], self::hasTitleList() ) ) {
				$arrFilter['where'][] = '`' . DB::getTablePrefix() . 'content`.`title` LIKE "%' . $arrF[1] . '%"';
			} elseif ( !empty( $arrF[1] ) && in_array( $arrF[0], self::showListLike() ) && $param['controller'] == 'user' ) {
				$arrFilter['where'][] = '`email` LIKE "%' . $arrF[1] . '%" OR `name` LIKE "%' . $arrF[1] . '%"';
			} elseif ( !empty( $arrF[1] ) && in_array( $arrF[0], self::showListEqual() ) ) {
				$arrFilter['where'][] = '`' . DB::getTablePrefix() . $param['controller'] . '`.`' . $arrF[0] . '` = ' . ( $arrF[1] > 0 ? $arrF[1] : '"' . $arrF[1] . '"' );
			} elseif ( !empty( $arrF[1] ) && in_array( $arrF[0], self::showListSorting() ) && in_array( strtoupper( $arrF[1] ), self::orderList() ) ) {
				// Make order SQL
				$arrFilter['order'][] = '`' . DB::getTablePrefix() . $param['controller'] . '`.`' . $arrF[0] . '` ' . strtoupper( $arrF[1] );
			}
		}
		
		return $arrFilter[$param['type']];
	}

	static function Category( $param )
	{
		$categories = Category::getAllCategory( [
			'lang' => $param['lang']
		] );
		
		array_unshift( $categories, '— Select category —' );
		
		return $categories;
	}

	static function Role( $param )
	{
		$arrFilter = [
			null => '— Select role —'
		];
		$roles = DB::table( 'user_role' )->where( 'id', '<', $param['role'] )->get();
		
		foreach ( $roles as $r ) {
			$arrFilter[$r->id] = $r->title;
		}
		
		return $arrFilter;
	}

	static function Status( $param = [] )
	{
		$arrFilter = [
			null => '— Select status —',
			'active' => 'Active',
			'deactive' => 'Deactive'
		];
		
		if ( isset( $param['trash'] ) && $param['trash'] == true )
			$arrFilter['trash'] = 'Trash';
		
		return $arrFilter;
	}

	static function Position( $arrPosition )
	{
		$arrFilter = [
			null => '— Select position —'
		];
		
		return array_merge( $arrFilter, $arrPosition );
	}

	static function WidgetType()
	{
		$arrWidget = [];
		$arrWidgetType = [
			null => '— Select type —'
		];
		$widgetPath = app_path( 'Http/Widgets/Admin' );
		foreach ( glob( $widgetPath . '/*' ) as $i => $file ) {
			if ( strpos( $file, 'assignment' ) === false ) {
				$arrWidget[$i] = \File::getRequire( $file );
				$arrWidgetType[str_slug( $arrWidget[$i]['label'] )] = $arrWidget[$i]['label'];
			}
		}
		
		return $arrWidgetType;
	}

	static function CreatedAt()
	{
		return [
			null => '— Created time —',
			'asc' => 'Ascending',
			'desc' => 'Descending'
		];
	}

	static function Visit()
	{
		return [
			null => '— Visit —',
			'asc' => 'Ascending',
			'desc' => 'Descending'
		];
	}

	static function Pageview()
	{
		return [
			null => '— Pageview —',
			'asc' => 'Ascending',
			'desc' => 'Descending'
		];
	}

	static function UpdatedAt()
	{
		return [
			null => '— Updated time —',
			'asc' => 'Ascending',
			'desc' => 'Descending'
		];
	}

	static function LoggedAt()
	{
		return [
			null => '— Logged time —',
			'asc' => 'Ascending',
			'desc' => 'Descending'
		];
	}

	static function PostFormat( $formats )
	{
		return array_merge( [
			null => '— Select format —'
		], $formats );
	}
}
