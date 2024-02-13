<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Button extends Model
{
    use HasFactory;

    protected $table = 'setup_buttons';

    protected $fillable = [
        'id', 'code', 'title', 'url', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
