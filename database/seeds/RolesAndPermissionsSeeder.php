<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();


        // create permissions
        Permission::create(['name' => 'create users', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete users', 'guard_name' => 'api']);
        Permission::create(['name' => 'update users', 'guard_name' => 'api']);

        // create roles and assign created permissions

        // or may be done by chaining
        $role = Role::create(['name' => 'admin', 'guard_name' => 'api','opcmenu'=>'1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22'])
            ->givePermissionTo([
                'create users',
                'delete users',
                'update users'
            ]);
            $role = Role::create(['name' => 'Financiero', 'guard_name' => 'api','opcmenu'=>'1,2,4'])
            ->givePermissionTo([
                'create users',
                'delete users',
                'update users'
            ]);
            $role = Role::create(['name' => 'Contenidos', 'guard_name' => 'api','opcmenu'=>'5,10,11,12,13,14,16,18'])
            ->givePermissionTo([
                'create users',
                'delete users',
                'update users'
            ]);

        $role = Role::create(['name' => 'super-admin', 'guard_name' => 'api']);
        $role->givePermissionTo(Permission::all());

        $user = User::create([
            'profile_id'=>1,
            'name'=>'Super',
            'lastname'=>'Admin',
            'email'=>'Superadmin@gmail.com',
            'password'=>bcrypt('admin'),
            'role_id'=>1
        ]);

        $user->assignRole('super-admin');
    }
}
