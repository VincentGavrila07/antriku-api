<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MsService extends Model
{
    use HasFactory;

    protected $table = 'ms_services'; // Pastikan nama tabel benar

    protected $fillable = [
        'name',
        'description',
        'assigned_user_ids',
        'estimated_time',
        'is_active'
    ];

    // INI KUNCINYA: Casting JSON ke Array
    protected $casts = [
        'assigned_user_ids' => 'array',
        'is_active' => 'boolean',
        'estimated_time' => 'string',
    ];

    // Relasi ke Transaksi
    public function transactions()
    {
        return $this->hasMany(TrService::class, 'service_id');
    }
}
