<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

app('Dingo\Api\Exception\Handler')->register(function (Illuminate\Auth\AuthenticationException $exception) {
    return Response::make(['message' => 'Unauthenticated.', 'status_code' => 401], 401);
});
app('Dingo\Api\Exception\Handler')->register(function (Tymon\JWTAuth\Exceptions\TokenInvalidException $exception) {
    return Response::make(['message' => 'Unauthenticated.', 'status_code' => 401], 401);
});
app('Dingo\Api\Exception\Handler')->register(function (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
    return Response::make(['message' => 'NotFound.', 'status_code' => 404], 404);
});

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {

    $api->group(['middleware' => ['cors', 'apitimestamp']], function ($api) {

        $api->post('admin/login', 'App\Http\Controllers\Api\Admin\AuthController@login');

        $api->group(['prefix' => 'admin', 'namespace' => 'App\Http\Controllers\Api\Admin'], function ($api) {

            $api->get('logout', 'AuthController@logout');
            $api->get('me', 'AuthController@me');

            $api->get('tag/rs_search/{name}', 'TagController@rsSearch');

            $api->get('article/rs_search/{keyword}', 'ArticleController@rsSearch');

            $api->put('author/ch_is_online/{id}', 'AuthorController@chIsOnline');
            $api->get('author/selects', 'AuthorController@selects');
            $api->resource('author', 'AuthorController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
            $api->delete('author', 'AuthorController@deletes');

            $api->put('topic_category/ch_is_online/{id}', 'TopicCategoryController@chIsOnline');
            $api->put('topic_category/ch_sort', 'TopicCategoryController@chSort');
            $api->resource('topic_category', 'TopicCategoryController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
            $api->delete('topic_category', 'TopicCategoryController@deletes');

            $api->put('topic/ch_is_online/{id}', 'TopicController@chIsOnline');
            $api->resource('topic', 'TopicController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
            $api->delete('topic', 'TopicController@deletes');

            $api->get('permission_role/selects', 'RoleController@selects');
            $api->resource('permission_role', 'RoleController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
            $api->get('permission_role_permissions', 'RoleController@permissions');

            $api->resource('permission_user', 'UserController', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
            $api->get('permission_user_roles', 'UserController@roles');

        });
    });

});
