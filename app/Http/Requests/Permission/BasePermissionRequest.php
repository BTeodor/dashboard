<?php

namespace App\Http\Requests\Permission;

use App\Http\Requests\Request;

class BasePermissionRequest extends Request {

	public function authorize()
	{
		return true;
	}

	public function messages() {
		return [
			'name.unique' => trans('app.permission_already_exists'),
		];
	}
}