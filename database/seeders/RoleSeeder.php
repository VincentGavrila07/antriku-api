<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Insert roles
        DB::table('msrole')->insert([
            ['name' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'customer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'staff', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Assign all permissions ke admin
        $adminRoleId = DB::table('msrole')->where('name', 'admin')->value('id');
        $permissions = DB::table('trPermission')->pluck('id')->toArray();

        foreach ($permissions as $permissionId) {
            DB::table('trRolePermission')->updateOrInsert(
                [
                    'role_id' => $adminRoleId,
                    'permission_id' => $permissionId
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );
        }
    }
}
