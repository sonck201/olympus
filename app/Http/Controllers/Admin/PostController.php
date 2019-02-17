<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Filter;
use App\Models\Image;
use View, DB, Response, Session, Request, Redirect, Auth;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Requests\Post\UpdateStatusRequest;
use App\Http\Requests\Post\UpdateAllRequest;

class PostController extends Controller
{

	static $arrFormat = [
		'standard' => 'Standard',
		'image' => 'Image'
	];

	public function __construct()
	{
		parent::__construct();
	}

	public function all()
	{
		// Load all posts
		$posts = Post::getAll( [
			'lang' => self::$param->lang,
			'limit' => self::$setting->itemPerPage,
			'select' => [
				'post.*',
				'content.title as pTitle',
				'content.alias as pAlias',
				'category.title as cTitle',
				'user.email',
				'user.name'
			],
			'where' => Filter::makeQuery( [
				'queryString' => Request::getQueryString(),
				'controller' => self::$param->controller,
				'type' => 'where'
			] ),
			'order' => Filter::makeQuery( [
				'queryString' => Request::getQueryString(),
				'controller' => self::$param->controller,
				'type' => 'order'
			] )
		] );
		
		// Set custom path for pagination
		$posts->setPath( route( 'adminPost', [
			'keyword' => Request::input( 'keyword' ),
			'category' => Request::input( 'category' ),
			'status' => Request::input( 'status' ),
			'format' => Request::input( 'format' ),
			'created_at' => Request::input( 'created_at' ),
			'visit' => Request::input( 'visit' ),
			'pageview' => Request::input( 'pageview' )
		] ) );
		
		// Get all post statistic
		$statistic = Post::statistic();
		
		// Load control button
		$btnControl = $this->loadBtnControl( 'adminPost', [
			'add',
			'publish',
			'unpublish',
			'trash',
			'delete'
		] );

		// Render view
		return View::make( 'admin.' . self::$param->controller . '.all', [
			'titlePage' => ucwords( self::$param->controller ) . ' manager (' . $statistic->total . ')',
			'titlePageExtra' => $statistic->totalActive . ' Active | ' . $statistic->totalDeactive . ' Deactive | ' . $statistic->totalTrash . ' Trash',
			'btnControl' => $btnControl,
			'posts' => $posts,
			'filter' => [
				'keywordVal' => Request::input( 'keyword' ),
				'category' => Filter::Category( [
					'lang' => self::$param->lang,
					'type' => self::$param->controller
				] ),
				'categoryVal' => Request::input( 'category' ),
				'format' => Filter::PostFormat( self::$arrFormat ),
				'formatVal' => Request::input( 'format' ),
				'status' => Filter::Status( [
					'trash' => true
				] ),
				'statusVal' => Request::input( 'status' ),
				'date' => Filter::CreatedAt(),
				'dateVal' => Request::input( 'created_at' ),
				'visit' => Filter::Visit(),
				'visitVal' => Request::input( 'visit' ),
				'pageview' => Filter::Pageview(),
				'pageviewVal' => Request::input( 'pageview' )
			]
		] );
	}

	public function add()
	{
		// Load control button
		$btnControl = $this->loadBtnControl( 'adminPost', [
			'save',
			'saveClose',
			'saveAdd',
			'cancel'
		] );
		
		// Get all categories
		$categories = Category::getAllCategory( [
			'lang' => self::$param->lang
		] );
		
		// Render view
		return View::make( 'admin.' . self::$param->controller . '.form', [
			'titlePage' => 'Post: add',
			'btnControl' => $btnControl,
			'categories' => $categories,
			'formats' => self::$arrFormat
		] );
	}

	public function edit()
	{
		// Get article info
		$post = Post::getOne( [
			'id' => \Route::input( 'id' )
		] );
		if ( count( (array) $post ) == 0 ) {
			return Redirect::route( 'adminPost' )->with( 'message-danger', 'Not found in database.' );
		}
		
		// Get all categories
		$categories = Category::getAllCategory( [
			'lang' => self::$param->lang
		] );
		
		// Get all images
		$imgPath = 'images/' . self::$param->controller . '/' . \Route::input( 'id' );
		$images = glob( public_path( $imgPath ) . '/*' );
		$arrImages = str_replace( public_path( 'images/' . self::$param->controller . '/' . \Route::input( 'id' ) . '/' ), '', $images );
		
		// Load control button
		$btnControl = $this->loadBtnControl( 'adminPost', [
			'save',
			'saveClose',
			'saveAdd',
			'cancel'
		] );
		
		// Update pageview
		DB::table( self::$param->controller )->where( 'id', \Route::input( 'id' ) )->update( [
			'pageview' => DB::raw( 'pageview + 1' )
		] );
		
		// Render
		return View::make( 'admin.' . self::$param->controller . '.form', [
			'titlePage' => 'Post: edit',
			'btnControl' => $btnControl,
			'categories' => $categories,
			'post' => $post,
			'formats' => self::$arrFormat,
			'images' => implode( ',', $arrImages )
		] );
	}

