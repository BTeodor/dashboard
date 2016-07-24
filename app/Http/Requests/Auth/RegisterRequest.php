<?php

namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;

class RegisterRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules() {
		$rules = [
			'email' => 'required|email|unique:users,email',
			'username' => 'required|unique:users,username',
			'first_name' => 'required',
			'last_name' => 'required',
			'password' => 'required|confirmed|min:6',
		];

		if (settings('registration.captcha.enabled')) {
			$rules['g-recaptcha-response'] = 'required|captcha';
		}

		if (settings('tos')) {
			$rules['tos'] = 'accepted';
		}

		return $rules;
	}

	public function messages() {
		return [
			'tos.accepted' => trans('app.you_have_to_accept_tos'),
		];
	}
}
