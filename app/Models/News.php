<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'setup_news';

    protected $fillable = [
        'id', 'image', 'title', 'desc', 'ordering', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
