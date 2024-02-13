<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavbarSub extends Model
{
    use HasFactory;

    protected $table = 'master_submenus';

    protected $fillable = [
        'id', 'menu_id', 'name', 'route', 'ordering', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];
}
