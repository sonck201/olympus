<?php

namespace App\Http\Requests\Category;

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
			'parent' => 'required|integer' . ( $arrInput['action'] == 'edit' ? '|categoryUpdateParent' : null )
		];
		
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
			'parent.required' => 'Please input category parent ID',
			'parent.integer' => 'Invalid parent ID',
			'parent.category_update_parent' => 'Please choose another parent'
		];
		
		// Get all titles
		$arrInput = Request::all();
		if ( is_array( $arrInput ) && count( $arrInput ) > 0 ) {
			foreach ( $arrInput as $k => $i ) {
				preg_match( '/^title\w+/', $k, $match );
				if ( count( $match ) ) {
					$m[$k . '.required'] = 'Input category title ' . str_replace( 'title', '', $k ) . '.';
					$m[$k . '.min'] = 'Title ' . str_replace( 'title', '', $k ) . ' must have at least 3 characters.';
					$m[$k . '.max'] = 'Title ' . str_replace( 'title', '', $k ) . ' may not be greater than 100 characters.';
				}
			}
		}
		
		return $m;
	}
}
