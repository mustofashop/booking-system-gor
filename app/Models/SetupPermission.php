<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetupPermission extends Model
{
    use HasFactory;

    protected $table = 'setup_user_permission';

    protected $fillable = [
        'user_id',
        'permission_id',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}
