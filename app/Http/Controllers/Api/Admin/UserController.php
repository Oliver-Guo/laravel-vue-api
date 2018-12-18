<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\Admin\Controller;
use App\Http\Requests\Api\Admin\UserCreateRequest;
use App\Http\Requests\Api\Admin\UserUpdateRequest;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;
    protected $roleRepository;

    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        parent::__construct();

        $this->middleware('permission:permission_user_list', ['only' => ['index']]);
        $this->middleware('permission:permission_user_add', ['only' => ['store']]);
        $this->middleware('permission:permission_user_edit', ['only' => ['show', 'update']]);
        $this->middleware('permission:permission_user_del', ['only' => ['destroy']]);

        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * @api {GET} /api/admin/permission_user /api/admin/permission_user
     * @apiDescription 使用者列表
     * @apiGroup AdminPermissionUser
     * @apiPermission jwt
     * @apiParam {number} [page]    當前第幾頁 (default :1)
     * @apiParam {number} [paginate]  一頁幾項  (default :20)
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200
     *{
     *    "current_page": 1,
     *    "data": [
     *        {
     *            "id": 1,
     *            "name": "Oliver Kuo",
     *            "email": "oliver@example.com",
     *            "roles": [
     *                {
     *                    "id": 1,
     *                    "name": "Admin",
     *                    "display_name": "最高權限"
     *                }
     *            ]
     *        }
     *    ],
     *    "from": 1,
     *    "last_page": 1,
     *    "next_page_url": null,
     *    "path": "http://local.beautimode.com/be/api/admin/permission_user",
     *    "per_page": 20,
     *    "prev_page_url": null,
     *    "to": 14,
     *    "total": 14
     *}
     */
    public function index(Request $request)
    {
        $search = $request->all();

        $result = $this->userRepository->getList($search);

        return $this->response->array($result);
    }

    /**
     * @api {POST} /api/admin/permission_user /api/admin/permission_user{POST}
     * @apiDescription 新增使用者
     * @apiGroup AdminPermissionUser
     * @apiPermission none
     * @apiParam {string} user[name]     名稱
     * @apiParam {email} user[email]     帳號
     * @apiParam {string} user[password]  密碼
     * @apiParam {string} user[password_confirmation]  再次確認密碼
     * @apiParam {array} [role_ids] 角色權限群組id
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200
     * {
     * }
     * @apiErrorExample {json} Error-Response:
     * HTTP/1.1 403
     * {
     *     "message": "此信箱已註冊",
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
    public function store(UserCreateRequest $request)
    {
        $reqUser = $request->input('user');

        $checkUser = $this->userRepository->getCheckOneField('email', $reqUser['email']);

        if (!is_null($checkUser)) {
            return $this->response->error('此信箱已註冊.', 403);
        }

        $user = $this->userRepository->create($reqUser);

        if ($user->id > 0) {

            $reqRoleIds = $request->input('role_ids');

            if (isset($reqRoleIds) && is_array($reqRoleIds)) {
                $user->saveRoles($reqRoleIds);
            }

        }

        return $this->response->array('');
    }

    /**
     * @api {GET} /api/admin/permission_user:id /api/admin/permission_user/:id
     * @apiDescription 顯示其一使用者
     * @apiGroup AdminPermissionUser
     * @apiPermission jwt
     * @apiParam {number} :id
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200
     *{
     *    "user": {
     *        "id": 1,
     *        "name": "Oliver Kuo",
     *        "email": "oliver@example.com",
     *        "role_ids": [
     *            1
     *        ]
     *    }
     *}
     */
    public function show(int $id)
    {
        $user = $this->userRepository->getOne($id);

        $role_ids = $user->roles()->pluck('role_id');

        return $this->response->array(['user' => $user, 'role_ids' => $role_ids]);
    }

    /**
     * @api {PUT} /api/admin/permission_user/:id /api/admin/permission_user/:id{PUT}
     * @apiDescription 修改使用者
     * @apiGroup AdminPermissionUser
     * @apiPermission none
     * @apiParam {stirng="PUT"} _method
     * @apiParam {string} user[name]     名稱
     * @apiParam {string} [user[password]]  密碼
     * @apiParam {string} [user[password_confirmation]]  再次確認密碼
     * @apiParam {array} [role_ids] 角色權限群組id
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200
     * {
     * }
     * @apiErrorExample {json} Error-Response:
     * HTTP/1.1 422
     * {
     *     "message": "422 Unprocessable Entity",
     *     "errors": {...},
     *     "status_code": 422,
     *
     * }
     */
    public function update(int $id, UserUpdateRequest $request)
    {
        $user = $this->userRepository->getOne($id);

        $reqUser = $request->input('user');

        if (isset($reqUser['password'])) {
            $reqUser['password'] = bcrypt($reqUser['password']);
        }

        $this->userRepository->update($user, $reqUser);

        $reqRoleIds = $request->input('role_ids');

        $user->saveRoles(isset($reqRoleIds) ? $reqRoleIds : []);

        return $this->response->array('');
    }

    /**
     * @api {DELETE} /api/admin/permission_user/:id /api/admin/permission_user/:id{DEL}
     * @apiDescription 刪除使用者
     * @apiGroup AdminPermissionUser
     * @apiPermission jwt
     * @apiParam {stirng="DELETE"} _method
     * @apiParam {number} :id
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200
     *{
     *}
     */
    public function destroy(int $id)
    {
        $user = $this->userRepository->getOne($id);

        if ($user->id == 1) {
            return $this->response->error('最高管理者不能刪除.', 403);
        }

        $this->userRepository->softdel($id);

        return $this->response->array('');
    }
}
