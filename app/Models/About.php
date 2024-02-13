<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    protected $table = 'setup_counts';

    protected $fillable = [
        'id', 'image', 'count', 'title', 'ordering', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
