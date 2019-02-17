<?php

function &getDigits( $number, $length = 0 )
{
	$strlen = strlen( $number );
	
	$arr = array();
	$diff = $length - $strlen;
	
	// Push Leading Zeros
	while ( $diff > 0 ) {
		array_push( $arr, 0 );
		$diff--;
	}
	
	// For PHP 5.x:
	$arrNumber = str_split( $number );
	
	$arr = array_merge( $arr, $arrNumber );
	
	return $arr;
}

function showDigitImage( $digit_type = 'default', $digit )
{
	$src = asset( 'public/images/counter/' . $digit_type . '/' . $digit . '.png' );
	
	return '<img src="' . $src . '" class="" alt="' . $digit . '" title="' . $digit . '" />';
}