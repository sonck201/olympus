<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Classes\UploadHandler;

class FileController extends Controller
{

	public function __construct()
	{
	}

	public function upload()
	{
		$upload_handler = new UploadHandler( [
			'upload_dir' => public_path( 'images/tmp/' ),
			'image_versions' => [
				'' => [
					'auto_orient' => true
				]
			]
		] );
		// 'thumbnail' => [
		// 'upload_dir' => public_path( 'images/tmp/thumb' ),
		// 'max_width' => 100,
		// 'max_height' => 100
		// ]
	}
}