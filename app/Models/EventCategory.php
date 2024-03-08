<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    use HasFactory;

    protected $table = 'master_event_category';

    protected $fillable = [
        'id', 'title', 'description', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
