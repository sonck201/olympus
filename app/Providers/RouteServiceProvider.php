<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App\Models\Language;

class RouteServiceProvider extends ServiceProvider
{

	/**
	 * This namespace is applied to your controller routes.
	 * In addition, it is set as the URL generator's root namespace.
	 * 
	 * @var string
	 */
	protected $namespace = 'App\Http\Controllers';

	/**
	 * Define your route model bindings, pattern filters, etc.
	 * 
	 * @return void
	 */
	public function boot()
	{
		parent::boot();
	}

	/**
	 * Define the routes for the application.
	 * 
	 * @return void
	 */
	public function map()
	{
		$this->mapApiRoutes();
		
		$this->mapWebRoutes();
	}

	/**
	 * Define the "web" routes for the application.
	 * These routes all receive session state, CSRF protection, etc.
	 * 
	 * @return void
	 */
	protected function mapWebRoutes()
	{
		Route::pattern( 'id', '[0-9]+' );
		Route::pattern( 'title', '[a-z0-9\-]+' );
		Route::pattern( 'type', '[a-z\-]+' );
		Route::pattern( 'lang', '[a-z]+' );
		
		Route::group( [
			'middleware' => 'web',
			'namespace' => $this->namespace
		], function () {
			// Setup language to detemine url
			$language = Language::getAll()->toArray();
			
			// Setup router for web
			require base_path( 'routes/Web/GlobalRoute.php' );
			
			// Setup router for admin
			require base_path( 'routes/Admin/GlobalRoute.php' );
			require base_path( 'routes/Admin/UserRoute.php' );
			require base_path( 'routes/Admin/CategoryRoute.php' );
			require base_path( 'routes/Admin/PostRoute.php' );
			require base_path( 'routes/Admin/MenuRoute.php' );
			require base_path( 'routes/Admin/WidgetRoute.php' );
		} );
	}

	/**
	 * Define the "api" routes for the application.
	 * These routes are typically stateless.
	 * 
	 * @return void
	 */
	protected function mapApiRoutes()
	{
		Route::prefix( 'api' )->middleware( 'api' )->namespace( $this->namespace )->group( base_path( 'routes/api.php' ) );
	}
}
