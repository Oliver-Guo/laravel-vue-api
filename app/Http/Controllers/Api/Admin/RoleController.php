<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Controller;
use App\Http\Requests\Api\Admin\RoleCreateRequest;
use App\Http\Requests\Api\Admin\RoleUpdateRequest;
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

    /**
     * @api {GET} /api/admin/permission_role /api/admin/permission_role
     * @apiDescription 角色權限列表
     * @apiGroup AdminPermissionRole
     * @apiPermission jwt
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200
     *{
     *    "roles": [
     *        {
     *            "id": 1,
     *            "name": "Servitor",
     *            "display_name": "工讀生",
     *            "created_at": "2018-02-27 13:55:22",
     *            "updated_at": "2018-02-27 13:58:21"
     *        },
     *        {
     *            "id": 2,
     *            "name": "Admin",
     *            "display_name": "最高權限",
     *            "created_at": "2018-02-27 13:58:58",
     *            "updated_at": "2018-02-27 14:57:11"
     *        }
     *    ]
     *}
     */
    public function index()
    {
        $roles = $this->roleRepository->getList();

        return $this->response->array($roles);
    }

    /**
     * @api {POST} /api/admin/permission_role /api/admin/permission_role{POST}
     * @apiDescription 新增角色權限
     * @apiGroup AdminPermissionRole
     * @apiPermission jwt
     * @apiParam {string} role[name]     權限群組代號
     * @apiParam {string} role[display_name]     權限群組名稱
     * @apiParam {array} [permission_ids] 權限id
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200
     * {
     * }
     * @apiErrorExample {json} Error-Response:
     * HTTP/1.1 403
     * {
     *     "message": "此權限群組代號已存在",
     *     "status_code": 403,
     * }
     * HTTP/1.1 422
     * {
     *     "message": "422 Unprocessable Entity",
     *     "errors": {...},
     *     "status_code": 422,
     *
     * }
     */
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

    /**
     * @api {GET} /api/admin/permission_role/:id /api/admin/permission_role/:id
     * @apiDescription 顯示其一角色權限
     * @apiGroup AdminPermissionRole
     * @apiPermission jwt
     * @apiParam {number} :id
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200
     *{
     *    "role": {
     *        "id": 1,
     *        "name": "Servitor",
     *        "display_name": "工讀生",
     *        "created_at": "2018-02-27 13:55:22",
     *        "updated_at": "2018-02-27 13:58:21"
     *    },
     *    "permission_ids": [
     *        "1",
     *        "2",
     *        "3"
     *    ]
     *}
     */
    public function show(int $id)
    {
        $role = $this->roleRepository->getOne($id);

        $permission_ids = $role->perms()->pluck('permission_id');

        return $this->response->array(['role' => $role, 'permission_ids' => $permission_ids]);
    }

    /**
     * @api {PUT} /api/admin/permission_role/:id /api/admin/permission_role/:id{PUT}
     * @apiDescription 修改角色權限
     * @apiGroup AdminPermissionRole
     * @apiPermission jwt
     * @apiParam {number} :id
     * @apiParam {stirng="PUT"} _method
     * @apiParam {string} role[name]     權限群組代號
     * @apiParam {string} role[display_name]     權限群組名稱
     * @apiParam {array} [permission_ids] 權限id
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200
     * {
     * }
     * @apiErrorExample {json} Error-Response:
     * HTTP/1.1 403
     * {
     *     "message": "此權限群組代號已存在",
     *     "status_code": 403,
     * }
     */
    public function update(int $id, RoleUpdateRequest $request)
    {
        $role = $this->roleRepository->getOne($id);

        $reqRole = $request->input('role');

        if (strtoupper($role->name) != strtoupper($reqRole['name'])) {
            $check = $this->roleRepository->checkNoUnique($reqRole['name']);

            if ($check == 1) {
                return $this->response->error('此權限群組代號已存在.', 403);
            }
        }

        $this->roleRepository->update($role, $reqRole);

        $reqPermissionIds = $request->input('permission_ids');

        $role->savePermissions(isset($reqPermissionIds) ? $reqPermissionIds : []);

        return $this->response->array('');
    }

    /**
     * @api {DELETE} /api/admin/permission_role/:id /api/admin/permission_role/:id{DEL}
     * @apiDescription 刪除角色權限
     * @apiGroup AdminPermissionRole
     * @apiPermission jwt
     * @apiParam {number} :id
     * @apiParam {stirng="DELETE"} _method
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200
     *{
     *}
     * HTTP/1.1 403
     *{
     *     "message": "權限群組有關聯使用者不可刪除",
     *     "status_code": 403,
     *}
     */
    public function destroy(int $id)
    {
        $role = $this->roleRepository->getOne($id);

        if ($role->id == 1) {
            return $this->response->error('最高權限不能刪除.', 403);
        }

        if ($role->users()->count() >= 1) {
            return $this->response->error('角色權限有關聯使用者不可刪除.', 403);
        }

        $role->delete();

        return $this->response->array('');
    }

    /**
     * @api {GET} /api/admin/permission_role/selects/api/admin/permission_role/selects{GET}
     * @apiDescription 下拉選單角色權限
     * @apiGroup AdminPermissionRole
     * @apiPermission jwt
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200
     *{
     *    "roles": [
     *        {
     *            "id": 1,
     *            "name": "Servitor"
     *        },
     *        {
     *            "id": 2,
     *            "name": "Admin"
     *        }
     *    ]
     *}
     */
    public function selects()
    {
        $result = $this->roleRepository->getSelects();

        return $this->response->array($result);
    }

    /**
     * @api {GET} /api/admin/permission_role_permissions /api/admin/permission_role_permissions
     * @apiDescription 權限列表
     * @apiGroup AdminPermissionRole
     * @apiPermission jwt
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200
     *{
     *    "1.作者": {
     *        "作者": [
     *            {
     *                "id": 3,
     *                "display_name": "修改"
     *            },
     *            {
     *                "id": 1,
     *                "display_name": "列表"
     *            },
     *            {
     *                "id": 4,
     *                "display_name": "刪除"
     *            },
     *            {
     *                "id": 2,
     *                "display_name": "新增"
     *            }
     *        ]
     *    },
     *    {...}
     *}
     */
    public function permissions()
    {
        $permissionGroups = $this->permissionGroupRepository->getList();

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
