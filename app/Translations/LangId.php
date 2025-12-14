<?php

namespace App\Translations;

class LangId
{
    public static function get()
    {
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
            'order' => [
                'OrderService' => 'Order Layanan',
                'SuccessBooking' => 'Booking Berhasil',
                'QueueNumber' => 'Nomor antrian kamu',
                'ErrorBooking' => 'Booking Gagal',
                'ActiveQueueExists' => 'Masih Ada Antrian Yang Aktif',
                'InvalidUserOrService' => 'User atau Service tidak valid',
                'PleaseRelogin' => 'Silakan login ulang',
                'BookingTitle' => 'Pesan',
                'Book' => 'Pesan',
                'SelectStaff' => 'Pilih Staff',
                'SelectStaffRequired' => 'Pilih staff',
                'ArrivalDate' => 'Tanggal Kedatangan',
                'ArrivalDateRequired' => 'Pilih tanggal kedatangan',
            ],
            'serviceHistory' => [
                'Service' => 'Layanan',
                'ServiceHistory' => 'Riwayat Layanan',
                'ErrorLoadServiceHistory' => 'Gagal Memuat Riwayat Layanan',
                'ErrorLoadServiceHistoryDesc' => 'Terjadi kesalahan saat mengambil data riwayat layanan',
                'Status' => 'Status',
                'Waiting' => 'Menunggu',
                'Completed' => 'Selesai',
                'Cancelled' => 'Dibatalkan',
                'QueueDate' => 'Tanggal Antrian',
            ],
            'dashboard' => [
                'Loading' => 'Memuat...',
                'AdminDashboard' => 'Dashboard Admin',
                'Welcome' => 'Selamat Datang,',
                'Administrator' => 'ADMINISTRATOR',
                'ServerTime' => 'Waktu Server',
                'TotalPatients' => 'Total Pasien',
                'Growth' => 'Pertumbuhan +12%',
                'TotalStaff' => 'Total Staf',
                'ActiveDoctors' => '4 Dokter Aktif',
                'TodayQueues' => 'Antrean Hari Ini',
                'BusySmooth' => 'Ramai Lancar', // Istilah umum untuk kepadatan yang terkendali
                'ActiveServices' => 'Layanan Aktif',
                'ServiceStatusAndQueue' => 'Status Layanan & Antrean',
                'SearchServiceOrStaff' => 'Cari Layanan atau Staf...',
                'ServiceName' => 'Nama Layanan',
                'Status' => 'Status',
                'Staff' => 'Staf',
                'Queue' => 'Antrean',
                'People' => '{count} orang',
                'Open' => 'Buka',
                'Break' => 'Istirahat',
                'Closed' => 'Tutup',
                'Online' => 'online',
                'Busy' => 'sibuk',
                'Offline' => 'offline',
                'PatientDashboard' => 'Dashboard Pasien',
                'WelcomeBack' => 'Selamat datang kembali, {name}',
                'YourActiveQueue' => 'ANTREAN AKTIF ANDA',
                'QueueNumber' => 'Nomor Antrean',
                'WaitingProcess' => 'MENUNGGU PROSES',
                'InProcess' => 'SEDANG DIPROSES',
                'Service' => 'Layanan',
                'Estimate' => 'Estimasi',
                'BeingServed' => 'Sedang Dilayani',
                'NoActiveQueue' => 'Tidak ada antrean aktif',
                'ServiceList' => 'DAFTAR LAYANAN',
                'Information' => 'INFORMASI',
                'Latest' => 'TERBARU',
                'RainySeasonHealth' => 'Tetap Sehat di Musim Hujan',
                'ImmunityTips' => 'Tips menjaga imun tubuh tetap bugar saat musim pancaroba.',
                'MyProfile' => 'PROFIL SAYA',
                'RegularPatient' => 'Pasien Reguler',
                'Verified' => 'TERVERIFIKASI',
                'Email' => 'Email',
                'PhoneNumber' => 'Nomor Telepon',
                'ViewProfileDetail' => 'Lihat Detail Profil',
                'NoInitialNote' => 'Tidak ada catatan awal',
                'StaffDashboard' => 'Staf',
                'CurrentSession' => 'SESI SAAT INI',
                'InitialComplaint' => 'KELUHAN AWAL / CATATAN:',
                'FinishQueue' => 'Selesaikan Layanan',
                'NoPatientInService' => 'Tidak ada pasien yang sedang dilayani',
                'StartQueue' => 'Mulai Layanan: {name}',
                'NoQueue' => 'Tidak Ada Antrean',
                'MyQueue' => 'ANTREAN SAYA ({count})',
                'Next' => 'BERIKUTNYA',
                'TotalServingToday' => 'Total Melayani (Hari Ini)',
                'AllServices' => 'Semua Layanan',
                'Notes' => 'CATATAN',
                'BreakNote' => 'Istirahat',
                'MonthlyMeeting' => 'Rapat Bulanan',
                'NewNotePlaceholder' => 'Catatan baru...',
                'CheckIn' => 'Daftar Kedatangan',
            ],
        ];
    }
}
