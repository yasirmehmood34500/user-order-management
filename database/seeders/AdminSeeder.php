<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        User::truncate();
        $user = User::create([
            'name'=>'Admin',
            'email'=>'admin@gmail.com',
            'password'=> Hash::make(12345678)
        ]);
        $role           = Role::where('name','Admin')->first();


        $user->assignRole($role->id);
    }
}
