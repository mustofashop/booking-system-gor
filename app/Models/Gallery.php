<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $table = 'setup_galleries';

    protected $fillable = [
        'id', 'image', 'title', 'desc', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