	public function updateStatus( UpdateStatusRequest $r )
	{
		$input = $r->all();
		$response['id'] = $input['id'];
		$response['action'] = ( $input['action'] == 'active' ? 'deactive' : 'active' );
		
		DB::table( strtolower( self::$param->controller ) )->where( 'status', $input['action'] )->where( 'id', $input['id'] )->update( [
			'status' => $response['action']
		] );
		$response['view'] = (string) View::make( 'admin.common.status', [
			'status' => $response['action']
		] );
		
		return Response::json( $response );
	}

	public function updateAll( UpdateAllRequest $r )
	{
		$input = $r->all();
		$response = [
			'action' => $input['action'],
			'arrId' => $input['arrId']
		];
		
		// Make plural
		$controller = str_plural( self::$param->controller, count( $response['arrId'] ) );
		
		if ( $input['action'] != 'Delete' ) {
			if ( $input['action'] == 'Publish' ) {
				$response['action'] = 'active';
				$response['actionStatus'] = 'deactive';
			} elseif ( $input['action'] == 'Unpublish' ) {
				$response['action'] = 'deactive';
				$response['actionStatus'] = 'active';
			} else {
				$response['action'] = 'trash';
			}
			
			$p = DB::table( self::$param->controller );
			if ( isset( $response['actionStatus'] ) )
				$p->where( 'status', '!=', $response['action'] );
			
			$p->where( 'status', '!=', $response['action'] )->whereIn( 'id', $input['arrId'] )->update( [
				'status' => $response['action']
			] );
			
			$response['view'] = (string) View::make( 'admin.common.status', [
				'status' => $response['action']
			] );
		} else {
			// Delete all images for these articles
			Image::deletePost( [
				'controller' => self::$param->controller,
				'arrId' => $input['arrId']
			] );
			
			DB::transaction( function () use ($input ) {
				// delete data in all tables
				DB::table( self::$param->controller )->whereIn( 'id', $input['arrId'] )->delete();
				DB::table( 'content' )->whereIn( 'id', $input['arrId'] )->where( 'tbl', self::$param->controller )->delete();
			} );
			
			Session::flash( 'message-warning', $response['action'] . ' ' . $controller . ' successful!!' );
		}
		
		$response['message'] = [
			ucwords( $response['action'] ) . ' ' . $controller . ' successful!!'
		];
		
		return Response::json( $response );
	}

	public function update( UpdateRequest $r )
	{
		$input = $r->all();
		
		$preData = [
			'tag' => !empty( $input['tag'] ) ? $input['tag'] : null,
			'category' => isset( $input['category'] ) ? implode( ',', $input['category'] ) : null,
			'status' => (string) $input['status'],
			'feature' => !empty( $input['feature'] ) ? $input['feature'] : null
		];
		
		$preDataExtra = [
			'href' => isset( $input['href'] ) && !empty( $input['href'] ) ? $input['href'] : null,
			'target' => isset( $input['target'] ) ? $input['target'] : null
		];
		
		// Insert or Update
		if ( $input['action'] == 'add' ) {
			$response['id'] = DB::table( self::$param->controller )->insertGetId( array_merge( $preData, [
				'user' => Auth::user()->id,
				'format' => $input['format'],
				'created_at' => $input['created_at']
			] ) );
			
			// Update extra format
			if ( $input['format'] != 'standard' ) {
				DB::table( 'post_extra' )->insert( array_merge( $preDataExtra, [
					'id' => $response['id']
				] ) );
			}
		} else {
			$response['id'] = $input['id'];
			DB::table( self::$param->controller )->where( 'id', $response['id'] )->update( array_merge( $preData, [
				'created_at' => $input['created_at'],
				'visit' => DB::raw( 'visit + 1' ),
				'pageview' => DB::raw( 'pageview + 1' )
			] ) );
			
			// Update extra format
			DB::table( 'post_extra' )->where( 'id', $response['id'] )->update( $preDataExtra );
		}
		
		// Upload image
		if ( count( glob( public_path( 'images/tmp/*' ) ) ) > 0 && !empty( $input['imageBoxHolder'] ) ) {
			Image::upload( [
				'id' => $response['id'],
				'images' => $input['imageBoxHolder'],
				'controller' => self::$param->controller
			] );
		}
		
		// Delete current content in db
		DB::table( 'content' )->where( 'id', $response['id'] )->where( 'tbl', self::$param->controller )->delete();
		
		// Update content in db
		foreach ( self::$param->languages as $lang ) {
			DB::table( 'content' )->insert( [
				'id' => $response['id'],
				'lang' => $lang->code,
				'tbl' => self::$param->controller,
				'title' => ucfirst( strip_tags( $input['title' . strtoupper( $lang->code )] ) ),
				'alias' => str_slug( $input['title' . strtoupper( $lang->code )] ),
				'content' => $input['content' . strtoupper( $lang->code )]
			] );
		}
		
		$response['message'] = [
			'Update ' . strtolower( self::$param->controller ) . ' completed!!'
		];
		Session::flash( 'message-success', implode( "\n", $response['message'] ) );
		
		return Response::json( $response );
	}
	
