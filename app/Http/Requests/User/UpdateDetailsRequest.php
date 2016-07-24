<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;

class UpdateDetailsRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules() {
		return [
			'birthday' => 'date',
			'role' => 'required|exists:roles,id',
		];
	}
}
