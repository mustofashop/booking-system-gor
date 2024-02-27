<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'master_members';

    protected $fillable = [
        'id', 'code', 'image', 'name', 'nickname', 'place', 'date', 'gender', 'height', 'weight', 'address', 'phone', 'email', 'socmed', 'status',
        'created_by', 'created_at', 'updated_by', 'updated_at', 'number_booking', 'number_identity', 'story', 'banner'
    ];
}
