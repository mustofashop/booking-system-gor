<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $table = 'setup_testimonials';

    protected $fillable = [
        'id', 'image', 'name', 'position', 'desc', 'ordering', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
