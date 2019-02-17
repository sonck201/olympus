<?php

namespace App\Classes;

use App\Http\Controllers\Controller;

class Mail
{

	static function send( $content )
	{
		$setting = Controller::$setting;
		
		require base_path( '/vendor/phpmailer/phpmailer/class.phpmailer.php' );
		require base_path( '/vendor/phpmailer/phpmailer/PHPMailerAutoload.php' );
		
		$mail = new \PHPMailer();
		try {
			$mail->isSMTP();
			$mail->SMTPDebug = 0;
			$mail->SMTPAuth = true;
			$mail->CharSet = 'utf-8';
			$mail->SMTPAuth = true;
			$mail->SMTPSecure = 'ssl';
			$mail->Host = $setting->mailSmtpServer;
			$mail->Port = $setting->mailSmtpSeverPort;
			$mail->Username = $setting->mailUsername;
			$mail->Password = $setting->mailPassword;
			$mail->setFrom( $content['from'], $content['fromName'] );
			$mail->addReplyTo( $content['reply'], $content['replyName'] );
			
			$mail->Subject = $content['subject'];
			$mail->MsgHTML( $content['message'] );
			$mail->addAddress( $content['to'], $content['toName'] );
			
			$mail->send();
		} catch ( phpmailerException $e ) {
			dd( $e );
		} catch ( Exception $e ) {
			dd( $e );
		}
		
		return true;
	}
}