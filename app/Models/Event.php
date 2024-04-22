<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'master_events';

    protected $fillable = [
        'id', 'image', 'title', 'description', 'date', 'time', 'location', 'maps', 'ordering', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function booking()
    {
        return $this->hasMany(TransactionBooking::class, 'event_id', 'id');
    }

    public function member()
    {
        return $this->hasMany(Member::class, 'event_id', 'id');
    }
}
