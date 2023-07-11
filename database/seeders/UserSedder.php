<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::factory(50)->create();
        foreach ($users as $user) {
            $user->assignRole('customer');
        }

        Product::factory(50)->create();
        

        User::create([
            'name' => 'Valeria',
            'lastname' => 'Herrera',
            'phone' => '3456789',
            'email' => 'admin@evertec.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'state' => true,
            'is_admin' => true,
         ])->assignRole('admin');

         User::create([
            'name' => 'Administrador',
            'lastname' => 'Principal',
            'phone' => '3205456789',
            'email' => 'superadmin@evertec.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'state' => true,
            'is_admin' => true,
         ])->assignRole('super_admin');
    }
}
