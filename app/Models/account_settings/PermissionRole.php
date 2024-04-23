<?php

namespace App\Models\account_settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionRole extends Model
{

    use HasFactory;
    protected $tabel = 'permission_roles';

    protected $fillable = [
        'role_id',
        'permission_id ',

    ];
}
