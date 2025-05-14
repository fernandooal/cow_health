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

        Permission::create(['name' => 'ViewAny Ativo'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'View Ativo'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Create Ativo'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Update Ativo'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Delete Ativo'])->syncRoles([$admin, $superAdmin]);

        Permission::create(['name' => 'ViewAny Software'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'View Software'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Create Software'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Update Software'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Delete Software'])->syncRoles([$admin, $superAdmin]);

        Permission::create(['name' => 'ViewAny Fornecedor'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'View Fornecedor'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Create Fornecedor'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Update Fornecedor'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Delete Fornecedor'])->syncRoles([$admin, $superAdmin]);

        Permission::create(['name' => 'ViewAny Responsavel'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'View Responsavel'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Create Responsavel'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Update Responsavel'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Delete Responsavel'])->syncRoles([$admin, $superAdmin]);

        Permission::create(['name' => 'ViewAny Area'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'View Area'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Create Area'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Update Area'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Delete Area'])->syncRoles([$admin, $superAdmin]);

        Permission::create(['name' => 'ViewAny CentroResultado'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'View CentroResultado'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Create CentroResultado'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Update CentroResultado'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Delete CentroResultado'])->syncRoles([$admin, $superAdmin]);

        Permission::create(['name' => 'ViewAny Grupo'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'View Grupo'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Create Grupo'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Update Grupo'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Delete Grupo'])->syncRoles([$admin, $superAdmin]);

        Permission::create(['name' => 'ViewAny Categoria'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'View Categoria'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Create Categoria'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Update Categoria'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Delete Categoria'])->syncRoles([$admin, $superAdmin]);

        Permission::create(['name' => 'ViewAny Movimentacao'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'View Movimentacao'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Create Movimentacao'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Update Movimentacao'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Delete Movimentacao'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Export Movimentacao'])->syncRoles([$admin, $superAdmin]);

        Permission::create(['name' => 'ViewAny MovimentacaoSoftware'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'View MovimentacaoSoftware'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Create MovimentacaoSoftware'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Update MovimentacaoSoftware'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Delete MovimentacaoSoftware'])->syncRoles([$admin, $superAdmin]);
        Permission::create(['name' => 'Export MovimentacaoSoftware'])->syncRoles([$admin, $superAdmin]);
    }
}
