<?php

namespace App\Http\Requests\Setting;

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
			'siteName' => 'required',
			'siteDescription' => 'required',
			'siteKeyword' => 'required',
			'siteContactEmail' => 'required|email',
			'siteOnline' => 'required|boolean',
			'siteMessage' => 'required',
			'adminTemplate' => 'required',
			'webTemplate' => 'required',
			'language' => 'required',
			'itemPerPage' => 'required|integer',
			'postPerPage' => 'required|integer',
			'userActive' => 'required|boolean',
			'sessionExpire' => 'required|integer',
			'cacheExpire' => 'required|integer',
			'watermark' => 'required|boolean',
			'watermarkDynamicColor' => 'required|boolean',
			'maxPostWidth' => 'required|integer',
			'maxPostHeight' => 'required|integer',
			'mailSmtpServer' => 'string',
			'mailSmtpSeverPort' => 'integer',
			'mailUsername' => 'email',
			'mailName' => 'alpha_num'
		];
		
		return $rules;
	}

	public function messages()
	{
		return [];
	}
}
