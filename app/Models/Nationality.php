<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nationality extends Model
{
    use HasFactory;

    protected $table = 'master_nationality';

    protected $fillable = [
        'id', 'name', 'code', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
