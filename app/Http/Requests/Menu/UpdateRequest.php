<?php

namespace App\Http\Requests\Menu;

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
		// Get all input
		$arrInput = $this->all();
		
		$rules = [
			'parent' => 'required|integer' . ( $arrInput['action'] == 'edit' ? '||parentExist' : null ),
			'status' => 'in:active,deactive',
			'open_in' => 'in:_self,_blank',
			'class' => 'nullable|alpha_dash',
			'width_column' => 'required|integer|between:50,980',
			'max_column' => 'required|integer|between:1,6'
		];
		
		if ( isset( $arrInput['data'] ) ) {
			$rules['data'] = 'required';
		}
		
		// Get all titles
		if ( is_array( $arrInput ) && count( $arrInput ) > 0 ) {
			foreach ( $arrInput as $k => $i ) {
				preg_match( '/^title\w+/', $k, $match );
				if ( count( $match ) )
					$rules[$k] = 'required|min:3|max:100';
			}
		}
		
		return $rules;
	}

	public function messages()
	{
		$m = [
			'data.check_data' => 'Something wrong with data field!!'
		];
		
		// Get all titles
		$arrInput = Request::all();
		if ( is_array( $arrInput ) && count( $arrInput ) > 0 ) {
			foreach ( $arrInput as $k => $i ) {
				preg_match( '/^title\w+/', $k, $match );
				if ( count( $match ) ) {
					$m[$k . '.required'] = 'Input title ' . str_replace( 'title', '', $k ) . '.';
					$m[$k . '.min'] = 'Title ' . str_replace( 'title', '', $k ) . ' must have at least 3 characters.';
					$m[$k . '.max'] = 'Title ' . str_replace( 'title', '', $k ) . ' may not be greater than 100 characters.';
				}
			}
		}
		
		return $m;
	}
}
