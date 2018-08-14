<?php

namespace App\Http\Controllers\Api\Admin\Permission;

use App\Http\Controllers\Api\Admin\Controller;
use App\Http\Requests\Api\Admin\Permission\RoleCreateRequest;
use App\Http\Requests\Api\Admin\Permission\RoleUpdateRequest;
use App\Repositories\PermissionGroupRepository;
use App\Repositories\RoleRepository;

class RoleController extends Controller
{
    protected $roleRepository;
    protected $permissionGroupRepository;

    public function __construct(RoleRepository $roleRepository, PermissionGroupRepository $permissionGroupRepository)
    {
        parent::__construct();

        $this->middleware('permission:permission_role_list', ['only' => ['index']]);
        $this->middleware('permission:permission_role_add', ['only' => ['store']]);
        $this->middleware('permission:permission_role_edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:permission_role_del', ['only' => ['destroy', 'deletes']]);

        $this->roleRepository            = $roleRepository;
        $this->permissionGroupRepository = $permissionGroupRepository;
    }

    public function index()
    {
        $roles = $this->roleRepository->getList();

        return $this->response->array($roles);
    }

    public function store(RoleCreateRequest $request)
    {
        $reqRole = $request->input('role');

        $checkRole = $this->roleRepository->getCheckOneField('name', $reqRole['name']);

        if (!is_null($checkRole)) {
            return $this->response->error('此權限群組代號已存在.', 403);
        }

        $role = $this->roleRepository->create($reqRole);

        if ($role->id > 0) {

            $reqPermissionIds = $request->input('permission_ids');

            if (isset($reqPermissionIds) && is_array($reqPermissionIds)) {
                $role->savePermissions($reqPermissionIds);
            }
        }

        return $this->response->array('');
    }

    public function show($id)
    {
        $role = $this->roleRepository->getOne($id);

        $permission_ids = $role->perms()->pluck('permission_id');

        return $this->response->array(['role' => $role, 'permission_ids' => $permission_ids]);
    }

    public function update(RoleUpdateRequest $request, $id)
    {
        $orig = $this->roleRepository->getOne($id);

        $reqRole = $request->input('role');

        if (strtoupper($orig->name) != strtoupper($reqRole['name'])) {
            $check = $this->roleRepository->checkNoUnique($reqRole['name']);

            if ($check == 1) {
                return $this->response->error('此權限群組代號已存在.', 403);
            }
        }

        $this->roleRepository->update($id, $reqRole);

        $reqPermissionIds = $request->input('permission_ids');

        $orig->savePermissions(isset($reqPermissionIds) ? $reqPermissionIds : []);

        return $this->response->array('');
    }

    public function destroy($id)
    {
        $role = $this->roleRepository->getOne($id);

        if ($role->users()->count() >= 1) {
            return $this->response->error('角色權限有關聯使用者不可刪除.', 403);
        }

        $role->delete();

        return $this->response->array('');
    }

    public function permissions()
    {
        $permissionGroups = $this->permissionGroupRepository->getList();

        $permissionGroups->load(['permission' => function ($query) {
            $query->selectRaw('permissions.id ,
                                permissions.permission_group_id,
                                permissions.display_type,
                                permissions.display_name,
                                permissions.name')
                ->orderBy('permissions.display_type', 'asc')
                ->orderBy('permissions.sort', 'asc');
        }]);

        $i = 1;
        foreach ($permissionGroups as $key => $group) {

            if ($group->permission->isEmpty()) {
                continue;
            }

            foreach ($group->permission as $permission) {
                $result[($i) . '.' . $group->group_name][$permission->display_type][] = ['id' => $permission->id, 'display_name' => $permission->display_name];
            }

            $i++;
        }

        return $this->response->array($result);
    }
}
