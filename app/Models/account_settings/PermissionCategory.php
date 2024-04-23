<?php

namespace App\Models\account_settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionCategory extends Model
{
    use HasFactory;

    // protected $tabel = 'permission_role';

    protected $fillable = [
        'name',
    ];
}
