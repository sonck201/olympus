<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Image extends Model
{

	protected static $imgPath;

	protected static $defaultImgPath = '/images/dummy.jpg';

	static function setImgPath()
	{
		return preg_match( '/^\/public\//i', $_SERVER['REQUEST_URI'], $match ) > 0 ? true : false;
	}

	static function getDefaultImgPath()
	{
		return $_SERVER['DOCUMENT_ROOT'] . '/' . self::$imgPath . self::$defaultImgPath;
	}

	static function getImgPath( $img )
	{
		// $img = trim( strtolower( $img ) );
		return base_path( self::$imgPath . $img );
	}

	static function render( $img )
	{
		// Reset self::$imgPath... unless public in url => kill
		// self::$imgPath = self::setImgPath() == true ? 'public/' : '/';
		
		return asset( file_exists( self::getImgPath( $img ) ) && filesize( self::getImgPath( $img ) ) > 0 ? $img : self::$defaultImgPath );
	}

	static function upload( $param = [] )
	{
		// $publicPath = $_SERVER['DOCUMENT_ROOT'] . ( self::setImgPath() == true ? '/public/' : '/' );
		$imgPath = public_path( 'images/' );
		$thbPath = public_path( 'thumbs/' );
		
		// Move uploaded images
		$arrImage = explode( ',', $param['images'] );
		
		// return if not count image in array
		if ( count( $arrImage ) == 0 ) {
			return;
		}
		
		// Create new folder
		$movedFolder = $imgPath . $param['controller'] . '/' . $param['id'];
		
		// Check dir_exist or not => mkdir
		if ( !file_exists( $movedFolder ) && !is_dir( $movedFolder ) )
			@mkdir( $movedFolder, 0755, true );
		
		foreach ( $arrImage as $img ) {
			$movedImage = basename( $img );
			
			// Check file exist or not to upload
			if ( file_exists( public_path( 'images/tmp/' ) . $img ) ) {
				@copy( public_path( 'images/tmp/' ) . $img, $movedFolder . '/' . $movedImage );
			}
		}
		
		// Delete all images from this session inside tmp folder
		self::deleteImage( $imgPath . 'tmp' );
		self::deleteImage( $thbPath . 'tmp' );
		
		// Update in database
		DB::table( $param['controller'] )->where( 'id', $param['id'] )->update( [
			'image' => 'public/images/' . $param['controller'] . '/' . $param['id'] . '/' . $movedImage
		] );
	}

	static function deletePost( $param = [] )
	{
		if ( isset( $param['arrId'] ) && count( $param['arrId'] ) > 0 ) {
			$documentPath = $_SERVER['DOCUMENT_ROOT'] . ( self::setImgPath() == true ? '/public/' : '/' );
			foreach ( $param['arrId'] as $id ) {
				$imagePath = $documentPath . 'images/' . $param['controller'] . '/' . $id;
				$thumbPath = $documentPath . 'thumbs/' . $param['controller'] . '/' . $id;
				
				self::deleteImage( $imagePath );
				self::deleteImage( $thumbPath );
				@rmdir( $imagePath );
				@rmdir( $thumbPath );
			}
		}
	}

	static function deleteImage( $filename, $debug = false )
	{
		if ( is_file( $filename ) ) {
			$debug == true ? unlink( $filename ) : @unlink( $filename );
		} else {
			foreach ( glob( $filename . '/*' ) as $f ) {
				is_file( $f ) ? unlink( $f ) : self::deleteImage( $f );
			}
			
			if ( basename( $filename ) != 'tmp' )
				$debug == true ? rmdir( $filename ) : @rmdir( $filename );
		}
	}
}
