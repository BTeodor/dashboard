<?php

namespace App\Http\Requests\Auth\Social;

use App\Http\Requests\Request;

class SaveEmailRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules() {
		return [
			'email' => 'required|email|unique:users,email',
		];
	}
}
