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
        'code',
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

    public function assignedUsers()
    {
        return $this->belongsToMany(
            MsUser::class,
            'ms_users',          // tabel user
            'id',                // primary key user
            'id'                 // ini akan kita filter manual nanti
        )->whereIn('id', $this->assigned_user_ids ?? []);
    }

    public function getAssignedUsers()
    {
        if (empty($this->assigned_user_ids)) {
            return collect();
        }

        return MsUser::whereIn('id', $this->assigned_user_ids)
            ->select('id', 'name')
            ->get();
    }

}
