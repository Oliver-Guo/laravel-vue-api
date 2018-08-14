<?php

namespace App\Http\Controllers\Api\Admin\Permission;

use App\Http\Controllers\Api\Admin\Controller;
use App\Http\Requests\Api\Admin\Permission\UserCreateRequest;
use App\Http\Requests\Api\Admin\Permission\UserUpdateRequest;
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

    public function index(Request $request)
    {
        $search = $request->all();

        $result = $this->userRepository->getList($search);

        return $this->response->array($result);
    }

    public function store(UserCreateRequest $request)
    {
        $reqUser = $request->input('user');

        $checkUser = $this->userRepository->getCheckOneField('email', $reqUser['email']);

        if (!is_null($checkUser)) {
            return $this->response->error('此帳號已註冊.', 403);
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

    public function show($id)
    {
        $user = $this->userRepository->getOne($id);

        $role_ids = $user->roles()->pluck('role_id');

        return $this->response->array(['user' => $user, 'role_ids' => $role_ids]);
    }

    public function update(UserUpdateRequest $request, $id)
    {
        $orig = $this->userRepository->getOne($id);

        $user = $request->input('user');

        if (isset($user['password'])) {
            $user['password'] = bcrypt($user['password']);
        }

        $this->userRepository->update($id, $user);

        $reqRoleIds = $request->input('role_ids');

        $orig->saveRoles(isset($reqRoleIds) ? $reqRoleIds : []);

        return $this->response->array('');
    }

    public function destroy($id)
    {
        $this->userRepository->softdel($id);

        return $this->response->array('');
    }
}
