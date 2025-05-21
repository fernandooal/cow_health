<?php

namespace Database\Seeders;

use App\Enums\UserPerfil;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'ativo' => 1,
            'perfil' => UserPerfil::Admin,
            'password' => bcrypt('admin1234'),
        ]);

        $superAdmin = Role::create(['name' => 'SuperAdmin']);
        $admin = Role::create(['name' => UserPerfil::Admin->getLabel()]);


        $user->assignRole($superAdmin);

        Permission::create(['name' => 'ViewAny User'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'View User'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Create User'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Update User'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Delete User'])->syncRoles([$admin, $superAdmin]);

        Permission::create(['name' => 'ViewAny Cow'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'View Cow'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Create Cow'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Update Cow'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Delete Cow'])->syncRoles([$admin, $superAdmin]);

        Permission::create(['name' => 'ViewAny Farm'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'View Farm'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Create Farm'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Update Farm'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Delete Farm'])->syncRoles([$admin, $superAdmin]);

        Permission::create(['name' => 'ViewAny Collar'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'View Collar'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Create Collar'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Update Collar'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Delete Collar'])->syncRoles([$admin, $superAdmin]);
    }
}