	// Load extra format
	public function extraFormat()
	{
		return View::make( 'admin.post.format.' . Request::input( 'format' ), [
			'post' => Request::input( 'id' ) ? DB::table( 'post_extra' )->find( Request::input( 'id' ) ) : null
		] )->render();
	}

	public function imageBoxHolder()
	{
		// Load all images for 1 ajax request....
		$images = explode( ',', Request::input( 'images' ) );
		$imgHtml = null;
		$tmpPath = 'public/images/tmp/';
		$imgPath = 'public/images/' . Request::input( 'controller' ) . '/' . Request::input( 'id' ) . '/';
		
		foreach ( $images as $img ) {
			// Check file exist
			if ( file_exists( base_path( $tmpPath . $img ) ) || file_exists( base_path( $imgPath . $img ) ) ) {
				$filename = ( file_exists( $tmpPath . $img ) ? $tmpPath : $imgPath ) . $img;
				
				$imgHtml .= View::make( 'admin.post.image-box-holder', [
					'filename' => $filename,
					'active' => Request::input( 'active' )
				] )->render();
			}
		}
		
		return $imgHtml;
	}

	public function primaryImageBoxHolder()
	{
		$id = Request::input( 'id' );
		$filename = Request::input( 'filename' );
		$controller = Request::input( 'controller' );
		if ( $id > 0 && !empty( $filename ) && !empty( $controller ) ) {
			$imgPath = 'public/images/' . $controller . '/' . $id . '/' . basename( $filename );
			
			DB::table( $controller )->where( 'id', $id )->update( [
				'image' => $imgPath
			] );
		}
	}

	public function deleteImageBoxHolder()
	{
		$tmpPath = 'images/tmp/' . basename( Request::input( 'filename' ) );
		$imgPath = 'images/' . Request::input( 'controller' ) . '/' . Request::input( 'id' ) . '/' . basename( Request::input( 'filename' ) );
		
		// Check file exist or not for deleting
		if ( file_exists( public_path( $tmpPath ) ) || file_exists( public_path( $imgPath ) ) ) {
			$filename = file_exists( $tmpPath ) ? $tmpPath : $imgPath;
			
			unlink( $filename );
		}
	}
	
	// Get feature from DB
	public function loadFeatureList()
	{
		$arrFeature = (array) json_decode( Request::input( 'feature' ) );
		
		$response['features'] = DB::table( 'post_feature' )->whereNotIn( 'feature', array_keys( $arrFeature ) )->orderBy( 'feature' )->pluck( 'feature' );
		
		return Response::json( $response );
	}
	
	// Add feature to DB & list
	public function addFeature()
	{
		$feature = Request::input( 'feature' );
		
		if ( DB::table( 'post_feature' )->where( 'feature', $feature )->count() == 0 ) {
			DB::table( 'post_feature' )->insert( [
				'feature' => trim( $feature )
			] );
			
			return Response::json( $feature );
		} else {
			return Response::json( [
				'errors' => 'Duplicate feature.'
			], 422 );
		}
	}
	
	// Delete feature in DB
	public function deleteFeature()
	{
		$feature = Request::input( 'feature' );
		
		// Check exist in db
		if ( DB::table( 'post_feature' )->where( 'feature', $feature )->count() == 0 ) {
			return Response::json( [
				'errors' => 'Not found in database.'
			], 422 );
		}
		
		// Check used in post
		$rowUsed = DB::table( 'post' )->where( 'feature', 'LIKE', '%' . $feature . '%' )->count();
		if ( $rowUsed > 0 ) {
			return Response::json( [
				'errors' => 'This feature has used in other post.'
			], 422 );
		}
		
		// delete this feature in database
		DB::table( 'post_feature' )->where( 'feature', $feature )->delete();
	}
	
	// Create feature from list
	public function createFeature()
	{
		return View::make( 'admin.post.row.feature', [
			'feature' => Request::input( 'feature' )
		] )->render();
	}
	
	// Remove feature from exist list
	public function removeFeature()
	{
	}
	
	// Generate HTML from saved feature data
	public function generateFeature()
	{
		$htmlFeature = null;
		$objFeature = json_decode( Request::input( 'feature' ) );
		
		// return false if no objFeature
		if ( count( (array) $objFeature ) == 0 ) {
			return Response::json( [
				'errors' => 'No features saved.'
			], 422 );
		}
		
		foreach ( $objFeature as $feature => $option ) {
			$htmlFeature .= View::make( 'admin.post.row.feature', [
				'feature' => $feature,
				'options' => $option
			] )->render();
		}
		
		return $htmlFeature;
	}
}
