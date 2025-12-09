<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TrServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = Carbon::now()->format('Y-m-d');
        $data = [];

        // ==========================================
        // SKENARIO 1: POLI UMUM (Service ID 1)
        // Kamu mau dapat antrian ke-8.
        // Berarti kita harus buat 7 orang dummy dulu.
        // ==========================================

        for ($i = 1; $i <= 7; $i++) {
            $data[] = [
                'service_id' => 1,
                'user_id' => 2, // Kita pinjam ID Vincent (Staff) pura-pura jadi pasien biar FK aman
                // Format nomor: A-001, A-002, dst
                'queue_number' => 'A-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'status' => 'completed', // Orang sebelum kamu sudah selesai
                'queue_date' => $today,
                'estimated_time' => Carbon::now()->subMinutes((8 - $i) * 15)->format('H:i:s'),
                'created_at' => Carbon::now()->subMinutes((8 - $i) * 10),
                'updated_at' => Carbon::now(),
            ];
        }

        // NAH INI KAMU (Antrian ke-8)
        $data[] = [
            'service_id' => 1,
            'user_id' => 1, // ID Kamu
            'queue_number' => 'A-008', // Sesuai request
            'status' => 'waiting',     // Kamu sedang menunggu
            'queue_date' => $today,
            'estimated_time' => Carbon::now()->addMinutes(15)->format('H:i:s'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];


        // ==========================================
        // SKENARIO 2: POLI GIGI (Service ID 2)
        // Kamu mau dapat antrian ke-5.
        // Berarti kita buat 4 orang dummy dulu.
        // ==========================================

        for ($i = 1; $i <= 4; $i++) {
            $data[] = [
                'service_id' => 2,
                'user_id' => 2, // Pinjam ID Vincent lagi
                'queue_number' => 'B-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'status' => 'processing', // Masih ada yang diperiksa
                'queue_date' => $today,
                'estimated_time' => Carbon::now()->subMinutes((5 - $i) * 30)->format('H:i:s'),
                'created_at' => Carbon::now()->subMinutes((5 - $i) * 20),
                'updated_at' => Carbon::now(),
            ];
        }

        // NAH INI KAMU LAGI (Antrian ke-5)
        $data[] = [
            'service_id' => 2,
            'user_id' => 1, // ID Kamu
            'queue_number' => 'B-005', // Sesuai request
            'status' => 'waiting',
            'queue_date' => $today,
            'estimated_time' => Carbon::now()->addMinutes(45)->format('H:i:s'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        DB::table('tr_services')->insert($data);
    }
}
