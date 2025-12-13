<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class, // seed permission dulu
            RoleSeeder::class,       // seed role + assign permission
            UserSeeder::class,       // seed user
            MsServiceSeeder::class,  // seed layanan  // seed layanan yang diambil customer
        ]);
    }
    
}
