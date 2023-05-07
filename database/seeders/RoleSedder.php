<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleUser = Role::create(['name' => 'customer']);

        Permission::create(['name' => 'dashboard'])->syncRoles([$roleAdmin, $roleUser]);

        Permission::create(['name' => 'users.index'])-> assignRole($roleAdmin); 
        Permission::create(['name' => 'users.edit'])-> assignRole($roleAdmin); 
        Permission::create(['name' => 'users.destroy'])-> assignRole($roleAdmin);
        Permission::create(['name' => 'users.updateState'])-> assignRole($roleAdmin);

        

    }
}
