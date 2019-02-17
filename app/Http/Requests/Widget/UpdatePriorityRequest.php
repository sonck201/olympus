<?php

namespace App\Http\Requests\Widget;

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
			'id' => 'widgetUpdatePriority'
		];
		
		return $rules;
	}

	public function messages()
	{
		$m = [
			'id.widget_update_priority' => 'Not found this widget or Can\'t move this widget priority up/down. It gets the min/max priority.'
		];
		
		return $m;
	}
}
