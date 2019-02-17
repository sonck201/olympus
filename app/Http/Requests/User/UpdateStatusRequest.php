<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class UpdateStatusRequest extends Request
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
			'id' => 'userExist'
		];
		
		return $rules;
	}

	public function messages()
	{
		$m = [
			'id.user_exist' => 'Not found this user in database.'
		];
		
		return $m;
	}
}
