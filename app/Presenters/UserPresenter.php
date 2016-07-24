<?php

namespace App\Presenters;

use App\Support\Enum\UserStatus;
use Illuminate\Support\Str;
use Laracodes\Presenter\Presenter;

class UserPresenter extends Presenter {
	public function name() {
		return sprintf("%s %s", $this->model->first_name, $this->model->last_name);
	}

	public function nameOrEmail() {
		return trim($this->name()) ?: $this->model->email;
	}

	public function avatar() {
		if (!$this->model->avatar) {
			return url('assets/img/profile.png');
		}

		return Str::contains($this->model->avatar, ['http', 'gravatar'])
		? $this->model->avatar
		: url("upload/users/{$this->model->avatar}");
	}

	public function birthday() {
		return $this->model->birthday
		? $this->model->birthday
		: '-';
	}


	public function lastLogin() {
		return $this->model->last_login
		? $this->model->last_login
		: '-';
	}

	/**
	 * Determine css class used for status labels
	 * inside the users table by checking user status.
	 *
	 * @return string
	 */
	public function labelClass() {
		switch ($this->model->status) {
		case UserStatus::ACTIVE:
			$class = 'success';
			break;

		case UserStatus::BANNED:
			$class = 'danger';
			break;

		default:
			$class = 'warning';
		}

		return $class;
	}
}