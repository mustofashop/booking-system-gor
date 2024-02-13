<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $table = 'setup_stories';

    protected $fillable = [
        'id', 'image', 'title', 'desc', 'ordering', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
