<?php

namespace App\Translations;

class LangId {
    public static function get() {
        return [
            "Sidebar" => [
                "appName" => "Antriku",
                "adminDashboard" => "Dashboard Admin",
                "userManagement" => "Manajemen Pengguna",
                "user" => "Pengguna",
                "role" => "Peran",
                "permission" => "Perizinan",
                "reports" => "Laporan",
                "service" => "Layanan",
                "staffDashboard" => "Dashboard Staff",
                "orders" => "Pesanan",
                "myDashboard" => "Dashboard Saya",
                "profile" => "Profil",
                "logout" => "Keluar"
            ],
            'Forbidden' => [
                'Forbidden' => 'Dilarang',
                'Sorry' => ' Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
                    Jika menurut Anda ini adalah kesalahan, silakan hubungi
                    administrator.'
            ],
            "welcome" => [
                "welcome" => "Selamat Datang"
            ],
            "userManagement" => [
                'ListUser' => 'Daftar Pengguna'
            ],
            "profile" => [
                'EditProfile' => 'Ubah Profile',
                'changePass' => 'Ganti Password',
                'name' => 'Nama',
                'NewPass' => 'Password Baru',
                'ConfirmPass' => 'Konfirmasi Password Saat Ini',
                'Save' => 'Simpan'
            ],
            'report' => [
                'GenerateServiceReport' => 'Hasilkan Laporan Layanan',
                'GenerateReport' => 'Hasilkan Laporan',
                'Keterangan' => 'Pilih tanggal dan klik tombol Generate PDF akan otomatis terbuka di tab baru.',
                'OpenManually' => 'Buka Manual PDF'
            ],
            'service' => [
                'page' => [
                    'ListService' => 'Daftar Layanan',
                    'AddLayanan' => 'Tambah Layanan',
                    'EditService' => 'Ubah Service'
                ],
                'AddService' => [
                    'Name' => 'Nama Service',
                    'ServiceCode' => 'Kode Service',
                    'Description' => 'Deskripsi',
                    'AssignStaf' => 'Tugaskan Staff',
                    'EstimatedTime' => 'Estimasi Waktu',
                    'Save' => 'Simpan',
                ],
            ],
        ];
    }
}
