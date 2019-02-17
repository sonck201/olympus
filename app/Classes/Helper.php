<?php

namespace App\Classes;

class Helper
{

	static function getIP()
	{
		if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) )
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) )
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		elseif ( isset( $_SERVER['HTTP_X_FORWARDED'] ) )
			$ip = $_SERVER['HTTP_X_FORWARDED'];
		elseif ( isset( $_SERVER['HTTP_FORWARDED_FOR'] ) )
			$ip = $_SERVER['HTTP_FORWARDED_FOR'];
		elseif ( isset( $_SERVER['HTTP_FORWARDED'] ) )
			$ip = $_SERVER['HTTP_FORWARDED'];
		elseif ( isset( $_SERVER['REMOTE_ADDR'] ) )
			$ip = $_SERVER['REMOTE_ADDR'];
		else
			$ip = 'Unknown IP address';
		
		return $ip;
	}

	static function array_keys_recursive( array $array, $column = null )
	{
		$keys = [];
		
		foreach ( $array as $key => $value ) {
			if ( !is_numeric( $key ) )
				$keys[] = $key;
			
			if ( isset( $value->$column ) && !is_null( $column ) ) {
				$keys = array_merge( $keys, array_keys_recursive( (array) $value->$column ) );
			} elseif ( is_array( $value ) ) {
				$keys = array_merge( $keys, array_keys_recursive( $value ) );
			}
		}
		
		return array_unique( $keys );
	}

	static function getZone( array $array )
	{
		$zones = [];
		foreach ( $array as $k => $v ) {
			if ( isset( $v->zone ) )
				$zones[] = $v->zone;
			
			if ( isset( $v->dropdown ) ) {
				$zones = array_merge( $zones, self::getZone( (array) $v->dropdown ) );
			}
		}
		
		return array_unique( $zones );
	}

	static function isEmail( $email )
	{
		return ( preg_match( '#^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.[a-zA-Z]{2,4}$#', $email ) ? true : false );
	}

	static function getFileExtension( $file_name )
	{
		preg_match( '#\.([^\\.]+?)$#', $file_name, $match );
		return isset( $match[1] ) ? strtolower( $match[1] ) : null;
	}

	static function currentPageURL()
	{
		$pageURL = 'http';
		if ( $_SERVER["HTTPS"] == "on" ) {
			$pageURL .= "s";
		}
		
		$pageURL .= "://";
		
		if ( $_SERVER["SERVER_PORT"] != "80" ) {
			$pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
		} else {
			$pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		}
		
		return $pageURL;
	}

	static function convertImageURL( $content )
	{
		if ( isset( $content ) && $content != '' ) {
			$subURL = 'public/uploads/images/';
			$newContent = str_replace( $subURL, SITEURL . $subURL, $content );
			
			return $newContent;
		}
	}
}