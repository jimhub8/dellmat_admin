<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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

        // create users
        Permission::create(['guard_name' => 'web', 'name' =>  'delete users']);
        Permission::create(['guard_name' => 'web', 'name' =>  'edit users']);
        Permission::create(['guard_name' => 'web', 'name' =>  'create users']);
        Permission::create(['guard_name' => 'web', 'name' =>  'view users']);

        Permission::create(['guard_name' => 'web', 'name' =>  'create subscribers']);
        Permission::create(['guard_name' => 'web', 'name' =>  'delete subscribers']);
        Permission::create(['guard_name' => 'web', 'name' =>  'view subscribers']);
        Permission::create(['guard_name' => 'web', 'name' =>  'edit subscriber']);

        Permission::create(['guard_name' => 'web', 'name' =>  'view orders']);
        Permission::create(['guard_name' => 'web', 'name' =>  'delete orders']);
        Permission::create(['guard_name' => 'web', 'name' =>  'create orders']);
        Permission::create(['guard_name' => 'web', 'name' =>  'edit orders']);

        Permission::create(['guard_name' => 'web', 'name' =>  'edit scan']);
        Permission::create(['guard_name' => 'web', 'name' =>  'inscan']);
        Permission::create(['guard_name' => 'web', 'name' =>  'outscan']);

        Permission::create(['guard_name' => 'web', 'name' =>  'view sales']);
        Permission::create(['guard_name' => 'web', 'name' =>  'create sales']);
        Permission::create(['guard_name' => 'web', 'name' =>  'edit sales']);
        Permission::create(['guard_name' => 'web', 'name' =>  'delete sales']);

        Permission::create(['guard_name' => 'web', 'name' =>  'create roles']);
        Permission::create(['guard_name' => 'web', 'name' =>  'view roles']);
        Permission::create(['guard_name' => 'web', 'name' =>  'delete roles']);
        Permission::create(['guard_name' => 'web', 'name' =>  'edit roles']);

        Permission::create(['guard_name' => 'web', 'name' =>  'upload excel']);
        Permission::create(['guard_name' => 'web', 'name' =>  'update status']);

        Permission::create(['guard_name' => 'web', 'name' =>  'view finance']);
        Permission::create(['guard_name' => 'web', 'name' =>  'view reports']);
        Permission::create(['guard_name' => 'web', 'name' =>  'send sms']);
        Permission::create(['guard_name' => 'web', 'name' =>  'view logs']);


        // create Super admin
        $role = Role::create(['guard_name' => 'web', 'name' => 'Super admin']);
        $role->givePermissionTo(Permission::all());

        // this can be done as separate statements
        // $role = Role::create(['guard_name' => 'web', 'name' => 'Admin']);
        // $role->givePermissionTo('view users');

        // $role = Role::create(['guard_name' => 'clients', 'name' => 'Client']);
        // $role->givePermissionTo('view orders');

        $user = new User();
        $user->password = Hash::make('password');
        $user->name = 'Jimmy';
        $user->email = 'jimlaravel@gmail.com';
        $user->email_verified_at = now();
        $user->phone = '0700000000';
        $user->save();
        $user->assignRole('Super admin');
    }
}
