<?php

namespace App\Mailers;

use App\Models\User;

class NotificationMailer extends AbstractMailer {
	public function newUserRegistration(User $recipient, User $newUser) {
		$view = 'emails.notifications.new-registration';
		$data = ['user' => $recipient, 'newUser' => $newUser];
		$subject = 'New User Registration';

		$this->sendTo($recipient->email, $subject, $view, $data);
	}
}