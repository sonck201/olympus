<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use View, Response, Session, DB;
use App\Http\Requests\Web\ContactPost;
use App\Classes\Mail;
use App\Models\Post;

class WebController extends Controller
{

	public function Homepage()
	{
		$banner = Post::getAll( [
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
				'`' . DB::getTablePrefix() . 'post`.`format` = "image"',
				'FIND_IN_SET(' . 119 . ', category)'
			],
			'limit' => 6
		] );
		
		return View::make( 'web.common.homepage', [
			'titlePage' => __( 'Web/global.web.homepage' ),
			'banner' => $banner
		] );
	}

	public function contactGet()
	{
		return View::make( 'web.common.contact', [
			'titlePage' => __( 'Web/global.web.contact' ),
			'breadcrumb' => $this->breadcrumb( [
				[
					'title' => __( 'Web/global.web.contact' )
				]
			] ),
			'captcha' => \App\Classes\Captcha::render()
		] );
	}

	public function contactPost( ContactPost $r )
	{
		$input = $r->all();
		$captcha = strtolower( session( 'captcha' ) );
		
		if ( $captcha != $input['captcha'] ) {
			return Response::json( [
				'errors' => __( 'Web/global.contact.error.captcha_not_correct' )
			], 422 );
		}
		
		Mail::send( [
			'from' => $r->input( 'email' ),
			'fromName' => $r->input( 'name' ),
			'to' => self::$setting->siteContactEmail,
			'toName' => self::$setting->mailName,
			'reply' => $r->input( 'email' ),
			'replyName' => $r->input( 'name' ),
			'subject' => $r->input( 'subject' ),
			'message' => View::make( 'web.mail.contact', [
				'name' => $r->input( 'name' ),
				'email' => $r->input( 'email' ),
				'message' => strip_tags( nl2br( $r->input( 'message' ) ) )
			] )->render()
		] );
		
		Session::flash( 'message-success', __( 'Web/global.contact.mailSent' ) );
		
		return Response::json( [
			'mailSent' => true
		] );
	}

	public function generateCaptcha()
	{
		return \App\Classes\Captcha::render();
	}
}
