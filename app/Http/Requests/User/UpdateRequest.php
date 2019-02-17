<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class UpdateRequest extends Request
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
			'email' => 'required|email',
			'status' => 'required|in:active,deactive,trash',
			'role' => 'required|integer|checkRole',
			'subscribe' => 'required|in:yes,no'
		];
		
		return $rules;
	}

	public function messages()
	{
		$m = ['role.check_role' => 'You wanna have a hight role???'];
		
		return $m;
	}
}
