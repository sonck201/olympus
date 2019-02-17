<?php

namespace App\Http\Requests\Widget;

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
			'arrId' => 'widgetUpdateAll'
		];
		
		return $rules;
	}

	public function messages()
	{
		$m = [
			'arrId.widget_update_all' => 'Error happened!!'
		];
		
		return $m;
	}
}
