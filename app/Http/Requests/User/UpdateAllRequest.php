<?php

namespace App\Http\Requests\User;

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
			'arrId' => 'userUpdateAll'
		];
		
		return $rules;
	}

	public function messages()
	{
		$m = [
// 			'arrId.article_update_all' => 'Has sub-category inside this category. Move or re-arrange them first.'
		];
		
		return $m;
	}
}
