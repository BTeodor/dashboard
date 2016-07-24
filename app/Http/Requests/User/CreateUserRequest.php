<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class CreateUserRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules() {
		return [
			'email' => 'required|email|unique:users,email',
			'username' => 'unique:users,username',
			'password' => 'required|min:6|confirmed',
			'birthday' => 'date',
			'role' => 'required|exists:roles,id',
		];
	}
}
