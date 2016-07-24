<?php

namespace App\Http\Requests\Role;

use App\Http\Requests\Request;

class UpdateRoleRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function rules() {
		return [
			'name' => 'required|regex:/^[a-zA-Z0-9\-_\.]+$/|unique:roles,name,'
		];
	}
}
