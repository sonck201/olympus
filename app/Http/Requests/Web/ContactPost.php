<?php

namespace App\Http\Requests\Web;

use App\Http\Requests\Request;

class ContactPost extends Request
{

	/**
	 * Determine if the user is authorized to make this request.
	 * 
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 * 
	 * @return array
	 */
	public function rules()
	{
		$rules = [
			'name' => 'required|string|max:200',
			'email' => 'required|email|max:200',
			'subject' => 'required|string|max:200',
			'message' => 'required|string|min:50'
		];
		
		return $rules;
	}

	public function messages()
	{
		$message = [];
		$fields = [
			'name',
			'email',
			'subject',
			'message'
		];
		foreach ( $fields as $f ) {
			$message[$f . '.required'] = __( 'Web/global.contact.error.required', [
				'field' => $f
			] );
			
			$message[$f . '.string'] = __( 'Web/global.contact.error.alpha_dash', [
				'field' => $f
			] );
		}
		
		$message['email.email'] = __( 'Web/global.contact.error.email' );
		$message['message.min'] = __( 'Web/global.contact.error.min', [
			'field' => 'message'
		] );
		
		return $message;
	}
}
