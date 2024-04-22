<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionBooking extends Model
{
    use HasFactory;

    protected $table = 'transaction_booking';

    protected $fillable = [
        'id', 'code', 'date', 'note', 'category', 'member_id', 'event_id', 'event_category_id', 'created_at', 'updated_at', 'created_by', 'updated_by'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id', 'id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }

    public function invoice()
    {
        return $this->hasOne(TransactionInvoice::class, 'booking_id', 'id');
    }
}
