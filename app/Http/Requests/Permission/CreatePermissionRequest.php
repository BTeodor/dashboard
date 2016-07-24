<?php

namespace App\Http\Requests\Permission;

class CreatePermissionRequest extends BasePermissionRequest {

	public function authorize()
	{
		return true;
	}

	public function rules() {
		return [
			'name' => 'required|regex:/^[a-zA-Z0-9\-_\.]+$/|unique:permissions,name',
		];
	}
}
