<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $table = 'master_members';

    protected $fillable = [
        'id', 'code', 'member_id', 'nationality_id', 'image', 'name', 'nickname', 'place', 'date', 'gender', 'height', 'weight', 'address', 'phone', 'email', 'socmed', 'status',
        'created_by', 'created_at', 'updated_by', 'updated_at', 'number_booking', 'number_identity', 'story', 'banner', 'event_id'
    ];

    public function point()
    {
        return $this->hasMany(TransactionPoint::class, 'member_id', 'id');
    }

    public function nations()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id', 'id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'member_id', 'id');
    }
}
