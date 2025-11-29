<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\MsRole;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil role ID dari tabel msrole
        $admin = MsRole::where('name', 'admin')->value('id');
        $staff = MsRole::where('name', 'staff')->value('id');
        $customer = MsRole::where('name', 'customer')->value('id');

        DB::table('msuser')->insert([
            [
                'name' => 'customer',
                'email' => 'customer@gmail.com',
                'password' => Hash::make('password123'),
                'roleId' => $customer
            ],
            [
                'name' => 'superadmin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('password123'),
                'roleId' => $admin
            ],
            [
                'name' => 'staff',
                'email' => 'staff@gmail.com',
                'password' => Hash::make('password123'),
                'roleId' => $staff
            ],
        ]);
    }
}
