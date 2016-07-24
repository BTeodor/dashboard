<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;
use App\Models\User;

class UpdateLoginDetailsRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules() {
		$user = $this->getUserForUpdate();

		return [
			'email' => 'required|email|unique:users,email,',
			'username' => 'unique:users,username,',
			'password' => 'min:6|confirmed',
		];
	}

	/**
	 * @return \Illuminate\Routing\Route|object|string
	 */
	protected function getUserForUpdate() {
		return $this->route('user');
	}
}
