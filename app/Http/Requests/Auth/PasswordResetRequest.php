<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class PasswordResetRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules() {
		return [
			'token' => 'required',
			'email' => 'required|email',
			'password' => 'required|confirmed|min:6',
		];
	}
}
