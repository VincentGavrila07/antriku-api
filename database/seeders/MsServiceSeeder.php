<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MsServiceSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'Poli Umum',
                'description' => 'Pemeriksaan kesehatan umum.',
                // Assign Vincent (ID 2) disini
                'assigned_user_ids' => json_encode([5]),
                'estimated_time' => '00:30:00',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Poli Gigi',
                'description' => 'Kesehatan gigi.',
                // Vincent (ID 2) juga bantu disini
                'assigned_user_ids' => json_encode([6]),
                'estimated_time' => '00:30:00',
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('ms_services')->insert($data);
    }
}
