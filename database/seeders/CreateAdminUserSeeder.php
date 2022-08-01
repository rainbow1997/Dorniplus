<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'fname' => 'Dorniplus',
            'lname' => 'Admin',
            'email' => 'admin@dorniplus.smj',
            'password' => bcrypt('123456'),
            'email_verified_at' => now(),
            'national_code' => 123456879,
            'phone' => 123456789,
            'birth' => now(),
            'gender'=> 'male',
            'province_id' =>1,
            'city_id' => 1,
             'username' => 'admin',
            'is_email_verified' => 1

        ]);

        $role = Role::firstOrCreate(['name' => 'Admin']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
