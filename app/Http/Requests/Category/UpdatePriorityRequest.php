<?php

namespace App\Http\Requests\Category;

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
			'id' => 'categoryUpdatePriority'
		];
		
		return $rules;
	}

	public function messages()
	{
		$m = [
			'id.category_update_priority' => 'Not found this category or Can\'t move this category priority up/down. It gets the min/max priority.'
		];
		
		return $m;
	}
}
