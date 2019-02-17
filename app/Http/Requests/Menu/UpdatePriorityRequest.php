<?php

namespace App\Http\Requests\Menu;

use App\Http\Requests\Request;

class UpdatePriorityRequest extends Request
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
			'id' => 'menuUpdatePriority'
		];
		
		return $rules;
	}

	public function messages()
	{
		$m = [
			'id.menu_update_priority' => 'Not found this menu or Can\'t move this menu priority up/down. It gets the min/max priority.'
		];
		
		return $m;
	}
}
