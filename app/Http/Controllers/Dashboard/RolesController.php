<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\Role\Created;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Repositories\Role\RoleRepository;
use App\Repositories\User\UserRepository;

use App\Models\Role;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


class RolesController extends Controller {

	private $roles;


	public function __construct(RoleRepository $roles) {
		$this->roles = $roles;
	}


	public function index() {
		$roles = $this->roles->getAllWithUsersCount();

		return view('dashboard.role.index', compact('roles'));
	}


	public function create() {
		$edit = false;

		return view('dashboard.role.add-edit', compact('edit'));
	}


	public function store(CreateRoleRequest $request) {
		$this->roles->create($request->all());

		return redirect()->route('role.index')->withSuccess(trans('app.role_created'));
	}


	public function edit($role_id) {
		$role = Role::find($role_id);
		$edit = true;

		return view('dashboard.role.add-edit', compact('edit', 'role'));
	}


	public function update($role_id, UpdateRoleRequest $request) {
		$role = Role::find($role_id);
		$this->roles->update($role->id, $request->all());

		return redirect()->route('role.index')->withSuccess(trans('app.role_updated'));
	}


	public function delete($role_id, UserRepository $userRepository) {
		$role = Role::find($role_id);
		if (!$role->removable) {
			return redirect()->route('role.index')->withErrors('Você não pode excluir essa função.');
		}

		$userRole = $this->roles->findByName('Usuario');

		$userRepository->switchRolesForUsers($role->id, $userRole->id);

		$this->roles->delete($role->id);

		Cache::flush();

		return redirect()->route('role.index')->withSuccess(trans('app.role_deleted'));
	}
}