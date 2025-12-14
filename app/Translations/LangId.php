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
            "welcome" => [
                "welcome" => "Selamat Datang"
            ],
            "userManagement" => [
                // General
                'ListUser' => 'Daftar Pengguna',
                'ListPermission' => 'Daftar Izin', // "Izin" lebih umum untuk UI daripada "Perizinan"
                'ListRole' => 'Daftar Peran',
                'EditPermission' => 'Ubah Izin',
                'PermissionInfo' => 'Info Izin',
                'Name' => 'Nama',
                'Slug' => 'Slug', // Slug biasanya tetap "Slug" atau bisa "Pintasan URL" (tapi jarang)
                'AssignRoles' => 'Tetapkan Peran', // Lebih profesional daripada "Pilih Peran..."
                'Save' => 'Simpan',
                'Loading' => 'Memuat...',
                'Forbidden' => 'Akses Ditolak', // Atau "Tidak Diizinkan"

                // Permission
                'SuccessUpdate' => 'Izin Berhasil Diperbarui',
                'SuccessUpdateDesc' => 'Peran untuk izin ini telah berhasil diperbarui',
                'ErrorUpdate' => 'Gagal Memperbarui Izin',
                'ErrorUpdateDesc' => 'Terjadi kesalahan saat menyimpan data',
                'ErrorLoad' => 'Gagal Memuat Data Izin',
                'ErrorLoadDesc' => 'Terjadi kesalahan saat mengambil data izin',

                // Role management
                'EditRole' => 'Ubah Peran',
                'AddRole' => 'Tambah Peran',
                'RoleName' => 'Nama Peran',
                'RoleNameRequired' => 'Nama peran wajib diisi',
                'RoleNamePlaceholder' => 'Masukkan nama peran',
                'SuccessAddRole' => 'Peran berhasil ditambahkan',
                'SuccessEditRole' => 'Peran berhasil diperbarui',
                'ErrorAddRole' => 'Gagal menambahkan peran',
                'ErrorEditRole' => 'Gagal memperbarui peran',
                'ErrorAddRoleDesc' => 'Terjadi kesalahan saat menambahkan peran baru.',
                'ErrorEditRoleDesc' => 'Terjadi kesalahan saat menyimpan perubahan peran.',
                'ErrorLoadRole' => 'Gagal Memuat Data Peran',
                'ErrorLoadRoleDesc' => 'Terjadi kesalahan saat mengambil data peran',
                'SuccessDeleteRole' => 'Peran berhasil dihapus',
                'ErrorDeleteRole' => 'Gagal menghapus peran',
                'ErrorDeleteRoleDesc' => 'Terjadi kesalahan saat menghapus peran',
                'DeleteRoleConfirmTitle' => 'Hapus Peran?',
                'DeleteRoleConfirmText' => 'Apakah Anda yakin ingin menghapus peran ini? Tindakan ini tidak dapat dibatalkan.',
                'DeleteRoleConfirmOk' => 'Hapus',
                'DeleteRoleConfirmCancel' => 'Batal',

                // User detail
                'UserDetail' => 'Rincian Pengguna', // "Rincian" atau "Detail" keduanya oke
                'AddUser' => 'Tambah Pengguna',
                'EditUser' => 'Ubah Pengguna',
                'UserId' => 'ID Pengguna',
                'UserName' => 'Nama Lengkap',
                'UserEmail' => 'Email', // "Surel" adalah baku, tapi "Email" lebih umum dipahami
                'UserRole' => 'Peran',
                'UserPassword' => 'Kata Sandi',
                'UserPasswordPlaceholder' => 'Masukkan kata sandi',
                'UserPasswordRequired' => 'Kata sandi wajib diisi',
                'SuccessAddUser' => 'Pengguna berhasil ditambahkan',
                'SuccessEditUser' => 'Pengguna berhasil diperbarui',
                'ErrorAddUser' => 'Gagal menambahkan pengguna',
                'ErrorEditUser' => 'Gagal memperbarui pengguna',
                'ErrorAddUserDesc' => 'Terjadi kesalahan saat menambahkan pengguna baru.',
                'ErrorEditUserDesc' => 'Terjadi kesalahan saat menyimpan perubahan data pengguna.',
                'ErrorLoadUser' => 'Gagal Memuat Data Pengguna',
                'ErrorLoadUserDesc' => 'Terjadi kesalahan saat mengambil data pengguna',
                'SuccessDeleteUser' => 'Pengguna berhasil dihapus',
                'ErrorDeleteUser' => 'Gagal menghapus pengguna',
                'ErrorDeleteUserDesc' => 'Terjadi kesalahan saat menghapus pengguna',
                'DeleteUserConfirmTitle' => 'Hapus Pengguna?',
                'DeleteUserConfirmText' => 'Apakah Anda yakin ingin menghapus pengguna ini?',
                'DeleteUserConfirmOk' => 'Hapus',
                'DeleteUserConfirmCancel' => 'Batal',
                'SearchByName' => 'Cari nama...'
            ]
        ];
    }
}
