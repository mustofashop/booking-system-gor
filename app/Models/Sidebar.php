<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sidebar extends Model
{

    use HasFactory;

    protected $table = 'master_sidebars';

    protected $fillable = [
        'id', 'icon', 'name', 'description', 'permission_id', 'ordering', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    // Relationship with setup_sidebar_main
    public function sidebarMain()
    {
        return $this->hasMany(SetupSidebarMain::class, 'sidebar_id');
    }
}

