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
                'name' => 'Vincent',
                'email' => 'vincent@gmail.com',
                'password' => Hash::make('password123'),
                'roleId' => $customer
            ],
            [
                'name' => 'Farhan',
                'email' => 'farhan@gmail.com',
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
                'name' => 'Dokter Danish',
                'email' => 'dokterumum@gmail.com',
                'password' => Hash::make('password123'),
                'roleId' => $staff
            ],
            [
                'name' => 'Dokter Angel',
                'email' => 'doktergigi@gmail.com',
                'password' => Hash::make('password123'),
                'roleId' => $staff
            ],
        ]);
    }
}
