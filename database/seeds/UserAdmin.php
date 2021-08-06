<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'profile_id'=>1,
            'name'=>'Super',
            'lastname'=>'Admin',
            'email'=>'Superadmin@gmail.com',
            'password'=>bcrypt('admin'),
            'role_id'=>1
        ]);
    }
}
