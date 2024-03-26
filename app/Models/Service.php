<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'master_service';

    protected $fillable = [
        'id', 'cost', 'member_id', 'code', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }
}
