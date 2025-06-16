<?php

namespace Database\Seeders;

use App\Enums\CollarStatus;
use App\Enums\DataFrequency;
use App\Enums\UserPerfil;
use App\Models\AccelerometerData;
use App\Models\Collar;
use App\Models\Farm;
use App\Models\HeartRateData;
use App\Models\Permission;
use App\Models\Role;
use App\Models\TemperatureData;
use App\Models\User;
use Database\Factories\CollarFactory;
use Database\Factories\CowFactory;
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

        Farm::factory()->count(3)->create();

        CollarFactory::new()->create([
            'name' => 'chai_dev01',
            'status' => CollarStatus::OK,
            'data_frequency' => DataFrequency::Padrao,
        ]);

        CollarFactory::new()->create([
            'name' => 'Collar 2',
            'status' => CollarStatus::OK,
            'data_frequency' => DataFrequency::Rapido,
        ]);

        CowFactory::new()->create([
            'tag' => '123',
            'name' => 'Bessie',
            'birth_date' => '2020-01-01',
            'weight' => 500,
            'race' => 'Holstein',
            'status' => 'ok',
            'farm_id' => 1,
            'collar_id' => 1,
        ]);

        CowFactory::new()->create([
            'tag' => '456',
            'name' => 'Daisy',
            'birth_date' => '2021-02-15',
            'weight' => 550,
            'race' => 'Jersey',
            'status' => 'parto',
            'farm_id' => 2,
            'collar_id' => 2,
        ]);

        AccelerometerData::factory()->count(100)->create();
        TemperatureData::factory()->count(100)->create();
        HeartRateData::factory()->count(100)->create();
    }
}
