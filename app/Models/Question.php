<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'setup_question';

    protected $fillable = [
        'id', 'question', 'answer', 'ordering', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
