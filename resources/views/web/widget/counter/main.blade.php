<?php
use App\Classes\Helper;

// Include helper file
$pluginPath = 'views/web/widget/counter/';
include_once resource_path( $pluginPath . 'helper.php' );

// Set ip
$ip = Helper::getIP();

// Set counter file path
$counterFile = public_path( '/files/counter.log' );
if ( file_exists( $counterFile ) ) {
	$file = fopen( $counterFile, 'r' );
	$digit = fread( $file, filesize( $counterFile ) );
	
	$ipCount = \DB::table( 'user_online' )->where( 'ip', $ip )->count();
	$guest = \DB::table( 'user_online' )->where( 'ip', $ip )->orderBy( 'time', 'ASC' )->first();
	$timeOut = 300;
	
	if ( $ipCount == 0 || ( isset( $guest->time ) && time() > ( $guest->time + $timeOut ) ) || !isset( $guest->time ) ) {
		$digit += 1;
		\DB::table( 'user_online' )->where( 'ip', $ip )->where( 'time', '<', time() - $timeOut )->delete();
	}
	
	$total = $config->initialvalue + $digit;
	
	// show digit
	$arrDigit = getDigits( $total, $config->number_digits );
	$htmlDigit = null;
	foreach ( $arrDigit as $d ) {
		$htmlDigit .= showDigitImage( $config->digit_type, $d );
	}
	
	fclose( $file );
	$file = fopen( $counterFile, 'w' );
	fwrite( $file, $digit );
} else {
	$htmlDigit = showDigitImage( $config->digit_type, 1 );
	$file = fopen( $counterFile, 'w' );
	fwrite( $file, 1 );
	fclose( $file );
}
?>
<div style="padding: 15px 0">
	<div class="text-center">{!!$htmlDigit!!}</div>
</div>