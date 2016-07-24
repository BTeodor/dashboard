<?php

namespace App\Http\Controllers\Dashboard;

use App\Events\Role\PermissionsUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Permission\CreatePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Repositories\Permission\PermissionRepository;
use App\Repositories\Role\RoleRepository;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionsController extends Controller {

	private $roles;

	private $permissions;


	public function __construct(RoleRepository $roles, PermissionRepository $permissions) {
		$this->roles = $roles;
		$this->permissions = $permissions;
	}


	public function index() {
		$roles = $this->roles->all();
		$permissions = $this->permissions->all();

		return view('dashboard.permission.index', compact('roles', 'permissions'));
	}


	public function create() {
		$edit = false;

		return view('dashboard.permission.add-edit', compact('edit'));
	}


	public function store(CreatePermissionRequest $request) {
		$this->permissions->create($request->all());

		return redirect()->route('dashboard.permission.index')->withSuccess(trans('app.permission_created_successfully'));
	}


	public function edit($permission_id) {
		$permission = Permission::find($permission_id);
		$edit = true;

		return view('dashboard.permission.add-edit', compact('edit', 'permission'));
	}


	public function update($permission_id, UpdatePermissionRequest $request) {
		$permission = Permission::find($permission_id);
		$this->permissions->update($permission->id, $request->all());

		return redirect()->route('dashboard.permission.index')->withSuccess(trans('app.permission_updated_successfully'));
	}


	public function destroy($permission_id) {
		$permission = Permission::find($permission_id);
		if (!$permission->removable) {
			return redirect()->route('dashboard.permission.index')->withErrors('Você não pode excluir essa permissão.');
		}

		$this->permissions->delete($permission->id);

		return redirect()->route('dashboard.permission.index')->withSuccess(trans('app.permission_deleted_successfully'));
	}


	public function saveRolePermissions(Request $request) {
		$roles = $request->get('roles');

		$allRoles = $this->roles->lists('id');

		foreach ($allRoles as $roleId) {
			$permissions = array_get($roles, $roleId, []);
			$this->roles->updatePermissions($roleId, $permissions);
		}

		event(new PermissionsUpdated);

		return redirect()->route('dashboard.permission.index')->withSuccess(trans('app.permissions_saved_successfully'));
	}
}