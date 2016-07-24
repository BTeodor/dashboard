<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class UploadAvatarRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules() {
		return [
			'file' => 'required|image',
		];
	}
}
