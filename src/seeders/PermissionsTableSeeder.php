<?php

/**
 *
 * @class PermissionsTableSeeder
 *
 * @author Rahul Sharma <rahul.sharma@surmountsoft.in>
 *
 * @copyright 2021 SurmountSoft Pvt. Ltd. All rights reserved.
 */
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('permissions')->truncate();
        $dateTime = date('Y-m-d H:i:s');
        $permissions = [
            //Agent Mgmt
            [
                'name' => 'Create Agent',
                'slug' => 'create_agent',
                'parent' => 3 ,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'name' => 'Edit Agent',
                'slug' => 'edit_agent',
                'parent' => 3 ,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'name' => 'View Agent',
                'slug' => 'view_agent',
                'parent' => 3 ,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'name' => 'Delete Agent',
                'slug' => 'delete_agent',
                'parent' => 3 ,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            //User Mgmt
            [
                'name' => 'Create User',
                'slug' => 'create_user',
                'parent' => 4 ,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'name' => 'Edit User',
                'slug' => 'edit_user',
                'parent' => 4 ,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'name' => 'View User',
                'slug' => 'view_user',
                'parent' => 4 ,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'name' => 'Delete User',
                'slug' => 'delete_user',
                'parent' => 4 ,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            //Role Mgmt
            [
                'name' => 'Create Role',
                'slug' => 'create_role',
                'parent' => 5 ,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'name' => 'Edit Role',
                'slug' => 'edit_role',
                'parent' => 5 ,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'name' => 'View Role',
                'slug' => 'view_role',
                'parent' => 5 ,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
            [
                'name' => 'Delete Role',
                'slug' => 'delete_role',
                'parent' => 5 ,
                'created_at' => $dateTime,
                'updated_at' => $dateTime
            ],
        ];
        \DB::table('permissions')->insert($permissions);
    }
}
