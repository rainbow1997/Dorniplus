<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $adminRole = Role::create(['name'=>'Admin']);
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'region-list',
            'region-create',
            'region-edit',
            'region-delete',
            'post-list',
            'post-edit',
            'post-create',
            'post-delete',
            'category-list',
            'category-create',
            'category-edit',
            'category-delete',
            'chart-show',
            'log-list',
        ];

        foreach ($permissions as $permission) {
            $p = Permission::create(['name' => $permission]);
            $adminRole->givePermissionTo($p);
        }

    }
}
