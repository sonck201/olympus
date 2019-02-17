<?php

namespace App\Http\Requests\Post;

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
			'category' => 'array',
			'status' => 'in:active,deactive,trash',
			'tag' => 'max:255',
			'image' => 'url'
		];
		
		// Get all titles
		if ( is_array( $arrInput ) && count( $arrInput ) > 0 ) {
			foreach ( $arrInput as $input => $i ) {
				preg_match( '/^(title|content)\w+/', $input, $match );
				if ( count( $match ) ) {
					if ( $match[1] == 'title' )
						$rules[$input] = 'required|min:3|max:255';
					elseif ( $match[1] == 'content' )
						$rules[$input] = 'max:5000';
				}
			}
		}
		
		return $rules;
	}

	public function messages()
	{
		$m = [
			'image.url' => 'Something went wrong with uploader!!'
		];
		
		// Get all titles
		$arrInput = Request::all();
		if ( is_array( $arrInput ) && count( $arrInput ) > 0 ) {
			foreach ( $arrInput as $input => $i ) {
				// title
				preg_match( '/^(title|brief|content)\w+/', $input, $match );
				if ( count( $match ) > 0 ) {
					$m[$input . '.required'] = ucwords( $match[1] ) . ' ' . preg_replace( '/^(title|brief|content)/', '', $input ) . ' is missing.';
					$m[$input . '.min'] = ucwords( $match[1] ) . ' ' . preg_replace( '/^(title|brief|content)/', '', $input ) . ' must have at least 3 characters.';
					$m[$input . '.max'] = ucwords( $match[1] ) . ' ' . preg_replace( '/^(title|brief|content)/', '', $input ) . ' may not be too large.';
				}
			}
		}
		
		return $m;
	}
}
