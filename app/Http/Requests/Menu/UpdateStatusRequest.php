<?php

namespace App\Http\Requests\Menu;

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
			'id' => 'menuExist'
		];
		
		return $rules;
	}

	public function messages()
	{
		$m = [
			'id.menu_exist' => 'Not found this menu in database.'
		];
		
		return $m;
	}
}
