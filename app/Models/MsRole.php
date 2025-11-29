<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MsUser;
use App\Models\TrPermission;

class MsRole extends Model
{
    protected $table = "msrole";

    protected $fillable = ['name'];

    public function user()
    {
        return $this->hasMany(MsUser::class, 'roleId');
    }

    // Many-to-many dengan permission
    public function permissions()
    {
        return $this->belongsToMany(
            TrPermission::class,  // Model Permission
            'trRolePermission',    // Nama pivot table
            'role_id',            // FK ke role
            'permission_id'       // FK ke permission
        );

        
    }

}
