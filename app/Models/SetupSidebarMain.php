<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SetupSidebarMain extends Model
{

    use HasFactory;

    protected $table = 'setup_sidebar_main';

    protected $fillable = [
        'id', 'name', 'description', 'sidebar_id', 'url', 'permission_id', 'ordering', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    // Relationship with master_sidebars
    public function masterSidebar()
    {
        return $this->belongsTo(Sidebar::class, 'sidebar_id');
    }

    // Relationship with Permission model
    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }
}

