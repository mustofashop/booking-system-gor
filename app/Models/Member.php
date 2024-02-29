<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'master_members';

    protected $fillable = [
        'id', 'code', 'user_id', 'image', 'name', 'nickname', 'place', 'date', 'gender',
        'height', 'weight', 'address', 'phone', 'email', 'socmed', 'number_booking', 'number_identity', 'story', 'banner', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
