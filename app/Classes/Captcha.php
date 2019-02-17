<?php

namespace App\Classes;

class Captcha
{

	static function render( $option = [] )
	{
		$opt = [
			'timeOut' => 300,
			'wordLen' => 6,
			'height' => 46,
			'width' => 200,
			'fontSize' => 20,
			'spaceWord' => 30,
			'imgAlt' => 'Captcha',
			'imgDir' => public_path( 'files/captcha/' ),
			'imgUrl' => asset( 'public/files/captcha/' ),
			'font' => public_path( 'assets/fonts/georgia.ttf' )
		];
		
		if ( is_array( $option ) ) {
			if ( isset( $option['timeOut'] ) )
				$opt['timeOut'] = $option['timeOut'];
			
			if ( isset( $option['wordLen'] ) )
				$opt['wordLen'] = $option['wordLen'];
			
			if ( isset( $option['height'] ) )
				$opt['height'] = $option['height'];
			
			if ( isset( $option['width'] ) )
				$opt['width'] = $option['width'];
			
			if ( isset( $option['font'] ) )
				$opt['font'] = $option['font'];
			
			if ( isset( $option['fontSize'] ) )
				$opt['font'] = $option['fontSize'];
			
			if ( isset( $option['spaceWord'] ) )
				$opt['spaceWord'] = $option['spaceWord'];
			
			if ( isset( $option['imgAlt'] ) )
				$opt['imgAlt'] = $option['imgAlt'];
			
			if ( isset( $option['imgDir'] ) )
				$opt['imgDir'] = $option['imgDir'];
			
			if ( isset( $option['imgUrl'] ) )
				$opt['imgUrl'] = $option['imgUrl'];
		}
		
		$captchaWord = str_random( 6 );
		$captchaWord = preg_replace( '/(o|O|0)/i', 's', $captchaWord );
		session( [
			'captcha' => $captchaWord
		] );
		
		self::deleteImage( $opt['timeOut'] );
		self::generateImage( $captchaWord, $opt );
		
		return $opt['imgUrl'] . '/' . $captchaWord . '.png';
	}

	static function generateImage( $word, $opt )
	{
		$rgb_code_1 = 100;
		$rgb_code_2 = 200;
		
		$rgb_code_3 = 100;
		$rgb_code_4 = 255;
		
		$rgb_code_5 = 200;
		$rgb_code_6 = 150;
		
		$w = $opt['width'];
		$h = $opt['height'];
		$fsize = $opt['fontSize'];
		$length = $opt['wordLen'];
		$font = $opt['font'];
		$spaceWord = $opt['spaceWord'];
		$imgFile = $opt['imgDir'] . $word . '.png';
		
		$dotNoiseLevel = 200;
		$lineNoiseLevel = 25;
		
		// Lets create verification image
		$image = imagecreate( $w, $h );
		
		$background = imagecolorallocate( $image, 255, 255, 255 );
		imagefill( $image, 0, 0, $background );
		
		// Draw some dots
		for ( $i = 0; $i < $dotNoiseLevel; $i++ ) {
			$color = imagecolorallocate( $image, mt_rand( $rgb_code_1, $rgb_code_2 ), mt_rand( $rgb_code_1, $rgb_code_2 ), mt_rand( $rgb_code_1, $rgb_code_2 ) );
			imagesetpixel( $image, mt_rand( 0, $w ), mt_rand( 0, $h ), $color );
		}
		
		// Draw some lines
		for ( $i = 1; $i < $lineNoiseLevel; $i++ ) {
			$color = imagecolorallocate( $image, mt_rand( $rgb_code_3, $rgb_code_4 ), mt_rand( $rgb_code_3, $rgb_code_4 ), mt_rand( $rgb_code_3, $rgb_code_4 ) );
			imageline( $image, mt_rand( 0, $w ), mt_rand( 0, $h ), mt_rand( 0, $w ), mt_rand( 0, $h ), $color );
		}
		
		// Draw border
		$color = imagecolorallocate( $image, $rgb_code_5, $rgb_code_5, $rgb_code_5 );
		imagerectangle( $image, 0, 0, $w - 1, $h - 1, $color );
		
		// verification code colors
		for ( $i = 0; $i < $length; $i++ ) {
			$foreground[$i] = imagecolorallocate( $image, mt_rand( 0, $rgb_code_6 ), mt_rand( 0, $rgb_code_6 ), mt_rand( 0, $rgb_code_6 ) );
		}
		
		// verifycation word -> $_SESSION
		$textWidth = strlen( $word ) * $spaceWord;
		$textHeight = $fsize + 1;
		
		$verification_letters = str_split( $word );
		for ( $i = 0; $i < $length; $i++ ) {
			$angle = mt_rand( -25, 25 );
			$x = ( $w - $textWidth ) / 2 + ( $i * $spaceWord ) + 10;
			$y = ( $h + $textHeight ) / 2 + mt_rand( -( ( $h + $textHeight ) / 2 - $textHeight ) / 2, ( $h - ( $h + $textHeight ) / 2 ) / 2 );
			
			imagettftext( $image, $fsize, $angle, $x, $y, $foreground[$i], $font, $verification_letters[$i] );
			// imagettftext($image, $fsize, $angle, $x, $y, $foreground[$i], $font, ($h - ($h + $textHeight)/2)/2);
		}
		
		imagepng( $image, $imgFile );
		imagedestroy( $image );
	}

	static function deleteImage( $timeOut )
	{
		$images = glob( public_path( 'files/captcha/*' ) );
		foreach ( $images as $img ) {
			if ( filectime( $img ) + $timeOut < time() )
				unlink( $img );
		}
	}
}