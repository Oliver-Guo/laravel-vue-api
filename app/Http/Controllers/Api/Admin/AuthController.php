<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt:api', ['except' => ['login']]);
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
     *     "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWwuYmVhdXRpbW9kZS5jb20vYXBpL2FkbWluL2xvZ2luIiwiaWF0IjoxNTE1NDc4NDEyLCJleHAiOjE1MTU0ODIwMTIsIm5iZiI6MTUxNTQ3ODQxMiwianRpIjoicG16ZTJiUnlvdncwVDRkayIsInN1YiI6NiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.Jcvl64MHpT4hI-lVVqFIjzlbCqEnPwLEnahtDf27pAg",
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

        if ($token = $this->guard()->attempt($credentials)) {

            return $this->respondWithToken($token);
        }

        return response()->json(['message' => 'Unauthorized.'], 401);
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
     *    "auths":[]
     *}
     * @apiErrorExample {json} Error-Response:
     * HTTP/1.1 401
     *{
     *    "message": "Unauthenticated.",
     *    "status_code": 401
     *}
     */
    public function me()
    {
        //個人擁有的權限群組 role
        $user_auths = [];
        $roles      = $this->guard()->user()->cachedRoles();

        if (!$roles->isEmpty()) {
            foreach ($this->guard()->user()->cachedRoles() as $role) {

                foreach ($role->cachedPermissions() as $perm) {

                    $user_auths[studly_case($perm->name)] = true;

                    $tmpDir = explode('_', $perm->name);

                    $dir = title_case($tmpDir[0]);

                    $user_auths[$dir] = true;
                }
            }
        }
        $user          = ($this->guard()->user()->toArray());
        $user['auths'] = $user_auths;

        return response()->json($user);
    }

    /**
     * @api {get} /api/admin/refresh /api/admin/refresh
     * @apiDescription 刷新token
     * @apiGroup AdminAuth
     * @apiPermission jwt
     * @apiVersion 0.1.0
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200
     * {
     *     "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWwuYmVhdXRpbW9kZS5jb20vYXBpL2FkbWluL2xvZ2luIiwiaWF0IjoxNTE1NDc4NDEyLCJleHAiOjE1MTU0ODIwMTIsIm5iZiI6MTUxNTQ3ODQxMiwianRpIjoicG16ZTJiUnlvdncwVDRkayIsInN1YiI6NiwicHJ2IjoiMjNiZDVjODk0OWY2MDBhZGIzOWU3MDFjNDAwODcyZGI3YTU5NzZmNyJ9.Jcvl64MHpT4hI-lVVqFIjzlbCqEnPwLEnahtDf27pAg",
     *     "token_type": "bearer",
     *     "expires_in": 3600
     * }
     * @apiErrorExample {json} Error-Response:
     * HTTP/1.1 401
     *{
     *    "message": "Unauthenticated.",
     *    "status_code": 401
     *}
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
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
        $this->guard()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => $this->guard()->factory()->getTTL() * 60,
        ]);
    }

    public function guard()
    {
        return Auth::guard();
    }
}
