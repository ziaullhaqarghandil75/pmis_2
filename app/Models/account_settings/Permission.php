<?php

namespace App\Models\account_settings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'permission_gategory_id',
        'status',
    ];

    //  * Get the user that owns the Permission
    //  *
    //  * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    //  */
    public function permission_categories()
    {
        $this->belongsTo(PermissionCategory::class, 'id', 'permission_gategory_id', 'permission_categories');
    }
   
    public function roles()
    {
        return $this->belongsToMany(Role::class,'permission_roles');

    }
}
