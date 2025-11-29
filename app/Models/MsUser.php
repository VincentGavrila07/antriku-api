<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; 
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class MsUser extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasApiTokens;
    protected $table = 'msuser'; 

    protected $fillable = [
        'name',
        'email',
        'password',
        'roleId',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed', 
    ];

    public function role()
    {
        return $this->belongsTo(MsRole::class, 'roleId');
    }
}
