<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Repositories\PermissionRepository;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login']]);
    }

    /**
     * @api {post} /api/admin/login /api/admin/login
     * @apiDescription 登入產生一個token
     * @apiGroup AdminAuth
     * @apiPermission none
     * @apiParam {email} email     帳號
     * @apiParam {string} password  密碼
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200
     * {
     *     "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.xxx.xxx",
     *     "token_type": "bearer",
     *     "expires_in": 3600
     * }
     * @apiErrorExample {json} Error-Response:
     * HTTP/1.1 401
     * {
     *     "message": "Unauthorized."
     * }
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password'); //email change name or id etc...

        if ($token = auth()->attempt($credentials)) {

            return $this->respondWithToken($token);
        }

        return response()->json(['message' => '帳號或密碼錯誤'], 401);
    }

    /**
     * @api {get} /api/admin/me /api/admin/me
     * @apiDescription 登入的使用者資訊
     * @apiGroup AdminAuth
     * @apiPermission jwt
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200
     *{
     *    "id": 6,
     *    "name": "bbbbbb",
     *    "email": "bb@bb.bb",
     *    "remember_token": null,
     *    "permissions": {
     *    }
     *}
     * @apiErrorExample {json} Error-Response:
     * HTTP/1.1 401
     *{
     *    "message": "Unauthenticated.",
     *    "status_code": 401
     *}
     */
    public function me(PermissionRepository $permissionRepository)
    {
        $user_auths = [];

        //全部權限預設為false
        $permissions = $permissionRepository->getAll();

        foreach ($permissions as $permission) {

            $tmpDir = explode('_', $permission);
            $dir    = title_case($tmpDir[0]);

            $auth = studly_case($permission);

            $user_auths[$dir]  = false;
            $user_auths[$auth] = false;

        }

        //個人擁有的權限群組 role
        $roles = auth()->user()->cachedRoles();

        if (!$roles->isEmpty()) {
            foreach (auth()->user()->cachedRoles() as $role) {

                foreach ($role->cachedPermissions() as $perm) {

                    $user_auths[studly_case($perm->name)] = true;

                    $tmpDir = explode('_', $perm->name);

                    $dir = title_case($tmpDir[0]);

                    $user_auths[$dir] = true;
                }
            }
        }

        $user                = auth()->user()->toArray();
        $user['permissions'] = $user_auths;

        return response()->json($user);
    }

    /**
     * @api {get} /api/admin/logout /api/admin/logout
     * @apiDescription 使用者登出
     * @apiGroup AdminAuth
     * @apiPermission jwt
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200
     *{
     *}
     * @apiErrorExample {json} Error-Response:
     * HTTP/1.1 401
     *{
     *    "message": "Unauthenticated.",
     *    "status_code": 401
     *}
     */
    public function logout()
    {
        auth()->logout(true);

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL() * 60,
        ]);
    }
}
