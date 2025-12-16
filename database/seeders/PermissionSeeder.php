<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            ['name' => 'Permission', 'slug' => 'permission'],
            ['name' => 'View User Management', 'slug' => 'view-user-management'],
            ['name' => 'View Role Management', 'slug' => 'view-role-management'],
            ['name' => 'View Permission Management', 'slug' => 'view-permission-management'],
            ['name' => 'View Service Management', 'slug' => 'view-Service-management'],
            ['name' => 'View Berita Management', 'slug' => 'view-berita-management'],
        ];

        foreach ($permissions as $permission) {
            DB::table('trPermission')->updateOrInsert(
                ['slug' => $permission['slug']],
                ['name' => $permission['name'], 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }
}
