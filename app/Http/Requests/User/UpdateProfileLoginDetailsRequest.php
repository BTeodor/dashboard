<?php

namespace App\Http\Requests\User;

use App\Models\User;

class UpdateProfileLoginDetailsRequest extends UpdateLoginDetailsRequest {

	public function authorize()
	{
		return true;
	}
	protected function getUserForUpdate() {
		return \Auth::user();
	}
}
