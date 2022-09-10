<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::insert([
            [
                'name'=>'Admin',
                'guard_name'=>'web'
            ],[
                'name'=>'User',
                'guard_name'=>'web'
            ],[
                'name'=>'Company',
                'guard_name'=>'web'
            ]
        ]);
    }
}
