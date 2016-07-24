<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\User\ChangedAvatar;
use App\Events\User\UpdatedProfileDetails;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateProfileDetailsRequest;
use App\Http\Requests\User\UpdateProfileLoginDetailsRequest;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Services\Upload\UserAvatarManager;
use App\Support\Enum\UserStatus;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller {

	protected $theUser;

	private $users;


	public function __construct(UserRepository $users) {
		$this->users = $users;
		$this->theUser = Auth::user();
	}


	public function index(RoleRepository $rolesRepo) {
		$user = $this->theUser;
		//dd($user->avatar);
		$edit = true;
		$roles = $rolesRepo->lists();
		$socials = $user->socialNetworks;
		$socialLogins = $this->users->getUserSocialLogins($this->theUser->id);
		$statuses = UserStatus::lists();

		return view('dashboard/user/profile',
			compact('user', 'edit', 'roles', 'socialLogins', 'socials', 'statuses'));
	}


	public function updateDetails(UpdateProfileDetailsRequest $request) {
		$this->users->update($this->theUser->id, $request->except('role', 'status'));

		event(new UpdatedProfileDetails);

		return redirect()->back()->withSuccess(trans('app.profile_updated_successfully'));
	}


	public function updateAvatar(Request $request, UserAvatarManager $avatarManager) {
		$name = $avatarManager->uploadAndCropAvatar($this->theUser);

		return $this->handleAvatarUpdate($name);
	}


	private function handleAvatarUpdate($avatar) {
		$this->users->update($this->theUser->id, ['avatar' => $avatar]);

		event(new ChangedAvatar);

		return redirect()->route('profile')->withSuccess(trans('app.avatar_changed'));
	}


	public function updateAvatarExternal(Request $request, UserAvatarManager $avatarManager) {
		$avatarManager->deleteAvatarIfUploaded($this->theUser);

		return $this->handleAvatarUpdate($request->get('url'));
	}


	public function updateSocialNetworks(Request $request) {
		$this->users->updateSocialNetworks($this->theUser->id, $request->get('socials'));

		return redirect()->route('profile')->withSuccess(trans('app.socials_updated'));
	}


	public function updateLoginDetails(UpdateProfileLoginDetailsRequest $request) {
		$data = $request->except('role', 'status');

		// se a senha não é fornecida, então vamos
		// remover isso do data array e não alterar ela.
		if (trim($data['password']) == '') {
			unset($data['password']);
			unset($data['password_confirmation']);
		}


		$this->users->update($this->theUser->id, $data);

		return redirect()->route('profile')->withSuccess(trans('app.login_updated'));
	}

}