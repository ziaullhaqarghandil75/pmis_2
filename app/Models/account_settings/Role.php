<?php

namespace App\Models\account_settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Role extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'status',
    ];


    // public function Permissions(){
    //     return $this->;
    // }
    public function Permissions()
    {
        return $this->belongsToMany(Permission::class,'permission_roles');
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
