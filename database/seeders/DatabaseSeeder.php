<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(30)->create();

        \App\Models\User::factory()->create([
            'name' => 'Valeria',
            'lastname' => 'Herrera',
            'phone' => '3456789',
            'email' => 'admin@evertec.com',
            'state' => true,
            'is_admin' => true,
         ]);
    }
}
