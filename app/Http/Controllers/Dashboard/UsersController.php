<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\User\Banned;
use App\Events\User\Deleted;
use App\Events\User\UpdatedByAdmin;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\UpdateDetailsRequest;
use App\Http\Requests\User\UpdateLoginDetailsRequest;
use App\Repositories\Activity\ActivityRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;
use App\Services\Upload\UserAvatarManager;
use App\Support\Enum\UserStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;


class UsersController extends Controller {

	private $users;


	public function __construct(UserRepository $users) {
		$this->users = $users;
	}


	public function index(RoleRepository $roleRepository) {
		$perPage = 10;

		$users = $this->users->paginate($perPage, Input::get('search'), Input::get('status'));
		$roles = $roleRepository->lists();
		$statuses = ['' => trans('app.all')] + UserStatus::lists();

		return view('dashboard.user.list', compact('users', 'statuses', 'roles'));
	}


	public function view($user_id, ActivityRepository $activities) {
		$user= User::find($user_id);
		$socialNetworks = $user->socialNetworks;

		$userActivities = $activities->getLatestActivitiesForUser($user->id, 10);

		return view('dashboard.user.view', compact('user', 'socialNetworks', 'userActivities'));
	}


	public function create(RoleRepository $roleRepository) {
		$roles = $roleRepository->lists();
		$statuses = UserStatus::lists();

		return view('dashboard.user.add', compact('roles', 'statuses'));
	}


	public function store(CreateUserRequest $request) {
		// Quando o usuario é criado pelo administrador,
		// o status será ativo por padrão.
		$data = $request->all() + ['status' => UserStatus::ACTIVE];

		// Username só deve ser atualizado se ele é fornecido.
		// Então, se ele é uma string vazia, deixamos como esta.
		if (trim($data['username']) == '') {
			$data['username'] = null;
		}

		$user = $this->users->create($data);
		$this->users->updateSocialNetworks($user->id, []);
		$this->users->setRole($user->id, $request->get('role'));

		return redirect()->route('user.list')->withSuccess(trans('app.user_created'));
	}


	public function edit($user_id, RoleRepository $roleRepository) {
		$edit = true;
		$user= User::find($user_id);
		$socials = $user->socialNetworks;
		$roles = $roleRepository->lists();
		$statuses = UserStatus::lists();
		$socialLogins = $this->users->getUserSocialLogins($user->id);

		return view('dashboard.user.edit',
			compact('edit', 'user', 'socials', 'socialLogins', 'roles', 'statuses'));
	}


	public function updateDetails($user_id, UpdateDetailsRequest $request) {
		$user= User::find($user_id);
		$this->users->update($user->id, $request->all());
		$this->users->setRole($user->id, $request->get('role'));

		event(new UpdatedByAdmin($user));

		// se o status do usuario foi atualizado para "Banned",
		// disparar o evento apropriado.
		if ($this->userIsBanned($user, $request)) {
			event(new Banned($user));
		}

		return redirect()->back()->withSuccess(trans('app.user_updated'));
	}


	private function userIsBanned($user, Request $request) {
		return $user->status != $request->status && $request->status == UserStatus::BANNED;
	}


	public function updateAvatar($user_id, UserAvatarManager $avatarManager) {
		$user= User::find($user_id);
		$name = $avatarManager->uploadAndCropAvatar($user);

		$this->users->update($user->id, ['avatar' => $name]);

		event(new UpdatedByAdmin($user));

		return redirect()->route('user.edit', $user->id)->withSuccess(trans('app.avatar_changed'));
	}


	public function updateAvatarExternal($user_id, Request $request, UserAvatarManager $avatarManager) {
		$user= User::find($user_id);
		$avatarManager->deleteAvatarIfUploaded($user);

		$this->users->update($user->id, ['avatar' => $request->get('url')]);

		event(new UpdatedByAdmin($user));

		return redirect()->route('user.edit', $user->id)->withSuccess(trans('app.avatar_changed'));
	}


	public function updateSocialNetworks($user_id, Request $request) {
		$user= User::find($user_id);
		$this->users->updateSocialNetworks($user->id, $request->get('socials'));

		event(new UpdatedByAdmin($user));

		return redirect()->route('user.edit', $user->id)->withSuccess(trans('app.socials_updated'));
	}


	public function updateLoginDetails($user_id, UpdateLoginDetailsRequest $request) {
		$user= User::find($user_id);
		$data = $request->all();

		if (trim($data['password']) == '') {
			unset($data['password']);
			unset($data['password_confirmation']);
		}

		$this->users->update($user->id, $data);

		event(new UpdatedByAdmin($user));

		return redirect()->route('user.edit', $user->id)->withSuccess(trans('app.login_updated'));
	}


	public function delete($user_id) {
		$user= User::find($user_id);
		if ($user->id == Auth::id()) {
			return redirect()->route('user.list')->withErrors(trans('app.you_cannot_delete_yourself'));
		}

		$this->users->delete($user->id);

		event(new Deleted($user));

		return redirect()->route('user.list')->withSuccess(trans('app.user_deleted'));
	}

}