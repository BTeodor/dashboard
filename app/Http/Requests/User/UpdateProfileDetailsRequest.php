<?php

namespace App\Http\Requests\User;

use App\Http\Requests\Request;


class UpdateProfileDetailsRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules() {
		return [
			'birthday' => 'date',
		];
	}
}
