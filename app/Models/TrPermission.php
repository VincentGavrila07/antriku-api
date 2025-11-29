<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MsRole;

class TrPermission extends Model
{
    protected $table = 'trPermission';

    protected $fillable = ['name', 'slug'];

    public function roles()
    {
        return $this->belongsToMany(
            MsRole::class,
            'trRolePermission',
            'permission_id',
            'role_id'
        );
    }
}
