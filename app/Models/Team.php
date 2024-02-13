<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $table = 'master_members';

    protected $fillable = [
        'id', 'user_id', 'image', 'name', 'place', 'date', 'gender', 'address', 'phone', 'email', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
