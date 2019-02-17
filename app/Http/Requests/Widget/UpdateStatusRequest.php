<?php

namespace App\Http\Requests\Widget;

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
			'id' => 'widgetExist'
		];
		
		return $rules;
	}

	public function messages()
	{
		$m = [
			'id.widget_exist' => 'Not found this widget in database.'
		];
		
		return $m;
	}
}
