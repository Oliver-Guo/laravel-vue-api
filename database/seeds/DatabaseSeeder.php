<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ArticlesTableSeeder::class);

        $users = [
            'name'     => 'test(最高權限)',
            'email'    => 'test@example.com',
            'password' => bcrypt('test1234'), // test1234
        ];
        DB::table('users')->insert($users);

        $permission_groups = [
            ['id' => 1, 'group_name' => '作者專區', 'sort' => 1],
            ['id' => 2, 'group_name' => '權限管理', 'sort' => 9],
            ['id' => 3, 'group_name' => '專題', 'sort' => 2],
        ];

        DB::table('permission_groups')->insert($permission_groups);

        $roles = [
            'id'           => 1,
            'name'         => 'Admin',
            'display_name' => '最高權限',
        ];

        DB::table('roles')->insert($roles);

        $role_user = [
            'user_id' => 1,
            'role_id' => 1,
        ];

        DB::table('role_user')->insert($role_user);

        $permissions = [
            [
                'id'                  => 1,
                'name'                => 'author_list',
                'permission_group_id' => 1,
                'display_type'        => '作者',
                'display_name'        => '列表',
                'sort'                => 1,
            ],
            [
                'id'                  => 2,
                'name'                => 'author_add',
                'permission_group_id' => 1,
                'display_type'        => '作者',
                'display_name'        => '新增',
                'sort'                => 2,
            ],
            [

                'id'                  => 3,
                'name'                => 'author_edit',
                'permission_group_id' => 1,
                'display_type'        => '作者',
                'display_name'        => '編輯',
                'sort'                => 3,
            ],
            [

                'id'                  => 4,
                'name'                => 'author_del',
                'permission_group_id' => 1,
                'display_type'        => '作者',
                'display_name'        => '刪除',
                'sort'                => 4,
            ],
            [

                'id'                  => 5,
                'name'                => 'permission_user_list',
                'permission_group_id' => 2,
                'display_type'        => '2.管理使用者',
                'display_name'        => '列表',
                'sort'                => 1,

            ],
            [
                'id'                  => 6,
                'name'                => 'permission_user_add',
                'permission_group_id' => 2,
                'display_type'        => '2.管理使用者',
                'display_name'        => '新增',
                'sort'                => 2,

            ],
            [
                'id'                  => 7,
                'name'                => 'permission_user_edit',
                'permission_group_id' => 2,
                'display_type'        => '2.管理使用者',
                'display_name'        => '編輯',
                'sort'                => 3,
            ],
            [

                'id'                  => 8,
                'name'                => 'permission_user_del',
                'permission_group_id' => 2,
                'display_type'        => '2.管理使用者',
                'display_name'        => '刪除',
                'sort'                => 4,

            ],
            [
                'id'                  => 9,
                'name'                => 'permission_role_list',
                'permission_group_id' => 2,
                'display_type'        => '1.管理權限群組',
                'display_name'        => '列表',
                'sort'                => 1,

            ],
            [
                'id'                  => 10,
                'name'                => 'permission_role_add',
                'permission_group_id' => 2,
                'display_type'        => '1.管理權限群組',
                'display_name'        => '新增',
                'sort'                => 2,

            ],
            [

                'id'                  => 11,
                'name'                => 'permission_role_edit',
                'permission_group_id' => 2,
                'display_type'        => '1.管理權限群組',
                'display_name'        => '編輯',
                'sort'                => 3,
            ],
            [

                'id'                  => 12,
                'name'                => 'permission_role_del',
                'permission_group_id' => 2,
                'display_type'        => '1.管理權限群組',
                'display_name'        => '刪除',
                'sort'                => 4,

            ],
            [
                'id'                  => 13,
                'name'                => 'topic_category_list',
                'permission_group_id' => 3,
                'display_type'        => '1.專題分類',
                'display_name'        => '列表',
                'sort'                => 1,

            ],
            [
                'id'                  => 14,
                'name'                => 'topic_category_add',
                'permission_group_id' => 3,
                'display_type'        => '1.專題分類',
                'display_name'        => '新增',
                'sort'                => 2,

            ],
            [
                'id'                  => 15,
                'name'                => 'topic_category_edit',
                'permission_group_id' => 3,
                'display_type'        => '1.專題分類',
                'display_name'        => '編輯',
                'sort'                => 3,

            ],
            [
                'id'                  => 16,
                'name'                => 'topic_category_del',
                'permission_group_id' => 3,
                'display_type'        => '1.專題分類',
                'display_name'        => '刪除',
                'sort'                => 4,
            ],
            [

                'id'                  => 17,
                'name'                => 'topic_list',
                'permission_group_id' => 3,
                'display_type'        => '2.專題',
                'display_name'        => '列表',
                'sort'                => 1,

            ],
            [
                'id'                  => 18,
                'name'                => 'topic_add',
                'permission_group_id' => 3,
                'display_type'        => '2.專題',
                'display_name'        => '新增',
                'sort'                => 2,

            ],
            [
                'id'                  => 19,
                'name'                => 'topic_edit',
                'permission_group_id' => 3,
                'display_type'        => '2.專題',
                'display_name'        => '編輯',
                'sort'                => 3,

            ],
            [
                'id'                  => 20,
                'name'                => 'topic_del',
                'permission_group_id' => 3,
                'display_type'        => '2.專題',
                'display_name'        => '刪除',
                'sort'                => 4,

            ],
        ];

        DB::table('permissions')->insert($permissions);

        DB::insert('Insert into permission_role(permission_id,role_id) select id,1 from permissions');

    }
}
