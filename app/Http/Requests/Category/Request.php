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
		$rules = [];
		
		return $rules;
	}

	public function messages()
	{
		$m = [];
		
		return $m;
	}
}
