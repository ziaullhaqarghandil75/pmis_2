<?php

namespace App\Models\Plan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depratment extends Model
{
    use HasFactory;
    protected $table = 'departments';
    protected $fillable = [
        'name_da',
        'name_en',
        'status',
    ];
}
