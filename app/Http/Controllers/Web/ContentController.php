<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use View, Route, DB, Redirect;
use App\Models\Post;
use App\Models\Category;

class ContentController extends Controller
{

	protected $visitPost = 'visitPost';

	protected $visitCategory = 'visitCategory';

	protected $visitTime = 5 * 60;

	public function Post()
	{
		$id = Route::input( 'id' );
		
		// Check exist current id or not
		if ( DB::table( 'post' )->where( 'id', '=', $id )->where( 'status', '=', 'active' )->where( 'created_at', '<=', 'NOW()' )->count() == 0 ) {
			return Redirect::route( 'homepage' )->with( 'message-danger', __( 'Web/global.error.invalid_id' ) );
		}
		
		// Get post info
		$post = Post::getOne( [
			'id' => $id
		] );
		
		// Get category parent for making breadcrumb
		$arrCategory = explode( ',', $post->category );
		if ( in_array( session( 'lastVisitCategory' ), $arrCategory ) ) {
			$rootCategoryId = session( 'lastVisitCategory' );
		} else {
			if ( count( $arrCategory ) > 0 ) {
				$rootCategoryId = $arrCategory[0];
			} else {
				$rootCategoryId = 0;
			}
		}
		
		// Get root category
		$rootCategory = $this->rootCategory( $rootCategoryId );
		
		// Make breadcrumb
		$breadcrumb = $this->breadcrumb( array_merge( $rootCategory, [
			[
				'title' => $post->data[self::$param->lang]->title
			]
		] ) );
		
		// Update visit after 5'... depend on session
		if ( is_null( session( $this->visitPost . '.' . $id ) ) || time() > session( $this->visitPost . '.' . $id ) + $this->visitTime ) {
			DB::table( 'post' )->where( 'id', '=', $id )->update( [
				'visit' => DB::raw( 'visit + 1' )
			] );
			session( [
				$this->visitPost . '.' . $id => time()
			] );
		}
		
		// Update pageview
		DB::table( 'post' )->where( 'id', '=', $id )->update( [
			'pageview' => DB::raw( 'pageview + 1' )
		] );
		
		// Render view
		return View::make( 'web.content.post', [
			'titlePage' => $post->data[self::$param->lang]->title,
			'breadcrumb' => $breadcrumb,
			'post' => $post
		] );
	}

	public function Category()
	{
		$id = Route::input( 'id' );
		
		// Check exist current id or not
		if ( DB::table( 'category' )->where( 'id', '=', $id )->where( 'status', '=', 'active' )->count() == 0 ) {
			return Redirect::route( 'homepage' )->with( 'message-danger', __( 'Web/global.error.invalid_id' ) );
		}
		
		// Get category info
		$category = Category::getOne( [
			'id' => $id,
			'where' => [
				'`status` = "active"'
			]
		] );
		
		// Get all post from this category
		$post = Post::getAll( [
			'lang' => self::$param->lang,
			'select' => [
				'post.id',
				'post.image',
				'content.title',
				'content.alias',
				'content.content'
			],
			'where' => [
				'`' . DB::getTablePrefix() . 'post`.`status` = "active"',
				'`' . DB::getTablePrefix() . 'post`.`created_at` <= NOW()',
				'FIND_IN_SET(' . $id . ', category)'
			],
			'limit' => self::$setting->postPerPage
		] );
		
		// Set last visit category
		session( [
			'lastVisitCategory' => $id
		] );
		
		// Make breadcrumb
		$breadcrumb = $this->breadcrumb( $this->rootCategory( $id ) );
		
		// Update visit after 5'... depend on session
		if ( is_null( session( $this->visitCategory . '.' . $id ) ) || time() > session( $this->visitCategory . '.' . $id ) + $this->visitTime ) {
			DB::table( 'category' )->where( 'id', '=', $id )->update( [
				'visit' => DB::raw( 'visit + 1' )
			] );
			session( [
				$this->visitCategory . '.' . $id => time()
			] );
		}
		
		// Update pageview
		DB::table( 'category' )->where( 'id', '=', $id )->update( [
			'pageview' => DB::raw( 'pageview + 1' )
		] );
		
		// Render view
		return View::make( 'web.content.category', [
			'titlePage' => $category->data[self::$param->lang]->title,
			'breadcrumb' => $breadcrumb,
			'category' => $category,
			'post' => $post
		] );
	}

	protected function rootCategory( $categoryId )
	{
		return Category::rootCategory( [
			'id' => $categoryId,
			'lang' => self::$param->lang
		] );
	}
}