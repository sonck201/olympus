<?php

namespace App\Http\Requests\Menu;

use App\Http\Requests\Request;

class UpdateAllRequest extends Request
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
			'arrId' => 'menuUpdateAll'
		];
		
		return $rules;
	}

	public function messages()
	{
		$m = [
			'arrId.menu_update_all' => 'Has sub-menu. Move or re-arrange them first.'
		];
		
		return $m;
	}
}
