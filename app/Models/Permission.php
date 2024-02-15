<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'master_permissions';

    protected $fillable = [
        'name',
        'description',
        'level',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];
}
