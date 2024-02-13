<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Navbar extends Model
{
    use HasFactory;

    protected $table = 'master_menus';

    protected $fillable = [
        'id', 'name', 'route', 'ordering', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function navbarsub()
    {
        return $this->hasMany(NavbarSub::class, 'menu_id', 'id');
    }
}
