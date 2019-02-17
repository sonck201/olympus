var elixir = require( 'laravel-elixir' ), gulp = require( 'gulp' ), htmlmin = require( 'gulp-htmlmin' ), minifyCss = require( 'gulp-clean-css' ), minifyJs = require( 'gulp-uglify' );

elixir.config.sourcemaps = false;
elixir.config.production = true;
elixir.extend( 'compressHtml', function( message ){
	new elixir.Task( 'compressHtml', function(){
		return gulp.src( './storage/framework/views/*' ).pipe( htmlmin( {
		    collapseWhitespace: true,
		    removeAttributeQuotes: true,
		    removeComments: true,
		    minifyCSS: true,
		    minifyJS: true
		} ) ).pipe( gulp.dest( './storage/framework/views/' ) )
	} ).watch( './storage/framework/views/*' );
} );

elixir.extend( 'compressAsset', function( message ){
	// Minify backend
	new elixir.Task( 'minifyAdminCss', function(){
		return gulp.src( './resources/assets/admin/css/*' ).pipe( minifyCss() ).pipe( gulp.dest( './public/templates/admin/css/' ) );
	} ).watch( './resources/assets/admin/css/*' );
	
	new elixir.Task( 'minifyAdminJs', function(){
		return gulp.src( './resources/assets/admin/js/*' ).pipe( minifyJs() ).pipe( gulp.dest( './public/templates/admin/js/' ) );
	} ).watch( './resources/assets/admin/js/*' );
	
	// Minify frontend
	new elixir.Task( 'minifyWebCss', function(){
		return gulp.src( './resources/assets/web/css/*' ).pipe( minifyCss() ).pipe( gulp.dest( './public/templates/web/css/' ) );
	} ).watch( './resources/assets/web/css/*' );
	
	new elixir.Task( 'minifyWebJs', function(){
		return gulp.src( './resources/assets/web/js/*' ).pipe( minifyJs() ).pipe( gulp.dest( './public/templates/web/js/' ) );
	} ).watch( './resources/assets/web/js/*' );
} );

elixir( function( mix ){
	mix.compressAsset();
// mix.compressHtml();
} );