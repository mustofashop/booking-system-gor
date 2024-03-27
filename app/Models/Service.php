<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'setup_cost';

    protected $fillable = [
        'id', 'code', 'category', 'name', 'description', 'amount', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
