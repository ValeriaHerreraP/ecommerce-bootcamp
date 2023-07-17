<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleUser = Role::create(['name' => 'customer']);
        $roleSuperAdmin = Role::create(['name' => 'super_admin']);

        Permission::create(['name' => 'dashboard'])->syncRoles([$roleAdmin, $roleUser, $roleSuperAdmin]);

        Permission::create(['name' => 'users.index'])->syncRoles([$roleAdmin, $roleSuperAdmin]);
        Permission::create(['name' => 'users.edit'])->syncRoles([$roleAdmin, $roleSuperAdmin]);
        Permission::create(['name' => 'users.destroy'])->syncRoles([$roleAdmin, $roleSuperAdmin]);
        Permission::create(['name' => 'users.updateStateEnable'])->syncRoles([$roleAdmin, $roleSuperAdmin]);
        Permission::create(['name' => 'users.updateStateDisable'])->syncRoles([$roleAdmin, $roleSuperAdmin]);

        Permission::create(['name' => 'products.index'])->syncRoles([$roleAdmin, $roleSuperAdmin]);
        Permission::create(['name' => 'products.create'])->syncRoles([$roleAdmin, $roleSuperAdmin]);
        Permission::create(['name' => 'products.edit'])->syncRoles([$roleAdmin, $roleSuperAdmin]);
        Permission::create(['name' => 'products.updateStateEnable'])->syncRoles([$roleAdmin, $roleSuperAdmin]);
        Permission::create(['name' => 'products.updateStateDisable'])->syncRoles([$roleAdmin, $roleSuperAdmin]);
        Permission::create(['name' => 'products.destroy'])->syncRoles([$roleAdmin, $roleSuperAdmin]);
        Permission::create(['name' => 'products.export'])->assignRole([$roleSuperAdmin]);
        Permission::create(['name' => 'products.import'])->assignRole([$roleSuperAdmin]);

        Permission::create(['name' => 'cart.shop'])->syncRoles([$roleAdmin, $roleUser]);
        Permission::create(['name' => 'cart.index'])->syncRoles([$roleAdmin, $roleUser]);
        Permission::create(['name' => 'cart.store'])->syncRoles([$roleAdmin, $roleUser]);
        Permission::create(['name' => 'cart.update'])->syncRoles([$roleAdmin, $roleUser]);
        Permission::create(['name' => 'cart.remove'])->syncRoles([$roleAdmin, $roleUser]);
        Permission::create(['name' => 'cart.clear'])->syncRoles([$roleAdmin, $roleUser]);

        Permission::create(['name' => 'payments.detailsPayments'])->syncRoles([$roleAdmin, $roleUser]);
        Permission::create(['name' => 'cart.resultPayments'])->syncRoles([$roleAdmin, $roleUser]);
        Permission::create(['name' => 'payments.index'])->syncRoles([$roleAdmin, $roleUser]);
        Permission::create(['name' => 'payments.detailsOrder'])->syncRoles([$roleAdmin, $roleUser]);
        Permission::create(['name' => 'payments.retryOrder'])->syncRoles([$roleAdmin, $roleUser]);

        Permission::create(['name' => 'reports.general'])->assignRole([$roleSuperAdmin]);
        Permission::create(['name' => 'reports.DetailMonth'])->assignRole([$roleSuperAdmin]);
    }
}
