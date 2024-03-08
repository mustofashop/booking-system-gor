<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionPoint extends Model
{
    use HasFactory;

    protected $table = 'transaction_point';

    protected $fillable = [
        'id', 'member_id', 'event_id', 'category_id', 'point_rank', 'point_participation', 'total_point',
        'rank', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(EventCategory::class, 'category_id', 'id');
    }
}
