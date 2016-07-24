<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\Settings\Updated as SettingsUpdated;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Setting;


class SettingsController extends Controller {

	public function general() {
		$key='teste.de.setting';
		$value='aquiasetting';
		settings($key, $value);
		return view('dashboard.settings.general');
	}


	public function auth() {
		return view('dashboard.settings.auth');
	}


	public function update(Request $request) {
		$this->updateSettings($request->except("_token"));

		return back()->withSuccess(trans('app.settings_updated'));
	}


	private function updateSettings($input) {

		foreach ($input as $key => $value) {
			Setting::set($key, $value);
		}

		Setting::save();

		event(new SettingsUpdated);
	}




	public function enableCaptcha() {
		$this->updateSettings(['registration.captcha.enabled' => true]);

		return back()->withSuccess(trans('app.recaptcha_enabled'));
	}


	public function disableCaptcha() {
		$this->updateSettings(['registration.captcha.enabled' => false]);

		return back()->withSuccess(trans('app.recaptcha_disabled'));
	}


	public function notifications() {
		return view('dashboard.settings.notifications');
	}
}